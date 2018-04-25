<?php
require 'database.php';
header("Content-Type: application/json");
session_start();

$stmt = $mysqli->prepare("SELECT item_name, item_desc, item_id FROM items");
if(!$stmt){
	echo json_encode(array("success" => false));
    exit;
}

$stmt->execute();
$itemArray = array();
$itemArray[] = array("success" => true);
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
	$itemArray[] = $row;
}

$stmt->close();
echo json_encode($itemArray);
exit;
?>
