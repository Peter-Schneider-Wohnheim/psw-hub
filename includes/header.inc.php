<!DOCTYPE html>
<html lang="de" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../styles/global.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <link href="
https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css
" rel="stylesheet">
    <title>PSW Hub</title>
</head>
<body class="bg-body">
<div class="container-fluid p-1 border-bottom">
    <header class="d-flex justify-content-between align-items-center p-3">
        <div class="psw-keychain">
            <a href="/index.php" style="text-decoration: none;">PSW Hub</a>
        </div>
        <div class="logout">
            <a href="../auth/logout.php">
                <i class="bi bi-person-lock"></i>
            </a>
        </div>
    </header>
</div>
<main class="mt-4">
    <div class="container">
        <div class="mx-2 mb-3">
<?php
session_start();
if (!isset($_SESSION["userID"])) {
    if (strpos($_SERVER['SCRIPT_NAME'], 'login') === false) {
        header("Location: auth/login.php");
        exit();
    }
}

// Breadcrumbs
if ($_SERVER['SCRIPT_NAME'] !== "/index.php" and strpos($_SERVER['SCRIPT_NAME'], 'auth') === false) {
    // Get the current request URI and remove leading/trailing slashes
    $uri = trim($_SERVER['REQUEST_URI'], '/');

    // Split the URI into an array of segments
    $segments = explode('/', $uri);

    // Base URL (adjust this if necessary, for example if your project is in a subdirectory)
    $base_url = '/';

    // Start the breadcrumb output
    echo '<nav aria-label="breadcrumb">';
    echo '<ol class="breadcrumb">';

    // Add the "Home" link as the first breadcrumb
    echo '<li class="breadcrumb-item"><a href="/">Home</a></li>';

    // Initialize the cumulative path
    $cumulative_path = '';
    foreach ($segments as $index => $segment) {
        // Append the segment to the cumulative path for the link
        $cumulative_path .= $segment . '/';
        // Check if it's the last segment
        if ($index === count($segments) - 1) {
            // Last segment should be active and not a link
            echo '<li class="breadcrumb-item active" aria-current="page">' . ucfirst(str_replace(array(".php", "_"), array("", " "), $segment) . ' ') . '</li>';
        } else {
            // Other segments should be links
            echo '<li class="breadcrumb-item"><a href="' . $base_url . $cumulative_path . '">' . ucfirst(str_replace(array(".php", "_"), array("", " "), $segment) . ' ') . '</a></li>';
        }
    }
}

echo '</ol>';
echo '</nav>';
?>