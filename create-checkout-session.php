<?php
// Set your Stripe secret key
require_once 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51OFNsJIkmtRoILPuygkKzZFCef76nt6TdogKJpIVkEJ1APb5aIwiRbJQpvhXTGiOtS5YIRYPz2ljtIAelvKOSO4Q00e10msfaV');

// Retrieve the quantity and price ID from the request
$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
$quantity = $data->quantity;
$priceId = $data->priceId;

try {
    // Create a Checkout Session
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price' => $priceId,
                'quantity' => $quantity,
            ],
        ],
        'mode' => 'payment',
        'success_url' => 'http://localhost/laburi/pls/php-project/success.php', // Replace with your success URL
        'cancel_url' => 'http://localhost/laburi/pls/php-project/cancel.php', // Replace with your cancel URL
    ]);

    // Return the Checkout Session ID to the client
    echo json_encode(['id' => $checkout_session->id]);
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Handle API errors
    http_response_code($e->getHttpStatus());
    echo json_encode(['error' => $e->getMessage()]);
} catch (Exception $e) {
    // Handle other errors
    http_response_code(500);
    echo json_encode(['error' => 'An internal server error occurred.']);
}
