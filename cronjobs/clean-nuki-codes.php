<?php
require_once(dirname(__DIR__) . '/keychain/kitchen.inc.php');

$allGrants = getGrants();

$filteredObjects = [];

foreach ($allGrants as $grant) {
    // Check if the name contains only numbers and dashes
    if (preg_match('/^[0-9\-]+$/', $grant) === 1) {
        // Add the object to the filtered list
        $filteredObjects[] = $grant;
    }
}

