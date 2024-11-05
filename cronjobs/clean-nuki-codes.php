<?php
require_once(dirname(__DIR__) . '/keychain/kitchen.inc.php');

$allGrants = getGrants();

$filteredGrants = [];

foreach ($allGrants as $grant) {
    // Check if the name contains only numbers and dashes
    if (preg_match('/^[0-9\-]+$/', $grant->name)) {
        // Add the object to the filtered list
        $filteredGrants[] = $grant;
    }
}

foreach ($filteredGrants as $grant){
    $date = new DateTime($grant->allowedUntilDate, new DateTimeZone('Europe/Berlin'));
    $now = new DateTime('now', new DateTimeZone('Europe/Berlin'));
    if($date < $now){
        deleteGrant($grant->id);
    }
}
