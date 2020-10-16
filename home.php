<?php session_start();
include 'config.php';

//Create the connection to the authenticated adapter 
try{
    $hybridauth = new Hybridauth\Hybridauth($config);
    $adapter = $hybridauth->authenticate($_SESSION['provider']);
}
catch(Exception $e){
    //If the connection fails (e. g. unauthenticated user types in home.php-URL in the address bar directly, redirect to login)
    Header("Location:index.php");
}

//Store the necessary data in session variables
$userProfile = $adapter->getUserProfile();
$_SESSION['email'] = $userProfile->email;
$_SESSION['name'] = $userProfile->firstName . " " . $userProfile->lastName;
$_SESSION['photoURL'] = $userProfile->photoURL;


//Establish a connection to the MySQL database
include ("includes/dbconnect.php"); ?>

<!--- HTML for the main page.-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/04b6d90103.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="script.js"></script>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <title>PDinfo</title>
    </head>
    <body>
        <!--- Check authentication -->
        <?php include ("includes/auth_check.php"); ?>
        <!--- Display header -->
        <?php include ("includes/header.php"); ?>
        <!--- Display content (role-based-access control) -->
        <?php include ("includes/content_control.php")?>
    </body>
</html>