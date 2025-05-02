<?php
include(dirname(__DIR__). '/includes/header.inc.php');
require_once(dirname(__DIR__). '/includes/components.php');
echo('<h2 class="h2 text-center"><i class="bi bi-key"></i> | Keychain</h2>');
echo('<div class="alert alert-primary" role="alert">This application allows you to unlock rooms with your PSW-Account.</div>');
tile("/keychain/kitchen.php", "Kitchen", "bi-cup-straw");
include(dirname(__DIR__). '/includes/footer.inc.php');
