<?php 
session_start();
require_once "pdo.php";
if(isset($_POST['logout']))
{
    header('Location: index.php');
    return;
}

if(!isset($_SESSION['name'])){
Die('ACCESS DENIED');
}

// check if the user is logged in

if(!isset($_SESSION['user_id']))
{
    Die('ACCESS DENIED');
}
// check for GET parameter
if(!isset($_GET['profile_id']))
{
  Die('ACCESS DENIED');
 
}


$profile_id = $_GET['profile_id'];

?>



<!DOCTYPE html>
<html>
<head>
<title>Elvis Aisosa Igiebor bbf82110</title>
<?php 
require_once "bootstrap.php";

?>
</head>
<body>
<div class="container">
   

 <?php 
// if (isset($_SESSION['success']) ) {
//     // Look closely at the use of single and double quotes
//     echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
//     unset($_SESSION['success']);
// }

?> 


<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

$stmt = $pdo->query("SELECT * FROM profile WHERE profile_id = '$profile_id'");

$data = $stmt->fetch();

if($data == null || $data == "")
{
    Die('Access Denied');
}
   
?>

<div class="container">
<h1>Profile Information</h1>

<div class="row">
    <div class="col-md-4">
        <p>First Name</p>
        <p>Last Name</p>
        <p>Email</p>
        <p>Headline</p>
        <p>Summary</p>
    </div>
    <div class="col-md-4">
        <?php
   echo '<p>'.$data['first_name'].'</p>';
   echo '<p>'.$data['last_name'].'</p>';
   echo '<p>'.$data['email'].'</p>';
   echo '<p>'.$data['headline'].'</p>';
   echo '<p>'.$data['summary'].'</p>';
    ?>
    </div>

   

</div>
<br>
<a class="link" href="index.php">Done</a>
</div>


</body>

