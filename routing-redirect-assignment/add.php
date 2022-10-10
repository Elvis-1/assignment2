<?php 

require_once "pdo.php";
session_start();
if(isset($_POST['logout']))
{
    header('Location: logout.php');
    return;
}

if(!isset($_SESSION['name'])){
Die('Not logged In');
}



if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) )
{
    if(strlen($_POST['make'])<1 )
    {
        $_SESSION['error'] = 'Make is required'; 
        header("Location: add.php");
        return;
   
    }else if(strlen($_POST['year'])<1 )
    {
        $_SESSION['error'] = 'Year is required'; 
        header("Location: add.php");
        return;
        
    }else if(strlen($_POST['mileage'])<1 )
    {
        $_SESSION['error'] = 'Mileage is required'; 
        header("Location: add.php");
        return;
        
    }else if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year']) )
    {
        $_SESSION['error'] = 'Mileage and year must be numeric'; 
        header("Location: add.php");
        return;
        
    }
    else{
        $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])

      
    );
    $_SESSION['success'] = "Record inserted";
    header("Location: view.php");
    return;
   // $_POST['mileage'] = $_POST['year'] = $_POST['make'] = '';

    }


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
if (isset($_SESSION['success'])) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
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
<!-- <br>
<button><a href="view.php">View Autos</a></button> -->
</body>

