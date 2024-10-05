<?php
include(dirname(__DIR__).'/includes/header.inc.php');
session_destroy();
?>
    <div class="alert alert-success" role="alert">
        You have been logged out.
    </div>

<?php include(dirname(__DIR__).'/includes/footer.inc.php'); ?>