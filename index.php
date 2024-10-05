<?php
include(__DIR__ . '/includes/header.inc.php');
require(__DIR__ . '/includes/components.php');

echo('<h2 class="h2 mb-4">Welcome, ' . $_SESSION['displayname'] . '!</h2>');
echo('<div class="tiles-container">');
tile("/keychain", "Keychain", "bi-key");
tile("https://psw-wuerzburg.de/wiki/", "Wiki", "bi-wikipedia");
tile("https://booking.psw-wuerzburg.de/", "Room Booking", "bi-journal-bookmark-fill");
tile("https://cloud.psw-wuerzburg.de", "Cloud", "bi-cloud");
tile("https://psw-wuerzburg.de/events/", "Event Calendar", "bi-calendar-event");
echo('</div>');

include(__DIR__ . '/includes/footer.inc.php');
