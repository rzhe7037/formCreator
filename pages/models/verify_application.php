<?php

include_once('../../config/Database.php');
include_once('../header.php');
$database = new Database();
$conn = $database->connect();


// verify user input
$verify = true;
echo "<div class=container>";
    echo "<h3 style='color:red'>Error!</h3>";

    if($_POST['shop_name'] == ""){
        $verify = false;
        echo "<div>Company name missing</div>";
    }

    if($_POST['address_street'] == ""){
        $verify = false;
        echo "<div>company street missing</div>";
    }
    if($_POST['address_suburb'] == ""){
        $verify = false;
        echo "<div>address_suburb missing</div>";
    }
    if($_POST['address_street'] == ""){
        $verify = false;
        echo "<div>company street missing</div>";
    }
    if($_POST['address_postcode'] == ""){
        $verify = false;
        echo "<div>address postcode missing</div>";
    }

    if($_POST['business_type'] == ""){
        $verify = false;
        echo "<div>business type missing</div>";
    }

    if($_POST['nationality'] == ""){
        $verify = false;
        echo "<div>nationality missing</div>";
    }

    if($_POST['owner_name'] == ""){
        $verify = false;
        echo "<div>owner name missing</div>";
    }
    if($_POST['owner_mobile'] == ""){
        $verify = false;
        echo "<div>owner mobile missing</div>";
    }
    echo "<a href='../create.php'>Back to create page</a>";
    echo "</div>";    
if($verify == false){
    exit();
}

// Create company_address
$address_street = $_POST['address_street'];
$address_suburb = $_POST['address_suburb'];
$address_postcode = $_POST['address_postcode'];

$query = 'INSERT INTO `company_address` (`address_street`, `address_suburb`, `address_postcode`) VALUES (:address_street,:address_suburb,:address_postcode)';
$stmt = $conn->prepare($query);

$stmt->bindParam(':address_street',$address_street);
$stmt->bindParam(':address_suburb',$address_suburb);
$stmt->bindParam(':address_postcode',$address_postcode);

$stmt->execute();

$company_address_id = $conn->lastInsertId();

// Create owner_id
$owner_name = $_POST['owner_name'];
$owner_mobile = $_POST['owner_mobile'];
$shop_number = $_POST['shop_number'];
$managed_by = $_POST['managed_by'];
$manager_name = $_POST['manager_name'];
$manager_phone = $_POST['manager_phone'];

$query = 'INSERT INTO `company_owner` (`owner_name`, `owner_mobile`, `shop_number`, `managed_by`, `manager_name`,`manager_phone`) VALUES (:owner_name, :owner_mobile, :shop_number, :managed_by, :manager_name,:manager_phone)';
$stmt = $conn->prepare($query);

$stmt->bindParam(':owner_name',$owner_name);
$stmt->bindParam(':owner_mobile',$owner_mobile);
$stmt->bindParam(':shop_number',$shop_number);
$stmt->bindParam(':managed_by',$managed_by);
$stmt->bindParam(':manager_name',$manager_name);
$stmt->bindParam(':manager_phone',$manager_phone);

$stmt->execute();
$owner_id = $conn->lastInsertId();


// Create company_id
$pos = $_POST['pos'];
$QR_payment = $_POST['QR_payment'];
$satisfaction = $_POST['satisfaction'];
$comment = $_POST['comment'];

$query = 'INSERT INTO `company_system` (`pos`, `QR_payment`, `satisfaction`, `comment`) VALUES (:pos, :QR_payment, :satisfaction, :comment)';
$stmt = $conn->prepare($query);
$stmt->bindParam(':pos',$pos);
$stmt->bindParam(':QR_payment',$QR_payment);
$stmt->bindParam(':satisfaction',$satisfaction);
$stmt->bindParam(':comment',$comment);

$stmt->execute();
$company_id = $conn->lastInsertId();



// Create company_info

$business_type_id = '1';
$company_name = $_POST['shop_name'];
$creator = "john";

$query = 'INSERT INTO `company_info` (`company_id`, `company_name` ,`company_address_id`, `business_type_id`, `owner_id`, `creator`) VALUES (:company_id, :company_name, :company_address_id, :business_type_id, :owner_id, :creator)';
$stmt = $conn->prepare($query);
$stmt->bindParam(':company_id',$company_id);
$stmt->bindParam(':company_name',$company_name);
$stmt->bindParam(':company_address_id',$company_address_id);
$stmt->bindParam(':business_type_id',$business_type_id);
$stmt->bindParam(':owner_id',$owner_id);
$stmt->bindParam(':creator',$creator);

if($stmt->execute() == 1){
    header('Location: ../create_success.php');
}

echo "Form input missing";
$conn->close();