<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

$id = $_REQUEST['id'];

$stmtSelect = $conn->prepare("SELECT * FROM hotel_photos WHERE hotel_id = $id");
$stmtSelect->execute();

$photos = array();
while($photo = $stmtSelect->fetch(PDO::FETCH_ASSOC)) {
	$photos[] = $photo;
}

header('X-PHP-Response-Code: 200', true, 200);
print(json_encode($photos));

?>
