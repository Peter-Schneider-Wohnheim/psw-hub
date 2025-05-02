<?php
include(dirname(__DIR__). '/includes/header.inc.php');
require_once(dirname(__DIR__). '/includes/config/config.php');
require_once(dirname(__DIR__) . '/includes/config/hub.php');
echo('<h2 class="h2 mb-3">Your Vodafone Customer-ID</h2>');
echo('<div class="alert alert-secondary" role="alert">Internet problems? Follow our guide <a href="https://psw-wuerzburg.de/wiki/internet/">here</a>.</div>');
echo("<p>In case you're facing issues with your internet connection, you may need to call Vodafone to resolve them. For this, you need your customer number displayed below.</p>");
try {
    // Assuming the user ID is stored in the session as 'user_id'
    $room = $_SESSION['username'];

    $sql = "SELECT customer_id FROM vodafone_customer_ids WHERE room = :room";
    $stmt = $hub->prepare($sql);
    $stmt->bindParam(':room', $room, PDO::PARAM_INT);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo('<div class="alert alert-primary" role="alert">Your customer number: <span class="font-monospace">' . $results[0]["customer_id"] . '</span></div>');
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}


include(dirname(__DIR__). '/includes/footer.inc.php');
