<?php
include(dirname(__DIR__). '/includes/header.inc.php');
require_once(dirname(__DIR__). '/includes/config/config.php');
echo('<h2 class="h2 text-center mb-3">Bike Auction</h2>');
?>


    <p>In February, bikes without an owner have been collected on the property. You now have the opportunity to buy one of those bikes.</p>

<h3 class="h3 mt-5">1. Select a Bike</h3>
<p>You can find photos of all bikes here: <a href="https://cloud.psw-wuerzburg.de/index.php/f/3365">PSW Cloud</a>.<br>
    Every bike has been assigned a unique number, the images are named accordingly. This number is also attached to the bike's handlebars
with a red zip-tie. So, in case you want to see the bike in real, just go to the lower level of the parking lot behind house 3,
and look for the bike. If you are interested in buying it, you can place a bid.</p>

    <h3 class="h3 mt-5">2. Check for the highest bid</h3>
<p>Search this table for the bike's number to find the current bid. If it does not show up, nobody has placed a bid yet. The bid you place needs to be higher than the current, highest bid.</p>
<?php
$user_id = 'PSW-Account-' . $_SESSION['userID'];
if (($handle = fopen(AUCTION_DATA_SOURCE, "r")) !== FALSE) {

    // Initialize an empty associative array to store the highest bids for each bike
    $bike_bids = array();
    $user_bids = array(); // To store the highest bids for the current user

    // Initialize a variable to check if it's the first row (header)
    $is_header = true;

    // Read the CSV file line by line
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Skip the header row
        if ($is_header) {
            $is_header = false;
            continue;
        }

        // Extract the bike number and bid amount
        $bike_number = $data[3]; // "Bike Number" is the 4th column (index 3)
        $bid_amount = str_replace(" €", "", $data[4]); // Remove the euro symbol and space
        $bid_amount = floatval($bid_amount); // Convert to float for comparison
        $current_user_id = $data[0]; // "User ID" is the 1st column (index 0)

        // Update the highest bid for each bike
        if (!isset($bike_bids[$bike_number]) || $bid_amount > $bike_bids[$bike_number]) {
            $bike_bids[$bike_number] = $bid_amount;
        }

        // If this row's user ID matches the session user ID, track their highest bid for this bike
        if ($current_user_id == $user_id) {
            if (!isset($user_bids[$bike_number]) || $bid_amount > $user_bids[$bike_number]) {
                $user_bids[$bike_number] = $bid_amount;
            }
        }
    }

    // Close the file
    fclose($handle);

    // Display the table with the highest bids for each bike and the user's highest bid
    echo "<table class='table'>";
    echo "<tr><th>Bike Number</th><th>Highest Bid (€)</th><th>Your current bid</th></tr>";

    // Loop through the bike_bids array and display the highest bid for each bike
    foreach ($bike_bids as $bike_number => $highest_bid) {
        // Check if the user has made a bid on this bike, otherwise display 'N/A'
        $user_highest_bid = isset($user_bids[$bike_number]) ? number_format($user_bids[$bike_number], 2) . " €" : "N/A";

        echo "<tr><td>" . htmlspecialchars($bike_number) . "</td><td>" . htmlspecialchars(number_format($highest_bid, 2)) . " €</td><td>" . $user_highest_bid . "</td></tr>";
    }

    echo "</table>";

} else {
    // Error handling in case the file could not be opened
    echo "Error: Unable to open the CSV file.";
}
?>

    <h3 class="h3 mt-5">3. Place your bid</h3>
    <p>Use this <a href="https://cloud.psw-wuerzburg.de/index.php/apps/forms/3BYDf279YtYtYmsG">form</a> to place your bid.</p>
    <h3 class="h3 mt-5">4. Refresh this site</h3>
<p>Your bid should now show up in the table. Come back regularly to check, if a higher bid was placed. In this case, just fill out the form from step 3 again to place a new, higher bid.</p>
<?php
include(dirname(__DIR__). '/includes/footer.inc.php');
