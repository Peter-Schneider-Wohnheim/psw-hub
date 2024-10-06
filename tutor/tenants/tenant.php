<?php
include(dirname(__DIR__) . '/../includes/header.inc.php');
require_once(dirname(__DIR__) . '/../includes/controller/tenants.inc.php');

if (!(in_array("tutor", $_SESSION['roles']) or in_array("administrator", $_SESSION['roles']))) {
    exit();
}

$user = getUserByID($_GET['t']);
$userinfo = <<<USERINFO
    <h2 class="h2 mb-3">Tenant Details</h2>
    <form class="row g-3">
        <div class="col-md-6">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" disabled value="{$user['first_name']}">
        </div>
        <div class="col-md-6">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" disabled value="{$user['last_name']}">
        </div>
        <div class="col-md-1">
            <label for="house" class="form-label">House</label>
            <input type="number" class="form-control" id="house" disabled value="{$user['house']}">
        </div>
        <div class="col-md-3">
            <label for="room" class="form-label">Room</label>
            <input type="number" class="form-control" id="room" disabled value="{$user['room']}">
        </div>
        <div class="col-md-3">
            <label for="vo" class="form-label">VO-Nr.</label>
            <input type="text" class="form-control" id="vo" disabled value="{$user['vo_no']}">
        </div>
    </form>
USERINFO;
echo $userinfo;
echo('<h3 class="h3 mt-5 mb-4">Federated Data</h3>');
if(!$user['registered']){
    $notRegistered = <<<NOTREGISTERED
        <div class="alert alert-warning mt-4" role="alert">
          This user has not registered yet.
        </div>
    NOTREGISTERED;
    echo $notRegistered;
} else {
    $federatedInfo = getWordPressUserDetails($user['wordpress_id']);
    $roles = implode(', ', $federatedInfo['roles']);
    $itSystems = <<<ITSYSTEMS
        <form class="row g-3">
            <div class="col-md-2">
                <label for="userId" class="form-label">User ID</label>
                <input type="number" class="form-control" id="userId" disabled value="{$user['wordpress_id']}">
            </div>
            <div class="col-md-5">
                <label for="registrationDate" class="form-label">Date of Registration</label>
                <input type="datetime-local" class="form-control" id="registrationDate" disabled value="{$user['date_of_registration']}">
            </div>
            <div class="col-md-5">
                <label for="userName" class="form-label">Username</label>
                <input type="text" class="form-control" id="userName" disabled value="{$federatedInfo['username']}">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">E-Mail</label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" id="email" disabled value="{$federatedInfo['email']}">
                    <button class="btn btn-outline-secondary" type="button" id="copy-mail"><i class="bi bi-copy"></i></button>
                    <a href="mailto:{$federatedInfo['email']}" class="btn btn-outline-secondary" type="button"><i class="bi bi-envelope-at"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone</label>
                <div class="input-group mb-3">
                    <input type="tel" class="form-control" id="phone" disabled value="{$federatedInfo['phone_number']}">
                    <button class="btn btn-outline-secondary" type="button" id="copy-phone"><i class="bi bi-copy"></i></button>
                    <a href="tel:{$federatedInfo['phone_number']}" class="btn btn-outline-secondary" type="button"><i class="bi bi-telephone"></i></a>
                </div>
            </div>
            <div class="col-md-12">
                <label for="roles" class="form-label">Roles</label>
                <input type="text" class="form-control" id="roles" disabled value="$roles">
            </div>
        </form>
    ITSYSTEMS;
    echo $itSystems;
    // print_r($federatedInfo['avatar_urls']);
}

include(dirname(__DIR__) . '/../includes/footer.inc.php');
?>

<script>
    document.getElementById('copy-mail').addEventListener('click', function() {
        var phoneValue = document.getElementById('email').value;
        navigator.clipboard.writeText(phoneValue);
    });

    document.getElementById('copy-phone').addEventListener('click', function() {
        var phoneValue = document.getElementById('phone').value;
        navigator.clipboard.writeText(phoneValue);
    });
</script>
