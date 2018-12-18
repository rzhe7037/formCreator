<?php

include_once('../config/Database.php');
$database = new Database();
$conn = $database->connect();


$query = 'SELECT * FROM company_address NATURAL JOIN company_info NATURAL JOIN company_owner NATURAL JOIN company_business NATURAL JOIN company_system';
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
