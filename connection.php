<?php

$host = "localhost";
$dbname = "project_db";
$username = "root";
$password = "";


try {
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    
    die("Connection failed: " . $e->getMessage());
}

?>
