<?php
include(dirname(__DIR__).'/includes/header.inc.php');
require(dirname(__DIR__).'/includes/config/config.php');
error_reporting(E_ALL ^ E_NOTICE);

session_start();
$params = [
    'client_id' => CLIENT_ID,
    'scope' => 'basic email',
    'response_type' => 'code',
    'redirect_uri' => REDIRECT_URI
];
$sign_in_url = AUTHORIZE_URL . '?' . http_build_query($params);

if (isset($_SESSION["userID"])) {
    header("Location:index.php");
    exit();
} else {
    $sign_in_ui = <<<SIGNINUI
        <div class="d-flex justify-content-center align-items-center center-container">
            <div class="card" style="width: 25rem;">
                <div class="card-body">
                    <h5 class="card-title">PSW Hub</h5>
                    <h6 class="card-subtitle mt-2 mb-3 text-body-secondary fw-light">Please authenticate.</h6>
                    <a href="$sign_in_url" type="button" class="btn btn-primary">Sign in with PSW-Account</a>
                </div>
            </div>
        </div>
    SIGNINUI;
    echo $sign_in_ui;
}
include(dirname(__DIR__).'/includes/footer.inc.php');