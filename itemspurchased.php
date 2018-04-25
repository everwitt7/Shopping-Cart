<?php

require 'database.php';
session_start();

$username = $_SESSION['username'];

$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($id);
$stmt->fetch();
$stmt->close();

//Iterates through all items with the unique seller_id and generates html on the page
$stmt = $mysqli->prepare("SELECT item_name, item_desc, buyer_id FROM purchased_items WHERE seller_id = ?");
if(!$stmt){
    echo json_encode(array("success" => false));
    exit;
}

$stmt->bind_param('s', $id);
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