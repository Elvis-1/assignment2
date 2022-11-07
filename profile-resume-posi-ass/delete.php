<?php
require_once "pdo.php";
session_start();
if(!isset($_SESSION['name'])){
    Die('Not logged in');
}

if(!isset($_SESSION['user_id'])){
    Die('Not logged in');
}
if(!isset($_GET['profile_id'])){
    Die('ACCESS DENIED');
}

$profile_id = $_GET['profile_id'];

if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

//Guardian: Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing auto_id";
  header('Location: view.php');
  return;
}

$stmt = $pdo->prepare("SELECT first_name, last_name FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elvis Aisosa Igiebor 1b2a9cbe</title>
</head>
<body>
<p>Confirm: Deleting Profile</p>

<form method="post">
<div class="mb-3">
    <label for="make">Firt Name</label>
    <input  type="text" class="form-control" value="<?= $row['first_name'] ?>" name="first_name" id="first_name">
    </div>
    <div class="mb-3">
    <label for="make">Last Name</label>
    <input  type="text" class="form-control" value="<?= $row['last_name'] ?>" name="last_name" id="last_name">
    </div>
<input type="hidden" name="profile_id" value="<?= $_GET['profile_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>
</body>
</html>


