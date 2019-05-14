<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

$stmtSelect = $conn->prepare("SELECT * FROM room_types");
$stmtSelect->execute();

$types = array();
while($row = $stmtSelect->fetch(PDO::FETCH_ASSOC)) {
    $types[] = $row;
}

header('X-PHP-Response-Code: 200', true, 200);
print(json_encode($types));

?>
