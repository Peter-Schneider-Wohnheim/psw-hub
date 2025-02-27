<?php
include(dirname(__DIR__) . '/includes/header.inc.php');
require_once(dirname(__DIR__) . '/includes/config/hub.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the posted data
    $bikeNumber = intval($_POST['bikeNumber']);
    $bid = intval($_POST['bid']);
    $user_id = $_SESSION['userID'];
    $email = $_SESSION['email'];

    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO bike_bids (user_id, email, bike_id, bid, timestamp) VALUES (:user_id, :email, :bike_id, :bid, CURRENT_TIMESTAMP)";
        $stmt = $hub->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':bike_id', $bikeNumber, PDO::PARAM_INT);
        $stmt->bindParam(':bid', $bid, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">
                    Your bid of <strong>' . $bid . '€</strong> 
                    for the bike with ID <strong>' . $bikeNumber . '</strong> 
                    has been placed successfully! (Your User ID: <strong>' . $user_id . '</strong>)
                  </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error placing bid.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

echo '<div class="alert alert-info" role="alert">Once the auction is finished, you\'ll be contacted by the tutors in case you were the highest bidder. We\'ll use the following email: <br><strong>' . $email . '</strong></div>';

include(dirname(__DIR__) . '/includes/footer.inc.php');