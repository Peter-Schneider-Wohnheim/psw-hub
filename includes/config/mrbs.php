<?php
require_once(dirname(__DIR__) . '/config/config.php');

if (PROD) {
    $host = mrbsDBServer;
    $name = mrbsDBName;
    $user = mrbsDBUser;
    $passwort = mrbsDBPassword;
} else {
    $host = "localhost";
    $name = "mrbs";
    $user = "mariadb";
    $passwort = "";
}
try {
    $mrbs = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
} catch (PDOException $e) {
    echo "SQL Error: " . $e->getMessage();
}
