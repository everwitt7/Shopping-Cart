<?php
require 'database.php';
session_start();

$id = $_POST['item_id'];
$username = $_SESSION['username'];

$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

$stmt = $mysqli->prepare("DELETE FROM cart_items WHERE item_id = ? AND user_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('ss', $id, $user_id);
$stmt->execute();
$stmt->close();

header("Location: cartitems2.php");

?>
