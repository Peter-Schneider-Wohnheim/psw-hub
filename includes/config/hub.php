<?php
require_once(dirname(__DIR__) . '/config/config.php');

if (PROD) {
    $host = hubDBServer;
    $name = hubDBName;
    $user = hubDBUser;
    $passwort = hubDBPassword;
} else {
    $host = "localhost";
    $name = "hub";
    $user = "app_user";
    $passwort = "Password123!";
}
try {
    $hub = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
} catch (PDOException $e) {
    echo "SQL Error: " . $e->getMessage();
}
