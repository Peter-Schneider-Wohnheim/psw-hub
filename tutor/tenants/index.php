<?php
include(dirname(__DIR__). '/../includes/header.inc.php');

if (!(in_array("tutor", $_SESSION['roles']) or in_array("administrator", $_SESSION['roles']))){
    exit();
}

echo('<h2 class="h2">Tenant List</h2>');
?>
    <div class="justify-content-center align-items-center mt-4">
    <form action="/tutor/tenants/search.php" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="q" placeholder="Search by first name, last name, room, or ID">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
        <div class="form-text">Leave blank to get all tenants.</div>
    </form>
    </div>


<?php
include(dirname(__DIR__). '/../includes/footer.inc.php');
