<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'db.php';

$stmtSelect = $conn->prepare("SELECT * FROM tambons");
$stmtSelect->execute();

$tambons = array();
while($row = $stmtSelect->fetch(PDO::FETCH_ASSOC)) {
    $tambons[] = $row;
}

header('X-PHP-Response-Code: 200', true, 200);//created
print(json_encode($tambons));

?>
