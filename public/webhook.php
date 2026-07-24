<?php
// public/webhook.php

require __DIR__ . '/../vendor/autoload.php';

// Load Stripe config
$config = require __DIR__ . '/../config/stripe.php';

use Stripe\Webhook;

// Read the raw payload and signature
$payload = file_get_contents('php://input');
$sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null;

// Verify the webhook signature
try {
    $event = Webhook::constructEvent(
        $payload,
        $sigHeader,
        $config['webhook_secret']
    );
} catch (\Throwable $e) {
    // Invalid signature or payload
    http_response_code(400);
    exit;
}

file_put_contents(
    __DIR__ . '/../data/event_types.log',
    $event->type . PHP_EOL,
    FILE_APPEND
);

// We only care about successful payments
if ($event->type !== 'payment_intent.succeeded') {
    http_response_code(200);
    exit;
}

// --- PAYMENT SUCCEEDED ---
$intent = $event->data->object;
$intentId = $intent->id;

// ---------- IDEMPOTENCY ----------
$processedFile = __DIR__ . '/../data/processed_intents.json';

// Load already processed intents
$processed = [];
if (file_exists($processedFile)) {
    $processed = json_decode(file_get_contents($processedFile), true) ?? [];
}

// If we've already handled this payment, exit safely
if (in_array($intentId, $processed, true)) {
    http_response_code(200);
    exit;
}

// ---------- FULFILLMENT BLOCK ----------

// Extract customer data
$email = $intent->receipt_email ?? null;
$message = $intent->metadata->message ?? '';
$option = $intent->metadata->option;
$tale = $intent->metadata->tale;
$label  = $intent->metadata->label;

// Save order (simple flat-file example)
$order = [
    'payment_intent' => $intentId,
    'email' => $email,
    'message' => $message,
    'option' => $option,
    'tale' => $tale,
    'label' => $label,
    'amount' => $intent->amount,
    'created' => time(),
];

// Append order to file
file_put_contents(
    __DIR__ . '/../data/orders.json',
    json_encode($order) . PHP_EOL,
    FILE_APPEND
);

// ---------- END FULFILLMENT ----------

// Mark this PaymentIntent as processed
$processed[] = $intentId;

file_put_contents(
    $processedFile,
    json_encode($processed)
);

// Respond 200 so Stripe knows we're done
http_response_code(200);
