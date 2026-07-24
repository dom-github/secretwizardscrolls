<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../lib/logger.php';

log_debug('create-payment-intent.php hit');

$config = require __DIR__ . '/../config/stripe.php';

log_debug('Stripe config loaded', [
    'has_secret' => !empty($config['secret_key']),
]);

\Stripe\Stripe::setApiKey($config['secret_key']);

$PRICES = [
    'one_chapter' => [
        'amount' => 2500, // $25.00
        'label'  => '1 Chapter'
    ],
    'two_chapters' => [
        'amount' => 4000, // $40.00
        'label'  => '2 Chapters'
    ],
    'scheherezade' => [
        'amount' => 45000, // $450.00
        'label'  => 'Scheherezade'
    ],
];

$raw = file_get_contents('php://input');
log_debug('Raw input received', $raw);

$data = json_decode($raw, true);

if (!$data) {
    log_debug('JSON decode failed');
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}
$email  = $data['email'] ?? null;
$message = $data['message'] ?? null;
$option = $data['option'] ?? null;
$tale = $data['tale'] ?? null;

if (!isset($PRICES[$option])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid price option']);
    exit;
}

$price = $PRICES[$option];

log_debug('Parsed input', compact('email', 'message', 'option', 'tale'));

try {
    log_debug('Creating PaymentIntent');

    $intent = \Stripe\PaymentIntent::create([
        'amount' => $price['amount'],
        'currency' => 'cad',
        'payment_method_types' => ['card'],
        'receipt_email' => $email,
        'metadata' => [
            'tale' => $tale,
            'message' => $message,
            'option'  => $option,
            'label'   => $price['label'],
        ],
    ]);

    log_debug('PaymentIntent created', [
        'id' => $intent->id,
        'status' => $intent->status,
    ]);

    echo json_encode([
        'clientSecret' => $intent->client_secret
    ]);

} catch (\Stripe\Exception\ApiErrorException $e) {
    log_debug('Stripe API error', [
        'message' => $e->getMessage(),
        'type' => get_class($e),
    ]);

    http_response_code(500);
    echo json_encode(['error' => 'Stripe error']);
} catch (Throwable $e) {
    log_debug('General error', $e->getMessage());
    http_response_code(500);
}
