<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

$id = $_REQUEST['id'];

$stmtSelect = $conn->prepare(
	"SELECT h.name_english AS hotel_name_english, 
	h.name_thai AS hotel_name_thai,
	rt.name_english AS room_type_english, 
	rt.name_thai AS room_type_thai, 
	r.price
	FROM rooms r
	INNER JOIN room_types rt ON r.room_type_id = rt.id 
	INNER JOIN hotels h ON r.hotel_id = h.id
	WHERE r.id = $id"
);
$stmtSelect->execute();

header('X-PHP-Response-Code: 200', true, 200);
print(json_encode($stmtSelect->fetch(PDO::FETCH_ASSOC)));

?>
