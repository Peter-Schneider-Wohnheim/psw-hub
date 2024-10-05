<?php
include(dirname(__DIR__).'/includes/config/config.php');
session_start();

// Check if we have a code in the URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Exchange the authorization code for an access token
    $post_data = [
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'code' => $code,
        'redirect_uri' => REDIRECT_URI,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, TOKEN_URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($response, true);
    $access_token = $token_data['access_token'];

    // Use the access token to get the user information
    $headers = ['Authorization: Bearer ' . $access_token, 'User-Agent: Insomnia/2023.5.7'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, USER_ENDPOINT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
    $user_response = curl_exec($ch);
    print_r($user_response);
    curl_close($ch);

    $user_data = json_decode($user_response, true);

    // Check for JSON decode error
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON decode error: ' . json_last_error_msg();
        exit;
    }

    $_SESSION['userID'] = $user_data['ID'];
    $_SESSION['username'] = $user_data['user_login'];
    $_SESSION['displayname'] = $user_data['display_name'];
    $_SESSION['email'] = $user_data['user_email'];
    $_SESSION['phone'] = $user_data['user_phone_number'];
    $_SESSION['roles'] = $user_data['user_roles'];

    header("Location:../index.php");
    exit();
} else {
    echo '<p>No code parameter received. Please try signing in again.</p>';
}
