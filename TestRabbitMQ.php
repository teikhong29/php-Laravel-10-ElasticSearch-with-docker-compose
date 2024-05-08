<?php

// API endpoint to send requests to
$endpoint = 'http://localhost/publish-message';

// Number of requests to send
$requests = 100;

// Delay between requests in microseconds (1 second = 1,000,000 microseconds)
$delay = 0; // 0.1 second

// Loop to send multiple requests
for ($i = 0; $i < $requests; $i++) {
    $ch = curl_init();

    // Set the URL
    curl_setopt($ch, CURLOPT_URL, $endpoint);

    // Set the request as a POST request
    curl_setopt($ch, CURLOPT_POST, 1);

    // Set the POST data
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'firstname' => 'John '.$i,
        'lastname' => 'Doe',
        'email' => 'john.doe@example.com',
        'address' => 'sajkdhqweq',
        'phone' => $i,
    ]);

    // Return the response instead of outputting it
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);

    // Close cURL resource to free up system resources
    curl_close($ch);

    // Print the response
    echo $response . "\n";

    // Delay between requests
    usleep($delay);
}

?>