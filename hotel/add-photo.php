<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db.php';

if(
	!empty($_REQUEST['hotel_id']) &&
	!empty($_REQUEST['image_name']) &&
	!empty($_REQUEST['is_default'])
	) {
		$stmtInsert = $conn->prepare("INSERT INTO hotel_photos (hotel_id, image_name, is_default) VALUES(:hotel_id, :image_name, :is_default)");
		$args = array(
			':hotel_id' => $_REQUEST['hotel_id'],
			':image_name' => $_REQUEST['image_name'],
			':is_default' => $_REQUEST['is_default'] == 'false' ? false : true
		);
		
		if ($stmtInsert->execute($args)) {
		header('X-PHP-Response-Code: 201', true, 201);
		echo json_encode(array("message" => "Photo added"));	
	} else {
		header('X-PHP-Response-Code: 503', true, 503);
		echo json_encode(array("error" => "An error occurred"));
	}
} else {
	 header('X-PHP-Response-Code: 400', true, 400);
	$response = array("message" => "Unable to execute. Incomplete data.");
    echo json_encode($response);
}
?>