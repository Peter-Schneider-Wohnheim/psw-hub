<?php
include(dirname(__DIR__) . '/../includes/header.inc.php');
require_once(dirname(__DIR__) . '/../includes/controller/tenants.inc.php');

if (!(in_array("tutor", $_SESSION['roles']) or in_array("administrator", $_SESSION['roles']))) {
    exit();
}

$users = searchUser($_GET['q']);
?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">House</th>
                <th scope="col">Room</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user) {
                $userTable = <<<USERTABLE
                <tr>
                <th scope="row">{$user['wordpress_id']}</th>
                <td>{$user['house']}</td>
                <td>{$user['room']}</td>
                <td>{$user['first_name']}</td>
                <td>{$user['last_name']}</td>
                <td><a href="/tutor/tenants/tenant.php?t={$user['id']}" type="button" class="btn btn-link"><i class="bi bi-three-dots"></i></a></td>
                </tr>
                USERTABLE;
                echo $userTable;
            }
            ?>
            </tbody>
        </table>
    </div>

<?php
include(dirname(__DIR__) . '/../includes/footer.inc.php');
?>