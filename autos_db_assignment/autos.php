<?php 

require_once "pdo.php";
if(isset($_POST['logout']))
{
    header('Location: index.php');
}

if(!isset($_GET['name'])){
Die('Name Parameter missing');
}

$failure = false;
$success = false;

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) )
{
    if(strlen($_POST['make'])<1 )
    {
        $failure = 'Make is required'; 
   
    }else if(strlen($_POST['year'])<1 )
    {
        $failure = 'Year is required'; 
        
    }else if(strlen($_POST['mileage'])<1 )
    {
        $failure = 'Mileage is required'; 
        
    }else if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) )
    {
        $failure = 'Mileage and year must be numeric'; 
        
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])

      
    );
    $success = "Record inserted";
    $_POST['mileage'] = $_POST['year'] = $_POST['make'] = '';

    }


}else{
    $failure = "All details are necessary";
}

?>



<!DOCTYPE html>
<html>
<head>
<title>Elvis Aisosa Igiebor</title>
<?php 
require_once "bootstrap.php";

?>
</head>
<body>
<div class="container">
   
<h1>Tracking Autos Database for <?php if(isset($_GET['name'])){echo $_GET['name']; } ?></h1>
<?php
if ( $success !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
}
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
<form method="POST">
<label for="make">Make</label>
<input  type="text" name="make" id="make"><br/><br/>
<label for="year">Year</label>
<input type="text" name="year" id="year"><br/><br/>
<label for="mileage">Mileage</label>
<input type="text" name="mileage" id="mileage"><br/><br/>

<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
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
        echo "/ ";
        echo($row['mileage']);
        echo "</li>";
        echo("</ul>\n");
    }
 
?>
</div>
</body>

