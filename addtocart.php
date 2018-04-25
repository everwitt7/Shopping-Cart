<?php
require 'database.php';
session_start();

// contains the item id and the username
$id = $_POST['item_id'];
$username = $_SESSION['username'];

// gets the user_id associated with the unique username
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

// add the item to the user's cart then take them back to the shop items page (if no duplicates)
$no_duplicate = 1;

$stmt = $mysqli->prepare("SELECT item_id FROM cart_items WHERE user_id = ?");
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

// only adds to the cart if the item is not already there to avoid duplicates
if($no_duplicate == 1) {
    $stmt = $mysqli->prepare("INSERT INTO cart_items (user_id, item_id) VALUES (?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ss', $user_id, $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: browseitems.html");

?>
