<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

if (
	!empty($_REQUEST['arrive']) &&
	!empty($_REQUEST['depart'])
) {
	$stmtHotels = $conn->prepare(
		"SELECT id AS hotel_id, 
		name_english AS hotel_name_english, 
		name_thai AS hotel_name_thai,
		ST_X(position) AS latitude,
		ST_Y(position) AS longitude
		FROM hotels"
	);
	$stmtHotels->execute();
	
	$hotels = array();
	while($hotel = $stmtHotels->fetch(PDO::FETCH_ASSOC)) {
		$id = $hotel['hotel_id'];
		$stmtRooms = $conn->prepare("SELECT price FROM rooms WHERE hotel_id = $id AND price > 0 ORDER BY price LIMIT 1");
		$stmtRooms->execute();
		
		$hotel['min_price'] = $stmtRooms->fetchColumn();
		
		$stmtPhoto = $conn->prepare("SELECT image_name FROM hotel_photos WHERE hotel_id = $id AND is_default = 1");
		$stmtPhoto->execute();
		$hotel['image_name'] = $stmtPhoto->fetchColumn();
		
		$hotels[] = $hotel;
	}
	

	header('X-PHP-Response-Code: 200', true, 200);
	print(json_encode($hotels));
} else {
	header('X-PHP-Response-Code: 400', true, 400);
	$response = array("message" => "Unable to update. Incomplete data.");
    echo json_encode($response);
}
?>
