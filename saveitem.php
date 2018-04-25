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




$no_duplicate = 1;

$stmt = $mysqli->prepare("SELECT item_id FROM saved_items WHERE user_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $user_id);
$stmt->execute();
$stmt->bind_result($temp_item_id);


while($stmt->fetch()) {
    if(strcmp($temp_item_id, $id) == 0) {
        $no_duplicate = 0;
    }
}

if($no_duplicate == 1) {
    $stmt = $mysqli->prepare("INSERT INTO saved_items (user_id, item_id) VALUES (?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ss', $user_id, $id);
    $stmt->execute();
    $stmt->close();
}


header('Location: ' . $_SERVER['HTTP_REFERER']);

?>
