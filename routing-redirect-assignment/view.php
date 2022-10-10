<?php 
session_start();
require_once "pdo.php";
if(isset($_POST['logout']))
{
    header('Location: index.php');
    return;
}

if(!isset($_SESSION['name'])){
Die('Not Logged In');
}




?>



<!DOCTYPE html>
<html>
<head>
<title>Elvis Aisosa Igiebor 99d0f158</title>
<?php 
require_once "bootstrap.php";

?>
</head>
<body>
<div class="container">
   
<h1>Tracking Autos Database for <?php if(isset($_SESSION['name'])){echo $_SESSION['name']; } ?></h1>
<?php
if (isset($_SESSION['success']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}

?>

<div class="h2">Automobiles</div>
<?php
  $stmt = $pdo->query("SELECT make,year, mileage FROM autos");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ( $rows as $row ) {
        echo "<ul>";
        echo "<li>";
        echo($row['year']);
        echo " ";
        echo($row['make']);
        echo " / ";
        echo($row['mileage']);
        echo "</li>";
        echo("</ul>\n");
    }
 
?>
<p><a href="add.php">Add New</a>|<a href="logout.php"> Logout</a></p>
</div>


</body>

