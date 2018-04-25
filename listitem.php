<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>List an Item</title>
</head>
<body>

    <h1>List An Item To Sell</h1>

    <form action="?" id="listItem" method="POST">

        <input type="text" name="item_name" required placeholder="Item Name">

        <input type="text" name="item_desc" required placeholder="Item Description">

        <input type="submit" id="list_item_btn" name="submit" value="List Item">

    </form>

    <br>

    <form action="homepage.php" method="post">

        <input type="submit" value="Back to Homepage">

    </form>


</body>
</html>

<?php

require 'database.php';
session_start();

if(isset($_POST['submit'])) {

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

    $itemName = $_POST['item_name'];
    $itemDesc = $_POST['item_desc'];

    $stmt = $mysqli->prepare("INSERT INTO items (seller_id, item_name, item_desc) VALUES (?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sss', $id, $itemName, $itemDesc);
    $stmt->execute();
    $stmt->close();

    header("Location: homepage.php");

}
?>
