<?php

include_once('../../config/Database.php');
$database = new Database();
$conn = $database->connect();

$business_type = $_GET['business_type'];
$query = 'SELECT * FROM company_business WHERE business_type = :business_type';
$stmt = $conn->prepare($query);
$stmt->bindParam(':business_type',$business_type);
$stmt->execute();
$subtypes = $stmt->fetchAll();
$subtype_html="";

foreach($subtypes as $subtype){
   $subtype_html .= "<option>".$subtype['business_subtype']."</option>";
}
echo $subtype_html;