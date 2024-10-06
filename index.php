<?php
include(__DIR__ . '/includes/header.inc.php');
require_once(__DIR__ . '/includes/components.php');

echo('<h2 class="h2 mb-4">Welcome, ' . $_SESSION['displayname'] . '!</h2>');
echo('<div class="tiles-container">');
tile("/keychain", "Keychain", "bi-key");
tile("https://psw-wuerzburg.de/wiki/", "Wiki", "bi-wikipedia");
tile("https://booking.psw-wuerzburg.de/", "Room Booking", "bi-journal-bookmark-fill");
tile("https://cloud.psw-wuerzburg.de", "Cloud", "bi-cloud");
tile("https://psw-wuerzburg.de/events/", "Event Calendar", "bi-calendar-event");
echo('</div>');

if (in_array("tutor", $_SESSION['roles']) or in_array("administrator", $_SESSION['roles'])){
    echo('<h2 class="h2 mb-4 mt-5">Tutor</h2>');
    tile("/tutor/tenants", "Tenant List", "bi-person-lines-fill");
}

include(__DIR__ . '/includes/footer.inc.php');
