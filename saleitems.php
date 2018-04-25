<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Seller's Market Items</title>
</head>
<body>

    <h1>Items Currently Trying to Sell</h1>

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
    $stmt = $mysqli->prepare("SELECT item_name, item_desc, item_id FROM items WHERE seller_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->bind_result($item_name, $item_desc, $item_id);

    while($stmt->fetch()) {
        $form = "<form action=deleteitem.php method='POST'>
        <input type='submit' value='delete item'/>
        <input type='hidden' name='item_id' value='$item_id'/>
        </form>";

        printf("\t<div class='ItemList' style='border: 3px dotted grey; border-radius: 5px;'><strong>Item Name: %s</strong><p>Item Desc: %s</p></div>\n",
        htmlspecialchars($item_name),
        htmlspecialchars($item_desc));

        echo "$form";
        echo "<br />";
    }

    $stmt->close();

    ?>

    <form class="" action="homepage.php" method="post">
        <input type="submit" value="Back to Homepage">
    </form>

</body>
</html>
