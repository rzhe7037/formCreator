<?php

include_once('../config/Database.php');
$database = new Database();
$conn = $database->connect();


$query = 'SELECT DISTINCT business_type FROM company_business';
$stmt = $conn->prepare($query);
$stmt->execute();
$business_types= $stmt->fetchAll();

function findSubType($business_type,$conn){
    $query = 'SELECT * FROM company_business WHERE business_type = :business_type';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':business_type',$business_type);
    $stmt->execute();
    $subtypes = $stmt->fetchAll();
    $subtype_html="";
    foreach($subtypes as $subtype){
        $subtype_html .= "<option>".$subtype['business_subtype']."</option>";
    }
    return  $subtype_html;
}