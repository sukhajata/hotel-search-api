<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db.php';

if (
	!empty($_REQUEST['id']) && 
	!empty($_REQUEST['room_count']) &&
	!empty($_REQUEST['price'])
) {
	$stmtUpdate = $conn->prepare(
		"UPDATE rooms 
		SET count = :room_count,
		price = :price
		WHERE id = :id"
	);
	
	$args = array(
		':room_count' => $_REQUEST['room_count'],
		':price' => $_REQUEST['price'],
		':id' => $_REQUEST['id']
	);
	
	if ($stmtUpdate->execute($args)) {
		header('X-PHP-Response-Code: 200', true, 200);
		echo json_encode(array("message" => "Room updated"));	
	} else {
		header('X-PHP-Response-Code: 503', true, 503);
		echo json_encode(array("error" => "An error occurred"));
	}
    
} else {
    header('X-PHP-Response-Code: 400', true, 400);
	$response = array("message" => "Unable to update. Incomplete data.");
    echo json_encode($response);
}

?>