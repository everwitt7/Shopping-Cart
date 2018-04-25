<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Shop Items</title>
</head>
<body>

    <h1>Shop Items</h1>

    <?php
    require 'database.php';
    session_start();

    $stmt = $mysqli->prepare("SELECT item_name, item_desc, item_id FROM items");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->bind_result($item_name, $item_desc, $item_id);

    while($stmt->fetch()) {

        $form = "<form action=addtocart.php method='POST'>
        <input type='submit' value='add to cart'/>
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
