<?php
include(dirname(__DIR__) . '/includes/header.inc.php');
require_once(dirname(__DIR__) . '/keychain/kitchen.inc.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['grantAccess'])) {
        if (isset($_POST['code'], $_POST['reservationId'], $_POST['start'], $_POST['end'])) {
            grantAccess($_POST['reservationId'], $_POST['start'], $_POST['end'], $_POST['code']);
        }
    } elseif(isset($_POST['revokeAccess'])){
        deleteGrant($_POST['authId']);
    }
}
$accessCode = getAccessCode();

echo '<h2 class="h2 mb-3">Kitchen Reservations</h2>';
$accessCodeInfo = <<<ACCESSCODEINFO
<div class="alert alert-primary" role="alert">
  <p>Your access code is: <span class="font-monospace">$accessCode</span></p>
  To use it, head to <a href="https://booking.psw-wuerzburg.de/index.php?area=3">booking.psw-wuerzburg.de</a> and place
  your booking for the kitchen. Afterward, return to this site, select the booking and click on "Grant access". 
  Your code will then be authorized to open the door in the selected timeframe. Without a booking, the code is invalid.
  Your code can only be authorized for one booking at a time.
</div>
<div class="alert alert-secondary" role="alert">
  Unfortunately, remote access to the lock is sometimes a bit slow or the connection is unstable. 
  In most cases, after clicking "Grant access", you should be fine, even if the page does not display "Your access code 
  is valid for this timeslot" right after clicking the button. Come back in a few minutes and <b>refresh the page</b>. If you 
  still do not see a confimation message, click the button again. Same goes for revoking access.
</div>
ACCESSCODEINFO;
echo $accessCodeInfo;

$grants = getGrantsForUser();
$reservations = getKitchenReservationsForUser();
echo('<h3 class="h2 mt-5">My reservations</h3>');
if(count($reservations) > 0){
    foreach ($reservations as &$reservation) {
        $start_time = date('d.m.Y H:i', $reservation['start_time']);
        $end_time = date('d.m.Y H:i', $reservation['end_time']);

        $start_time_nuki = formatUnixTimestamp($reservation['start_time']);
        $end_time_nuki = formatUnixTimestamp($reservation['end_time']);

        echo('<div class="card mt-3">');
        echo('<div class="card-header">Reservation #' . $reservation['id'] . '</div>');
        $table = <<<TABLE
            <div class="card-body">
                <table>
                    <tbody>
                    <tr>
                        <td>Start:</td>
                        <td>$start_time</td>
                    </tr>
                    <tr>
                        <td>End:</td>
                        <td>$end_time</td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td>{$reservation['description']}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            TABLE;
        echo $table;
        echo('<div class="card-footer pb-0 pt-3">');
        if (isset($grants[0])) {
            $authId = $grants[0]->id;
            if (getBookingId($grants[0]->name) == $reservation['id']) {
                $deleteForm = <<<DELETEFORM
                    <p>Your access code is valid for this timeslot.</p>
                    <form method="POST" action="kitchen.php">
                        <input type="hidden" name="authId" value="$authId">
                        <button type="submit" name="revokeAccess" class="btn btn-danger mb-3">
                            Revoke access
                        </button>
                    </form>
                DELETEFORM;
                echo $deleteForm;
            } else {
                if (count($grants) >= 1) {
                    echo('<p>You can only authorize one booking with your code. Deauthorize an active one, to grant access.</p>');
                }
            }
        } else {
            $grantForm = <<<GRANTFORM
                        <form method="POST" action="kitchen.php">
                            <input type="hidden" name="reservationId" value="{$reservation['id']}">
                            <input type="hidden" name="start" value="$start_time_nuki">
                            <input type="hidden" name="end" value="$end_time_nuki">
                            <input type="hidden" name="code" value="$accessCode">
                            <button type="submit" name="grantAccess" class="btn btn-primary mb-3">
                                Grant access
                            </button>
                        </form>
                    GRANTFORM;
            echo $grantForm;
        }
        echo('</div>');
        echo('</div>');
    }
} else {
   $noReservations = <<<NORESERVATIONS
    <div class="alert alert-warning" role="alert">
      You have no active bookings yet.
    </div>
    NORESERVATIONS;
   echo $noReservations;
}

include(dirname(__DIR__) . '/includes/footer.inc.php');
?>

<style>
    td {
        padding-right: 5px;
    }
</style>