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




?>



<!DOCTYPE html>
<html>
<head>
<title>Elvis Aisosa Igiebor 832e0fce</title>
<?php 
require_once "bootstrap.php";

?>
</head>
<body>
<div class="container">
   
<h1>Welcome to Automobiles Database</h1>
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
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");

$data = $stmt->fetchAll();



foreach($data as $row)
{
    echo "<tr '><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
    echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
    echo("</td></tr>\n");

    
}
if(count($data)<1)
{
    echo 'No rows found';
    echo '<br><br>';
}

    // while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    //     echo "<tr '><td>";
    //     echo(htmlentities($row['make']));
    //     echo("</td><td>");
    //     echo(htmlentities($row['model']));
    //     echo("</td><td>");
    //     echo(htmlentities($row['year']));
    //     echo("</td><td>");
    //     echo("</td><td>");
    //     echo(htmlentities($row['mileage']));
    //     echo("</td><td>");
    //     echo('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
    //     echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
    //     echo("</td></tr>\n");
    
    
    // }




    

?>
</table>

 <br><br>
<p><a href="add.php">Add New Entry</a></p>
<p><a href="logout.php"> Logout</a></p>
</div>


</body>

