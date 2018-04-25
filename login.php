<?php

require 'database.php';
session_start();

$user = $_POST['user'];
$pass = $_POST['pass'];
$account = $_POST['account'];
$phone = $_POST['phone'];

if(isset($_POST['log'])) {

    //Use a prepared statement
    $stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username= ?");
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $stmt->bind_result($cnt, $user_id, $pwd_hash);
    $stmt->fetch();
    $stmt->close();

    if($cnt == 1 && password_verify($pass, $pwd_hash)){
    	// Login succeeded!
    	$_SESSION['username'] = $user_id;
        $_SESSION['account'] = $account;
    	// Redirect to your target page
    	header("Location: homepage.php");
    } else{
    	// Login failed; redirect back to the login screen
    	header("Location: login.html");
    }


}
elseif(isset($_POST['reg'])) {

    $saltedPass = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
    if(!$stmt){
    	printf("Query Prep Failed: %s\n", $mysqli->error);
    	exit;
    }
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();

    if (strcmp($result, $user) == 0) {
        header("Location: login.html");
    } else {

        $_SESSION['username'] = $user;
        $_SESSION['account'] = $account;

        $stmt = $mysqli->prepare("INSERT INTO users (username, password, role, phone_number) VALUES (?, ?, ?, ?)");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        } else {
            $stmt->bind_param('ssss', $user, $saltedPass, $account, $phone);
            $stmt->execute();
            $stmt->close();
            header("Location: homepage.php");
        }
    }
}

?>
