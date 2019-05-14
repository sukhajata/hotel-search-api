<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db.php';

if (
	!empty($_REQUEST['hotel_id']) && 
	!empty($_REQUEST['room_type_id']) &&
	!empty($_REQUEST['room_count']) &&
	!empty($_REQUEST['price']) 
) {
	$stmtInsert = $conn->prepare("INSERT INTO rooms (hotel_id, room_type_id, count, price) VALUES(:hotel_id, :room_type_id, :room_count, :price)");
	
	$args = array(
		':hotel_id' => $_REQUEST['hotel_id'],
		':room_type_id' => $_REQUEST['room_type_id'],
		':room_count' => $_REQUEST['room_count'],
		':price' => $_REQUEST['price']
	);
	
	if ($stmtInsert->execute($args)) {
		header('X-PHP-Response-Code: 201', true, 201);
		echo json_encode(array("message" => "Room created."));
	} else {
		header('X-PHP-Response-Code: 503', true, 503);
		echo json_encode(array("message" => "Operation failed."));
	}
    
} else {
    header('X-PHP-Response-Code: 400', true, 400);

	$response = array("message" => "Unable to create rooms. Incomplete data.");
    echo json_encode($response);
	//echo json_encode($data);
}

?>