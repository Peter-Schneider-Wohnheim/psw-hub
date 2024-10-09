<?php
include(__DIR__ . '/includes/header.inc.php');
require_once(__DIR__ . '/includes/components.php');

echo('<h2 class="h2 mb-4">Welcome, ' . $_SESSION['displayname'] . '!</h2>');
echo('<h3 class="h3 mb-4 mt-3">Tools</h3>');
echo('<div class="tiles-container">');
if (in_array("tutor", $_SESSION['roles']) or in_array("administrator", $_SESSION['roles'])){
    tile("/tutor/tenants", "Tenant List", "bi-person-lines-fill");
}
tile("https://psw-wuerzburg.de/wiki/", "Wiki", "bi-wikipedia");
tile("/calendar", "Event Calendar", "bi-calendar-event");
tile("https://booking.psw-wuerzburg.de/", "Room Booking", "bi-journal-bookmark-fill");
tile("/keychain", "Keychain", "bi-key");
tile("https://cloud.psw-wuerzburg.de", "Cloud", "bi-cloud");

echo('</div>');

echo('<h3 class="h3 mb-4 mt-5">Contact</h3>');
echo('<div class="tiles-container">');
tile("https://psw-wuerzburg.de/contact", "Tutors", "bi-send");
tile("https://psw-wuerzburg.de/wiki/caretaker/", "Caretaker", "bi-tools");
echo('</div>');

include(__DIR__ . '/includes/footer.inc.php');
