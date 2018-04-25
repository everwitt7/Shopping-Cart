<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Shopping Cart Items</title>
</head>
<body>

    <h1>Shopping Cart Items</h1>

    <?php

    require 'database.php';
    session_start();

    $username = $_SESSION['username'];

    $stmt = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?"); //gets the user_id associated with username
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
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

    // can't query twice, so put all item id's in a list and iterate through
    foreach($temp_items as $cur_item_id) {

        $stmt = $mysqli->prepare("SELECT item_name, item_desc FROM items WHERE item_id = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('s', $cur_item_id);
        $stmt->execute();
        $stmt->bind_result($item_name, $item_desc);
        $stmt->fetch();
        $stmt->close();

        //generate forms associated with the item names and their descs

        $form1 = "<form action=removeitem.php method='POST'>
        <input type='submit' value='remove item from cart'/>
        <input type='hidden' name='item_id' value='$cur_item_id'/>
        </form>";

        $form2 = "<form action=saveitem.php method='POST'>
        <input type='submit' value='save item for later'/>
        <input type='hidden' name='item_id' value='$cur_item_id'/>
        </form>";

        printf("\t<div class='ItemList' style='border: 3px dotted grey; border-radius: 5px;'><strong>Item Name: %s</strong><p>Item Desc: %s</p></div>\n",
        htmlspecialchars($item_name),
        htmlspecialchars($item_desc));

        echo "$form1";
        echo "$form2";
        echo "<br />";
    }

    ?>

    <form class="" action="checkout.php" method="post">
        <input type="submit" value="Checkout">
    </form>

    <br>

    <form class="" action="homepage.php" method="post">
        <input type="submit" value="Back to Homepage">
    </form>

</body>
</html>
