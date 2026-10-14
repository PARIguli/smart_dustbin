<?php
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;

// Your Twilio credentials
$sid = "YOUR_TWILIO_ACCOUNT_SID";
$token = "YOUR_TWILIO_AUTH_TOKEN";

// Get dustbin level
$level = $_GET['level'] ?? 95;

try {
    $twilio = new Client($sid, $token);

    $message = $twilio->messages->create(
        "+923192044724", // Your number
        [
            'from' => "+00000000000", // Your Twilio number
            'body' => "🚨 SMART DUSTBIN DATABASE PROJECT\n\nDustbin is {$level}% full!\nStatus: CRITICAL\nTime: " . date('Y-m-d H:i:s') . "\n\nPlease empty immediately!"
        ]
    );

    echo "✅ SMS sent to your phone! Check your messages.";
    
} catch (Exception $e) {
    echo "❌ SMS failed: " . $e->getMessage();
}
?>