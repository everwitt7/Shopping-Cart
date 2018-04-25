<?php
require 'database.php';
header("Content-Type: application/json");
session_start();


$username = $_SESSION['username'];

$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?");
if(!$stmt){
	echo json_encode(array("success" => false));
    exit;
}

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($id);
$stmt->fetch();
$stmt->close();

$temp_items = [];
//Iterates through all items with the unique seller_id and generates html on the page
$stmt = $mysqli->prepare("SELECT item_id FROM cart_items WHERE user_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->bind_result($item_id);

while($stmt->fetch()) {
    array_push($temp_items, $item_id);
}
$stmt->close();

$itemArray = array();
$itemArray[] = array("success" => true);

foreach($temp_items as $cur_item_id) {

    $stmt = $mysqli->prepare("SELECT item_name, item_desc, item_id FROM items WHERE item_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $cur_item_id);
    $stmt->execute();

	$result = $stmt->get_result();

	while($row = $result->fetch_assoc()){
		$itemArray[] = $row;
	}

	$stmt->close();

}
echo json_encode($itemArray);
exit;

?>
