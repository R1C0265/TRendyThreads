# PayChangu Integration Setup Guide

## Overview
PayChangu has been integrated into your Trendy Threads e-commerce system. Customers can now pay using mobile money (Airtel Money, TNM Mpamba) and bank transfers through PayChangu's payment gateway.

## Setup Steps

### 1. Get PayChangu API Credentials
1. Log into your PayChangu merchant dashboard
2. Navigate to API Settings or Developer section
3. Copy your:
   - Test Secret Key0
   - Test Public Key
   - Live Secret Key (for production)
   - Live Public Key (for production)

### 2. Configure API Credentials
Edit `/config/paychangu.php` and replace the placeholder values:

```php
const TEST_SECRET_KEY = 'your_actual_test_secret_key';
const TEST_PUBLIC_KEY = 'your_actual_test_public_key';
const LIVE_SECRET_KEY = 'your_actual_live_secret_key';
const LIVE_PUBLIC_KEY = 'your_actual_live_public_key';
```

### 3. Setup Database Tables
Run the database setup script:
```bash
php model/createPaymentTables.php
```

### 4. Configure Webhook URL
In your PayChangu dashboard, set the webhook URL to:
```
https://yourdomain.com/model/paychanguWebhook.php
```

### 5. Update Domain URLs
In `/config/paychangu.php`, update these URLs with your actual domain:
```php
const WEBHOOK_URL = 'https://yourdomain.com/model/paychanguWebhook.php';
const RETURN_URL = 'https://yourdomain.com/order-success.php';
const CANCEL_URL = 'https://yourdomain.com/checkout.php';
```

## Testing

### Test Mode
- Set `IS_LIVE = false` in paychangu.php
- Use test credentials
- PayChangu provides test phone numbers and scenarios
- No real money is charged

### Production Mode
- Set `IS_LIVE = true` in paychangu.php
- Use live credentials
- Real transactions will be processed
- PayChangu will charge per transaction fees

## Features Implemented

### Customer Experience
1. **Payment Selection**: PayChangu appears as "PayChangu (Mobile Money)" option
2. **Phone Number Input**: Customer enters mobile money number
3. **Payment Processing**: Redirected to PayChangu or receives mobile prompt
4. **Status Tracking**: Real-time payment status updates
5. **Order Completion**: Automatic order processing on successful payment

### Admin Features
1. **Transaction Tracking**: All PayChangu transactions logged in database
2. **Payment Status**: Orders show payment status (pending/paid/failed)
3. **Notifications**: Admin notifications for PayChangu sales
4. **Webhook Handling**: Automatic payment confirmations

## Payment Flow

1. Customer adds items to cart
2. Proceeds to checkout
3. Selects "PayChangu (Mobile Money)"
4. Enters mobile money number
5. Gets redirected to PayChangu or receives mobile prompt
6. Completes payment on their phone
7. PayChangu sends webhook confirmation
8. Order is automatically completed
9. Stock is updated and cart is cleared

## Supported Payment Methods via PayChangu

- **Airtel Money**: 088xxxxxxx numbers
- **TNM Mpamba**: 099xxxxxxx numbers  
- **Bank Transfers**: Various Malawian banks
- **Credit/Debit Cards**: Via PayChangu's card processing

## Transaction Fees

PayChangu typically charges:
- **Testing**: Free
- **Production**: ~2-3% + small fixed fee per transaction
- **No setup fees**: No monthly or setup charges

## Security Features

- **Webhook Verification**: Validates PayChangu callbacks
- **Amount Verification**: Ensures payment amounts match orders
- **Transaction Logging**: Complete audit trail
- **Status Tracking**: Prevents duplicate processing

## Troubleshooting

### Common Issues
1. **Invalid phone number**: Must be valid Malawian format (088/099/085/084)
2. **Webhook not working**: Check URL configuration in PayChangu dashboard
3. **Payment timeout**: Customer has 5 minutes to complete payment
4. **Amount mismatch**: Verify cart totals match payment amounts

### Debug Mode
Check error logs for PayChangu API responses and webhook data.

## Files Created/Modified

### New Files
- `/config/paychangu.php` - Configuration
- `/model/processPayChanguOrder.php` - Payment processing
- `/model/checkPaymentStatus.php` - Status checking
- `/model/paychanguWebhook.php` - Webhook handler
- `/model/createPaymentTables.php` - Database setup

### Modified Files
- `/checkout.php` - Added PayChangu payment option and JavaScript
- `/employee/sales.php` - Added PayChangu to employee sales form

## Next Steps

1. **Test Integration**: Use PayChangu test credentials to verify functionality
2. **Go Live**: Switch to production credentials when ready
3. **Monitor Transactions**: Check PayChangu dashboard for transaction reports
4. **Customer Support**: Train staff on PayChangu payment process

## Support

- **PayChangu Support**: Contact PayChangu for API issues
- **Integration Support**: Check webhook logs and transaction status
- **Customer Issues**: Guide customers through mobile money payment process