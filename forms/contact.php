<?php
require_once 'EmailForm.php';

// Replace with your actual receiving email address
$receiving_email_address = 'ericzkabambe@gmail.com'; // Replace with your actual email

$contact = new EmailForm();
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'] ?? '';
$contact->from_email = $_POST['email'] ?? '';
$contact->subject = $_POST['subject'] ?? 'Contact Form Message';

// Try without SMTP first (comment out if it doesn't work)
 $contact->smtp = [
     'host' => 'smtp.gmail.com',
     'username' => 'zetherique@gmail.com',
     'password' => 'R1C0@GM41L',
     'port' => 587
 ];

$contact->add_message($_POST['name'] ?? '', 'Name');
$contact->add_message($_POST['email'] ?? '', 'Email');
$contact->add_message($_POST['message'] ?? '', 'Message', 10);


// Add error logging
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

echo $contact->send();
