<?php

include_once('../../config/Database.php');
$database = new Database();
$conn = $database->connect();

$username = $_POST['username'];
$password = $_POST['password'];
$normal = "normal";
$query = 'INSERT INTO `users`(`username`, `password`, `privilege`) VALUES (:username,:password,:normal)';
$stmt = $conn->prepare($query);
$stmt->bindParam(':username',$username);
$stmt->bindParam(':password',md5($password));
$stmt->bindParam(':normal',$normal);
$stmt->execute();
$num = $stmt->rowCount();



header('Location: ../signup_success.php');