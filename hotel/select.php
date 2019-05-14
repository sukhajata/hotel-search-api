<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

$where = '';
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$where = " WHERE h.id = $id";
}
$sql = "
	SELECT h.*, ST_X(h.position) AS latitude, ST_Y(h.position) AS longitude, t.name_english AS tambon_english, t.name_thai AS tambon_thai
	FROM hotels h 
	INNER JOIN tambons t ON h.tambon_id = t.id" .
	$where;
	
$stmtSelect = $conn->prepare($sql);
$stmtSelect->execute();

$hotels = array();
while($row = $stmtSelect->fetch(PDO::FETCH_ASSOC)) {
    $hotels[] = $row;
}

header('X-PHP-Response-Code: 200', true, 200);
print(json_encode($hotels));

?>
