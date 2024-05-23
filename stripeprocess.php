<?php
include 'dbconnect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'stripe-php/init.php';
\Stripe\Stripe::setApiKey('sk_test_51PGNx2J9ml5ZL2Dpv4rnjrpSZE5cOvuU7qZI71qLbgzZMkapQTjGcHNyTz1bBwQC8ReAHjymNQ8nfmbSkChR4w9Q00pGJpV5d0');

header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON data received from the client
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Check if required data is present in the request
    if (isset($requestData['payment_method_id']) && isset($requestData['total_price'])) {
        // Retrieve data from the request
        $paymentMethodId = $requestData['payment_method_id'];
        $totalPrice = $requestData['total_price'];
        $reservation_id = $requestData['x_room'];
        $userId = $requestData['x_user'];
        // Check if the user is logged in and retrieve the user ID
        session_start(); // Start the session
        if (isset($_SESSION['x_userid'])) {

            try {
                // Create a PaymentIntent with the provided payment method and amount
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'payment_method' => $paymentMethodId,
                    'amount' => $totalPrice * 100, // Convert amount to cents
                    'currency' => 'myr',
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'return_url' => 'https://hrs/manage.php', // Specify the return URL here
                ]);

                // Insert transaction data into the database
                $paymentIntentId = $paymentIntent->id;
                $paymentStatus = 'Success'; // Assign the value 'Success' to a variable
                $paymentCurrency = 'myr';
                $payment_method = 'Debit';
                
                // Prepare SQL statement
                $sql = "INSERT INTO transactions (reservation_id, payment_intent_id, user_id, payment_amount, payment_currency, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($sql);

                // Bind parameters
                $stmt->bind_param("sssssss", $reservation_id, $paymentIntentId, $userId, $totalPrice, $paymentCurrency, $payment_method, $paymentStatus);

                // Execute statement
                if ($stmt->execute()) {
                    // If transaction is recorded successfully, send a success response
                    $response = ['success' => true, 'message' => 'Transaction recorded successfully'];
                    http_response_code(200);
                    echo json_encode($response);
                } else {
                    // If error occurred while recording transaction, send an error response
                    $response = ['success' => false, 'message' => 'Error recording transaction'];
                    http_response_code(500);
                    echo json_encode($response);
                }
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // If error occurred during payment processing, send an error response
                $response = ['success' => false, 'message' => 'Error processing payment: ' . $e->getMessage()];
                http_response_code(500);
                echo json_encode($response);
            }
        } else {
            // If user is not logged in, send a response indicating authentication failure
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
        }
    } else {
        // If required data is missing in the request, send a response indicating bad request
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Bad request']);
    }
} else {
    // If request method is not POST, send a response indicating method not allowed
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
}
