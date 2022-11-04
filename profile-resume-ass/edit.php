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


if ( isset($_POST['first_name']) && isset($_POST['last_name'])
     && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['profile_id']) ) {

    // Data validation
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['summary']) < 1 || strlen($_POST['headline']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    if ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = 'Email address must contain @';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    $sql = "UPDATE profile SET first_name = :fn,
            last_name = :ln, email = :em, headline = :hd, summary=:sm
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hd' => $_POST['headline'],
        ':sm' => $_POST['summary'],
        ':profile_id' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}


// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}


$stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//check if profile exists
if($row === false)
{
    $_SESSION['error'] = 'Profile does not exist';
    header('Location: index.php');
    return;
}

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$hd = htmlentities($row['headline']);
$sm = htmlentities($row['summary']);

// $auto_id = $row['auto_id'];



// check if current logged in user is the creator of the profile
if($row['user_id'] != $_SESSION['user_id'])
{
    $_SESSION['error'] = 'You can only update the profile you created';
    header('Location: index.php');
    return;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elvis Aisosa Igiebor bbf82110</title>
</head>
<body>

<h2>Editing Profile for <?= $_SESSION['name'] ?></h2>
<!-- <form method="post">
<p>Make:
<input type="text" name="make" value="<?= $mk ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $md ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $y ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $ml ?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<p><input type="submit" value="Save"/>
<a href="view.php">Cancel</a></p>
</form> -->

<span class="text-bg-danger" id="error"></span>
<form method="POST">
<div class="container">
  <div class="row">
    <div class="col-md-8">
    <div class="col-md-8">
    <div class="mb-3">
    <label for="make">Firt Name</label>
    <input  type="text" class="form-control" value="<?= $fn ?>" name="first_name" id="first_name">
    </div>
    <div class="mb-3">
    <label for="make">Last Name</label>
    <input  type="text" class="form-control" value="<?= $ln ?>" name="last_name" id="last_name">
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Email</label>
      <input type="" name ="email" class="form-control" value="<?= $em ?>" id="email" placeholder="name@example.com">
    </div>
    <div class="mb-3">
      <label for="headline" class="form-label">Headline</label>
      <input type="text" class="form-control"value="<?= $hd ?>" name="headline" id="headline" placeholder="Software Engineer">
    </div>
    <div class="mb-3">
    <label for="summary" class="form-label">Summary</label>
    <textarea  class="form-control" id="summary" name="summary" value="<?= $sm ?>" rows="3"><?= $sm ?></textarea>
    </div>
    <input type="hidden" class="form-control" value="<?= $profile_id ?>" name="profile_id">
    <br><br>
    <input type="submit" onclick=" return doValidate();" class = "btn btn-success mb-3" value="Save">
    <input type="submit" class = "btn btn-primary" name="logout" value="Cancel">
    </div>
    
  </div>
  
</div>


</form>
</body>
</html>

