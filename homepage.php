<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <title>Homepage</title>
</head>
<body>
    <!-- particles.js container -->
    <div id="particles-js"></div>

    <!-- particles.js lib (JavaScript CodePen settings): https://github.com/VincentGarreau/particles.js -->
      <script src='https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js'></script>
    <script src='https://threejs.org/examples/js/libs/stats.min.js'></script>
    <script  src="particles.js"></script>

    <form action="logout.php" method="post">
        <input type="submit" value="Logout">
    </form>

    <?php
    require 'database.php';
    session_start();

    $username = $_SESSION['username'];

    $stmt = $mysqli->prepare("SELECT role FROM users WHERE username = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($account);
    $stmt->fetch();
    $stmt->close();

    echo "<h1>Welcome ".$username."! You are a ".$account."</h1>";

    $b = "Buyer";

    if (strcmp($b, $account) == 0) {
        //load buyer page
        echo "<div class='holder2'>";
        echo "<form action='browseitems.html'>
        <input type='submit' name='shopitems' value='Shop Items'>
        </form>";

        echo "<br />";

        echo "<form action='cartitems2.php' method='post'>
        <input type='submit' name='cartitems' value='View Cart Items'>
        </form>";

        echo "<br />";

        echo "<form action='saveditems.html' method='post'>
        <input type='submit' name='saveditems' value='Saved Items'>
        </form>";
        echo "</div>";
    } else {
        //load seller page
        echo "<div class='holder2'>";
        echo "<form action='listitem.php' method='post'>
        <input type='submit' name='sellitems' value='Sell Items'>
        </form>";

        echo "<br />";

        echo "<form action='storefront.php' method='post'>
        <input type='submit' name='saleitems' value='View Items for Sale'>
        </form>";

        echo "<br />";

        echo "<form action='salehistory.php' method='post'>
        <input type='submit' name='purchaseditems' value='Purchased Items'>
        </form>";
        echo "</div>";

    }

    ?>

    <br>
</body>
</html>
