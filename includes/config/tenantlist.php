<?php
require_once(dirname(__DIR__) . '/config/config.php');

if (PROD) {
    $host = tenantlistDBServer;
    $name = tenantlistDBName;
    $user = tenantlistDBUser;
    $passwort = tenantlistDBPassword;
} else {
    $host = "localhost";
    $name = "tenantlist";
    $user = "mariadb";
    $passwort = "";
}
try {
    $tenantlist = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
} catch (PDOException $e) {
    echo "SQL Error: " . $e->getMessage();
}
