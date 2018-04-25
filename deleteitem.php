<?php
require 'database.php';
session_start();

$id = $_POST['item_id'];

// delete from cart_items, saved_items, and items in that order

$stmt = $mysqli->prepare("DELETE FROM cart_items WHERE item_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("DELETE FROM saved_items WHERE item_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("DELETE FROM items WHERE item_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $id);
$stmt->execute();
$stmt->close();

header("Location: storefront.php");

?>
