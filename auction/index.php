<?php
include(dirname(__DIR__) . '/includes/header.inc.php');
require_once(dirname(__DIR__) . '/includes/config/config.php');
require_once(dirname(__DIR__) . '/includes/config/hub.php');
echo('<h2 class="h2 mb-3">Bike Auction</h2>');

// Set this variable to (de)activate auctions.
$auction_active=true;

if($auction_active){
?>
    <p>In February 2024, bikes without an owner have been collected on the property. You now have the opportunity to buy one
        of those bikes.</p>

    <h3 class="h3 mt-5">1. Select a Bike</h3>
    <p>You can find photos of all bikes here: <a href="https://cloud.psw-wuerzburg.de/index.php/s/gK3gjHFwSy7cgLj" target=”_blank”>PSW
            Cloud</a>.<br>
        Every bike has been assigned a unique number, the images are named accordingly. This number is also attached to
        the bike's handlebars
        with a red zip-tie. So, in case you want to see the bike in real, just go to the lower level of the parking lot
        behind house 3,
        and look for the bike. If you are interested in buying it, you can place a bid.</p>

    <h3 class="h3 mt-5">2. Check for the highest bid</h3>
    <p>Search this table for the bike's number to find the current bid. If it does not show up, nobody has placed a bid
        yet. The bid you place needs to be higher than the current, highest bid.</p>
<?php
echo '<div class="alert alert-light" role="alert">Your User ID: ' . $_SESSION['userID'] . '<br>Your mail: ' . $_SESSION['email'] . '</div>';

$is_admin_or_tutor = (isset($_SESSION['roles']) && (in_array("tutor", $_SESSION['roles']) || in_array("administrator", $_SESSION['roles'])));

try {
    $sql = "SELECT bb.bike_id, bb.bid AS highest_bid, bb.user_id, bb.timestamp" .
        ($is_admin_or_tutor ? ", bb.email" : "") . // Conditionally select the email column
        " FROM bike_bids bb
             WHERE bb.timestamp = (
                 SELECT MIN(timestamp) 
                 FROM bike_bids 
                 WHERE bike_id = bb.bike_id AND bid = (
                     SELECT MAX(bid) FROM bike_bids WHERE bike_id = bb.bike_id
                 )
             )";

    $stmt = $hub->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table class='table'>";
    echo "<tr>
            <th>Bike ID</th>
            <th>Highest Bid</th>
            <th>Timestamp</th>
            <th>User ID</th>";

    // Show the Email column only if the user has the required role
    if ($is_admin_or_tutor) {
        echo "<th>Email</th>";
    }

    echo "</tr>";

    foreach ($results as $row) {
        echo "<tr>
                <td>" . $row['bike_id'] . "</td>
                <td>" . $row['highest_bid'] . "€</td>
                <td>" . $row['timestamp'] . "</td>
                <td>" . $row['user_id'] . "</td>";

        if ($is_admin_or_tutor) {
            echo "<td>" . $row['email'] . "</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>

    <h3 class="h3 mt-5">3. Place your bid</h3>
    <p>By filling out the form, you place a binding bid. The highest bid will receive the bike. Starting bid is 5 €. Your
        bid is binding. That means, if you are the highest bidder, you are required to pay the selected price.</p>
    <div class="alert alert-danger" role="alert">
        Your bid is binding. That means, if you are the highest bidder, you are required to pay the selected price.
    </div>
    <form action="/auction/bid-placed.php" method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="bikeNumber" class="form-label">Bike Number</label>
            <input type="number" class="form-control" id="bikeNumber" name="bikeNumber" value="" required min="1"
                   max="62">
        </div>
        <div class="col-md-6">
            <label for="bid" class="form-label">Your Bid (€)</label>
            <select class="form-select" aria-label="Default select example" name="bid" required>
                <option value="5" selected>5 €</option>
                <option value="10">10 €</option>
                <option value="15">15 €</option>
                <option value="20">20 €</option>
                <option value="25">25 €</option>
                <option value="30">30 €</option>
                <option value="35">35 €</option>
                <option value="40">40 €</option>
                <option value="45">45 €</option>
                <option value="50">50 €</option>
                <option value="55">55 €</option>
                <option value="60">60 €</option>
                <option value="65">65 €</option>
                <option value="70">70 €</option>
                <option value="75">75 €</option>
                <option value="80">80 €</option>
                <option value="85">85 €</option>
                <option value="90">90 €</option>
                <option value="95">95 €</option>
                <option value="100">100 €</option>
                <option value="110">110 €</option>
                <option value="120">120 €</option>
                <option value="130">130 €</option>
                <option value="140">140 €</option>
                <option value="150">150 €</option>
                <option value="160">160 €</option>
                <option value="170">170 €</option>
                <option value="180">180 €</option>
                <option value="190">190 €</option>
                <option value="200">200 €</option>
                <option value="220">220 €</option>
                <option value="240">240 €</option>
                <option value="260">260 €</option>
                <option value="280">280 €</option>
                <option value="300">300 €</option>
                <option value="350">350 €</option>
                <option value="400">400 €</option>
                <option value="450">450 €</option>
                <option value="500">500 €</option>
                <option value="550">550 €</option>
                <option value="600">600 €</option>
                <option value="650">650 €</option>
                <option value="700">700 €</option>
                <option value="750">750 €</option>
                <option value="800">800 €</option>
                <option value="850">850 €</option>
                <option value="900">900 €</option>
                <option value="950">950 €</option>
                <option value="1000">1000 €</option>
                <option value="1100">1100 €</option>
                <option value="1200">1200 €</option>
                <option value="1300">1300 €</option>
                <option value="1400">1400 €</option>
                <option value="1500">1500 €</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Place bid</button>
    </form>

    <h3 class="h3 mt-5">4. Refresh this site</h3>
    <p class="mb-5">Your bid should now show up in the table. Come back regularly to check, if a higher bid was placed. In this case,
        just fill out the form from step 3 again to place a new, higher bid.</p>


<?php
} else {
    echo '<div class="alert alert-primary" role="alert">There currently is no active auction.</div>';
}
include(dirname(__DIR__) . '/includes/footer.inc.php');
