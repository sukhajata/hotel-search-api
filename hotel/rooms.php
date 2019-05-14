<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

$id = $_REQUEST['id'];

$stmtSelect = $conn->prepare(
	"SELECT r.id, r.room_type_id, rt.name_english, rt.name_thai, r.count, r.price
	FROM rooms r 
	INNER JOIN room_types rt ON r.room_type_id = rt.id 
	WHERE r.hotel_id = $id"
);
$stmtSelect->execute();

$types = array();
while($row = $stmtSelect->fetch(PDO::FETCH_ASSOC)) {
	$id = $row['id'];
	$stmtPhotos = $conn->prepare("SELECT image_name, is_default FROM room_photos WHERE room_id = $id");
	$stmtPhotos->execute();
	$images = array();
	while($image = $stmtPhotos->fetch(PDO::FETCH_ASSOC)) {
		$images[] = $image;
	}
	$row['images'] = $images;
    $types[] = $row;
}

header('X-PHP-Response-Code: 200', true, 200);
print(json_encode($types));

?>
