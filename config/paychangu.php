<?php
// PayChangu Configuration
class PayChanguConfig {
    // Test/Sandbox credentials (replace with your actual credentials from PayChangu dashboard)
    const TEST_SECRET_KEY = 'your_test_secret_key_here';
    const TEST_PUBLIC_KEY = 'your_test_public_key_here';
    
    // Production credentials (replace when going live)
    const LIVE_SECRET_KEY = 'your_live_secret_key_here';
    const LIVE_PUBLIC_KEY = 'your_live_public_key_here';
    
    // Environment settings
    const IS_LIVE = false; // Set to true for production
    
    // API URLs
    const TEST_BASE_URL = 'https://api.paychangu.com/test';
    const LIVE_BASE_URL = 'https://api.paychangu.com/live';
    
    // Webhook URLs
    const WEBHOOK_URL = 'https://yourdomain.com/model/paychanguWebhook.php';
    const RETURN_URL = 'https://yourdomain.com/order-success.php';
    const CANCEL_URL = 'https://yourdomain.com/checkout.php';
    
    // Get current environment settings
    public static function getSecretKey() {
        return self::IS_LIVE ? self::LIVE_SECRET_KEY : self::TEST_SECRET_KEY;
    }
    
    public static function getPublicKey() {
        return self::IS_LIVE ? self::LIVE_PUBLIC_KEY : self::TEST_PUBLIC_KEY;
    }
    
    public static function getBaseUrl() {
        return self::IS_LIVE ? self::LIVE_BASE_URL : self::TEST_BASE_URL;
    }
}
?>