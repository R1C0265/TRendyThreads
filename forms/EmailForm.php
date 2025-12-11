<?php

class EmailForm {
    private $to;
    private $from_name;
    private $from_email;
    private $subject;
    private $messages = [];
    private $smtp = null;
    public $ajax = false;
    
    public function __construct() {
        // Constructor
    }
    
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
    
    public function add_message($value, $label, $min_length = 1) {
        $value = $this->sanitize_input($value);
        
        if (strlen($value) < $min_length) {
            throw new Exception("$label must be at least $min_length characters long");
        }
        
        $this->messages[] = [
            'label' => $label,
            'value' => $value
        ];
    }
    
    private function sanitize_input($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
    
    private function validate_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public function send() {
        try {
            // Validate required fields
            if (empty($this->to) || empty($this->from_email) || empty($this->subject)) {
                throw new Exception('Missing required fields');
            }
            
            if (!$this->validate_email($this->to) || !$this->validate_email($this->from_email)) {
                throw new Exception('Invalid email address');
            }
            
            // Build message body
            $message_body = $this->build_message();
            
            // Send email
            if ($this->smtp) {
                return $this->send_smtp($message_body);
            } else {
                return $this->send_mail($message_body);
            }
            
        } catch (Exception $e) {
            if ($this->ajax) {
                return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            return 'Error: ' . $e->getMessage();
        }
    }
    
    private function build_message() {
        $message = "New message from contact form:\n\n";
        
        foreach ($this->messages as $msg) {
            $message .= $msg['label'] . ": " . $msg['value'] . "\n";
        }
        
        return $message;
    }
    
    private function send_mail($message_body) {
        $headers = [
            'From: ' . $this->from_name . ' <' . $this->from_email . '>',
            'Reply-To: ' . $this->from_email,
            'X-Mailer: PHP/' . phpversion(),
            'Content-Type: text/plain; charset=UTF-8'
        ];
        
        $success = mail($this->to, $this->subject, $message_body, implode("\r\n", $headers));
        
        if ($this->ajax) {
            return json_encode([
                'status' => $success ? 'success' : 'error',
                'message' => $success ? 'Message sent successfully!' : 'Failed to send message'
            ]);
        }
        
        return $success ? 'OK' : 'Error sending email';
    }
    
    private function send_smtp($message_body) {
        if (!$this->smtp || !isset($this->smtp['host'])) {
            throw new Exception('SMTP configuration missing');
        }
        
        // Basic SMTP implementation
        $socket = fsockopen($this->smtp['host'], $this->smtp['port'] ?? 587, $errno, $errstr, 30);
        
        if (!$socket) {
            throw new Exception("SMTP connection failed: $errstr ($errno)");
        }
        
        // SMTP conversation
        $this->smtp_command($socket, null, '220');
        $this->smtp_command($socket, 'EHLO ' . ($_SERVER['HTTP_HOST'] ?? 'localhost'), '250');
        
        // Start TLS for Gmail
        if ($this->smtp['port'] == 587) {
            $this->smtp_command($socket, 'STARTTLS', '220');
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            $this->smtp_command($socket, 'EHLO ' . ($_SERVER['HTTP_HOST'] ?? 'localhost'), '250');
        }
        
        if (isset($this->smtp['username']) && isset($this->smtp['password'])) {
            $this->smtp_command($socket, 'AUTH LOGIN', '334');
            $this->smtp_command($socket, base64_encode($this->smtp['username']), '334');
            $this->smtp_command($socket, base64_encode($this->smtp['password']), '235');
        }
        
        $this->smtp_command($socket, 'MAIL FROM: <' . $this->from_email . '>', '250');
        $this->smtp_command($socket, 'RCPT TO: <' . $this->to . '>', '250');
        $this->smtp_command($socket, 'DATA', '354');
        
        $email_data = "From: {$this->from_name} <{$this->from_email}>\r\n";
        $email_data .= "To: {$this->to}\r\n";
        $email_data .= "Subject: {$this->subject}\r\n";
        $email_data .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $email_data .= $message_body . "\r\n.\r\n";
        
        $this->smtp_command($socket, $email_data, '250');
        $this->smtp_command($socket, 'QUIT', '221');
        
        fclose($socket);
        
        if ($this->ajax) {
            return json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
        }
        
        return 'OK';
    }
    
    private function smtp_command($socket, $command, $expected_code) {
        if ($command !== null) {
            fwrite($socket, $command . "\r\n");
        }
        
        $response = '';
        do {
            $line = fgets($socket, 512);
            $response .= $line;
            $code = substr($line, 0, 3);
        } while (substr($line, 3, 1) === '-');
        
        if ($code !== $expected_code) {
            throw new Exception("SMTP Error: $response");
        }
        
        return $response;
    }
}