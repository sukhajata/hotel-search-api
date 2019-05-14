<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db.php';
require 'functions.php';

if (
	!empty($_REQUEST['id']) &&
	!empty($_REQUEST['name_english']) && 
	!empty($_REQUEST['name_thai']) &&
	!empty($_REQUEST['address_english']) &&
    !empty($_REQUEST['address_thai']) &&
	!empty($_REQUEST['tambon_id']) 
) {
	
    $stmtUpdate = $conn->prepare("
    UPDATE hotels
	SET name_english = :name_english, 
	name_thai = :name_thai, 
	address_english = :name_thai, 
	address_thai = :address_thai, 
	tambon_id = :tambon_id, 
	phone = :phone
	WHERE id = :id");
	
	$args = array(
		':name_english' => sanitize($_REQUEST['name_english']),
		':name_thai' => sanitize($_REQUEST['name_thai']),
		':address_english' => sanitize($_REQUEST['address_english']),
		':address_thai' => sanitize($_REQUEST['address_thai']),
		':tambon_id' => $_REQUEST['tambon_id'],
		':phone' => empty($_REQUEST['phone']) ? '' : sanitize($_REQUEST['phone']),
		':id' => $_REQUEST['id'],
	);
	
	if ($stmtUpdate->execute($args)) {
		header('X-PHP-Response-Code: 200', true, 200);
		echo json_encode(array("message" => "Hotel updated"));
	} else {
		header('X-PHP-Response-Code: 503', true, 503);
		echo json_encode(array("error" => "No go."));
	}
    
} else {
    header('X-PHP-Response-Code: 400', true, 400);

	$response = array("message" => "Unable to update hotel. Incomplete data.");
    echo json_encode($response);
	//var_dump($data);
}

?>