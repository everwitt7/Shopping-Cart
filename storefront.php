<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Shopping Cart Items</title>
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/blitzer/jquery-ui.css"
    type="text/css" rel="Stylesheet" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/react/15.3.1/react.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/react/15.3.1/react-dom.min.js'></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.css'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    require 'database.php';
    session_start();
    $username = $_SESSION['username'];
    ?>
    <form class="" action="homepage.php" method="post">
        <input type="submit" value="Back to Homepage">
    </form>

    <h1>Your Storefront</h1>
    <div id="app"></div>
    <script  src="itemsforsale.js"></script>
</body>
</html>
