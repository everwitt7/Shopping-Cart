<?php
require __DIR__ . '/twilio-php-master 3/Twilio/autoload.php';
use Twilio\Rest\Client;
require 'database.php';
session_start();

//from twilio's api -> putting in all my account information
$account_sid = 'ACd34a5cfbf3519f396603da146fa93d1b';
$auth_token = 'ca031c6b36f74d8744e916bc791a4bb3';
$twilio_number = "+16467984840";

$client = new Client($account_sid, $auth_token);

$username = $_SESSION['username'];


$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?"); //gets user_id
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();



$temp_items = [];

$stmt = $mysqli->prepare("SELECT item_id FROM cart_items WHERE user_id = ?"); //gets all item id's in user's cart
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $user_id);
$stmt->execute();
$stmt->bind_result($item_id);

while($stmt->fetch()) {
    array_push($temp_items, $item_id);
}
$stmt->close();

foreach($temp_items as $cur_item_id) {

    $stmt = $mysqli->prepare("SELECT seller_id, item_name, item_desc FROM items WHERE item_id = ?"); //get more info on item
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $cur_item_id);
    $stmt->execute();
    $stmt->bind_result($seller_id, $item_name, $item_desc);
    $stmt->fetch();
    $stmt->close();

    //put the item into purchased items
    $stmt = $mysqli->prepare("INSERT INTO purchased_items (seller_id, buyer_id, item_name, item_desc) VALUES (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ssss', $seller_id, $user_id, $item_name, $item_desc);
    $stmt->execute();
    $stmt->close();

    //remove from cart items
    $stmt = $mysqli->prepare("DELETE FROM cart_items WHERE item_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $cur_item_id);
    $stmt->execute();
    $stmt->close();

    //remove from saved items
    $stmt = $mysqli->prepare("DELETE FROM saved_items WHERE item_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $cur_item_id);
    $stmt->execute();
    $stmt->close();

    //remove from items
    $stmt = $mysqli->prepare("DELETE FROM items WHERE item_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $cur_item_id);
    $stmt->execute();
    $stmt->close();


    // SEND TEXT MESSAGE TO SELLER_ID's NUMBER SAYING HIS PRODUCT WAS SOLD
    // SEND TEXT MESSAGE TO BUYER_ID's NUMBER SAYING HIS PURCHASE WAS SUCCESSFUL

    $stmt = $mysqli->prepare("SELECT phone_number FROM users WHERE user_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $seller_id);
    $stmt->execute();
    $stmt->bind_result($seller_number);
    $stmt->fetch();
    $stmt->close();

    // implementing twilio

    try {
        $client->messages->create(
            // phone to send a text message 
            $seller_number,
            array(
                'from' => $twilio_number,
                'body' => 'Your item has just been purchased!'
            )
        );
    } catch (Exception $e) {
        //invalid phone number
    }
}


$stmt = $mysqli->prepare("SELECT phone_number FROM users WHERE user_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $user_id);
$stmt->execute();
$stmt->bind_result($buyer_number);
$stmt->fetch();
$stmt->close();

try {
    $client->messages->create(
        // Where to send a text message (your cell phone?)
        $buyer_number,
        array(
            'from' => $twilio_number,
            'body' => 'Your Checkout was Successful!'
        )
    );
} catch (Exception $e) {
    //invalid phone number
}
//echo("success");
header("Location: homepage.php");

?>
