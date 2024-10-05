<?php
include(dirname(__DIR__). '/includes/header.inc.php');
require_once(dirname(__DIR__). '/includes/components.php');
echo('<h2 class="h2 text-center"><i class="bi bi-key"></i> | Keychain</h2>');
tile("/keychain/kitchen.php", "Kitchen", "bi-cup-straw");
include(dirname(__DIR__). '/includes/footer.inc.php');
