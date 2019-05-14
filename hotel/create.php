<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db.php';
require 'functions.php';

//https://mysqlserverteam.com/mysql-5-7-and-gis-an-example/

if (
	!empty($_REQUEST['name_english']) && 
	!empty($_REQUEST['name_thai']) &&
	!empty($_REQUEST['address_english']) &&
    !empty($_REQUEST['address_thai']) &&
	!empty($_REQUEST['tambon_id']) &&
    !empty($_REQUEST['lat']) &&
    !empty($_REQUEST['lng'])
) {
	
    $stmtInsert = $conn->prepare("
    INSERT INTO hotels(name_english, name_thai, address_english, address_thai, tambon_id, phone, position)
    VALUES (:name_english, :name_thai, :address_english, :address_thai, :tambon_id, :phone, ST_GeomFromText(:position))");
	
	$args = array(
		':name_english' => sanitize($_REQUEST['name_english']),
		':name_thai' => sanitize($_REQUEST['name_thai']),
		':address_english' => sanitize($_REQUEST['address_english']),
		':address_thai' => sanitize($_REQUEST['address_thai']),
		':tambon_id' => $_REQUEST['tambon_id'],
		':phone' => sanitize($_REQUEST['phone']),
		':position' => 'POINT(' . ($_REQUEST['lat']) . ' ' . ($_REQUEST['lng']) . ')'
	);

    if ($stmtInsert->execute($args)) {
        header('X-PHP-Response-Code: 201', true, 201);//created

        echo json_encode(array("id" => $conn->lastInsertId()));
    } else {
        // set response code - 503 service unavailable
        header('X-PHP-Response-Code: 503', true, 503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create hotel."));
    }
	
} else {
    header('X-PHP-Response-Code: 400', true, 400);

	$response = array("message" => "Unable to create hotel. Incomplete data.");
    echo json_encode($response);
}

?>