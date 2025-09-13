<?php
// File: tuition/db/gemini_chat.php

// This file handles the backend communication with the Gemini API.

header('Content-Type: application/json');

// Get the user's message from the POST request
$userMessage = isset($_POST['message']) ? $_POST['message'] : '';

// Check if the message is empty
if (empty($userMessage)) {
    echo json_encode(['error' => 'No message provided.']);
    exit;
}

// Replace with your actual Gemini API key.
// IMPORTANT: In a production environment, never hardcode your API key.
// Use a secure method like environment variables.
$apiKey = "YOUR_API_KEY";
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=" . $apiKey;

$data = json_encode([
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $userMessage
                ]
            ]
        ]
    ]
]);

// Initialize cURL session
$ch = curl_init($apiUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Recommended for local development only

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo json_encode(['error' => 'cURL Error: ' . curl_error($ch)]);
} else {
    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Check if the response is valid and contains text
    if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        $chatbotResponse = $responseData['candidates'][0]['content']['parts'][0]['text'];
        echo json_encode(['text' => $chatbotResponse]);
    } else {
        echo json_encode(['error' => 'Invalid response from Gemini API.', 'details' => $responseData]);
    }
}

// Close cURL session
curl_close($ch);
