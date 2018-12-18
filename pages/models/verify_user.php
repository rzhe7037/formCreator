<?php

include_once('../../config/Database.php');
session_start();

$database = new Database();
$conn = $database->connect();

$username = $_POST['username'];
$password = $_POST['password'];

$query = 'SELECT * FROM users WHERE username = :username AND password = :password;';
$stmt = $conn->prepare($query);
$stmt->bindParam(':username',$username);
$stmt->bindParam(':password',md5($password));
$stmt->execute();
$num = $stmt->rowCount();
if($num > 0){
    $_SESSION['username'] = $username;
    header('Location: ../main.php');
    exit();
}

// whether it is admin account
$query = 'SELECT * FROM users WHERE username = :username AND password = :password AND privilege = :privilege;';
$stmt = $conn->prepare($query);
$stmt->bindParam(':username',$username);
$stmt->bindParam(':password',md5($password));
$stmt->bindParam(':password',md5($password));
$stmt->execute();
$num = $stmt->rowCount();
if($num > 0){
    $_SESSION['username'] = $username;
    header('Location: ../main.php');
    exit();
}

header('Location: ../error.php');