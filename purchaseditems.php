<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Purchased Items</title>
</head>
<body>

    <h1>Purchased Items</h1>

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
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();


    $stmt = $mysqli->prepare("SELECT item_name, item_desc, buyer_id FROM purchased_items WHERE seller_id = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
    $stmt->bind_result($item_name, $item_desc, $buyer_id);

    while($stmt->fetch()) {

        printf("\t<div style='border: 3px dotted grey; border-radius: 5px;'>
        <strong>Item Name: %s</strong>
        <p>Item Desc: %s</p>
        <p>Item Buyer ID: %s</p>
        </div>\n",
        htmlspecialchars($item_name),
        htmlspecialchars($item_desc),
        htmlspecialchars($buyer_id));

        echo "<br />";
    }

    $stmt->close();

    ?>

    <form class="" action="homepage.php" method="post">
        <input type="submit" value="Back to Homepage">
    </form>

</body>
</html>
