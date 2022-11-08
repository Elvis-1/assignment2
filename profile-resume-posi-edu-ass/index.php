
<?php 
session_start();
require_once "pdo.php";
if(isset($_POST['logout']))
{
    header('Location: index.php');
    return;
}







?>
<!DOCTYPE html>
<html>
<head>
<title>Elvis Aisosa Igiebor b4f9264d</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Elvis Igiebor's Resume Registry</h1>


<?php 
//echo $_SESSION['user_id'];
if(isset($_SESSION['user_id']))
{
    echo "<p>
    <a href='logout.php'>Logout</a>
    </p>";
}else{
    echo "<p>
    <a href='login.php'>Please log in</a>
    </p>";
}
?>



<!-- <p>
Attempt to go to 
<a href="view.php">view.php</a> without logging in - it should fail with an error message.
</p> -->

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
$stmt = $pdo->query("SELECT profile_id,user_id,first_name,last_name, headline FROM profile");

$data = $stmt->fetchAll();
$count = 1;

echo('<table class="table">');
 echo ('<thead>');
  echo ('<tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Headline</th>
      <th scope="col">Action</th>
    </tr>');
 echo('</thead>');
 echo ('<tbody>');
foreach($data as $row){
    echo ('<tr>');
     echo ('<th scope="row">');
     echo $count;
     echo ('</th>');
     echo('<td>');
      echo('<a href="view.php?profile_id='.$row['profile_id'].'">');
      echo (htmlentities($row['first_name']));
      echo(' ');
      echo (htmlentities($row['last_name']));
      
      
      echo('</td>');
     echo('<td>');
      echo(htmlentities($row['headline']));
      echo('</td>');
      echo ('<td>');
      echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
      echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');

      echo ('</td>');
    echo ('</tr>');
$count ++;

}
echo ('</tbody>
</table>');

if(count($data)<1)
{
    echo 'No rows found';
    echo '<br><br>';
}

?>


<?php
if(isset($_SESSION['user_id']))
{
    echo "<p>
    <a href='add.php'>Add New Entry</a>
    </p>";
}

?>
</div>
</body>

