<?php
require_once "pdo.php";
require_once "util.php";
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
  // validate profile
  $msg = validateProfile();

  if(is_string($msg))
  {
    $_SESSION['error'] = $msg;
    header("Location: edit.php?profile_id=".$_POST['profile_id']);
    return;
  }

  // validate position
     $msg = validatePos();
   if(is_string($msg))
           {
            $_SESSION['error'] = $msg;
            header("Location: edit.php?profile_id=".$_POST['profile_id']);
            return;
           }
  $msg = validateEducation();
  if(is_string($msg))
  {
   $_SESSION['error'] = $msg;
   header("Location: edit.php?profile_id=".$_POST['profile_id']);
   return;
  }
//Clear out the old position entries
$stmt = $pdo->prepare('DELETE FROM Position WHERE profile_id=:pid');
$stmt->execute(array( ':pid' => $_REQUEST['profile_id']));

//Clear out the old education entries
$stmt = $pdo->prepare('DELETE FROM education WHERE profile_id=:pid');
$stmt->execute(array( ':pid' => $_REQUEST['profile_id']));



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

        
// Insert the position entries
insertPosition($pdo,$_REQUEST['profile_id']);
// Insert the education entries
insertEducation($pdo,$_REQUEST['profile_id']);


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
// load positions
$positions = loadPosition($pdo, $_REQUEST['profile_id']);



// load educations

$educations = loadEducation($pdo, $_REQUEST['profile_id']);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elvis Aisosa Igiebor b4f9264d</title>

    <?php 
require_once "bootstrap.php";


?>

<script type="text/javascript" src="jquery.min.js">
</script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>



<span class="text-bg-danger" id="error"></span>
<form method="POST">
<div class="container">
<h2>Editing Profile for <?= $_SESSION['name'] ?></h2>
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
   
    <div class="mb-3">
    <label for="addEdu" class="form-label">Education :</label>
    <input class="" type="button" id="addEdu" name="" value="+" rows="3">
    </div>
   
    <div id="edu_fields">
    <?php
 $countEdu = 0;
 if(count($educations)>0)
 {
  foreach($educations as $education)
  {
    $countEdu++;
echo '<div id="edu'.$countEdu.'">
 <p>Year: <input type="text" name=edu_year' .$countEdu. ' value="'.$education['year'].'">
 <input type="button" value="-" onclick="$(\'#edu'.$countEdu.'\').remove();return false;"></p>
  <p>School: <input type="text" size="80" class="school" name=edu_school' .$countEdu.' value="'.$education['name'].'"></p>
</div>';
  }
 }
    ?>

    </div>


    <!-- positions -->

    <div class="mb-3">
    <?php
$countPos = 0;
echo('<label for="addPos" class="form-label">Position :</label>
<input class="" type="button" id="addPos" name="" value="+" rows="3">'."\n");
echo(' <div id="position_fields">'."\n");
 if(count($positions)>0){
  foreach($positions as $position)
  {
    $countPos++;
    echo('<div id="position'.$countPos.'">');
    echo '<p>Year: <input type="text" name=year'. $countPos .' value='.$position['year'].'>
    
   <input type="button" value="-" onclick="$(\'#position'.$countPos.'\').remove();return false;"></p>';
   echo('<textarea name="desc'.$countPos.'" rows="8" cols="80" >'.$position['description'].'</textarea>'."\n");
   echo(' </div>'."\n");
  }
 }
?>
    <!-- <label for="summary" class="form-label">Position :</label>
    <input class="" type="button" id="addPos" name="" value="+" rows="3"> -->
    </div>
   
    <br><br>
    <input type="submit" onclick=" return doValidate();" class = "btn btn-success mb-3" value="Save">
    <input type="submit" class = "btn btn-primary" name="logout" value="Cancel">
    </div>

  </div>
  
</div>



</form>

<script>
     countPos = <?= $countPos ?>;
     countEdu = <?= $countEdu ?>;
     console.log('this is count pos '+countPos);
     console.log('this is count edu '+ countEdu);
  
  // check if the document is ready, then call the function
  $(document).ready(function(){
  // // send message to console

   console.log('Ducment is ready');
   $('#addPos').click(function(event){
          // // check if countPos >= 9 and send an alert;
  if(countPos >= 9)
  {
    alert('You can\'t add more than 9 positions');
    return;
  }

  // increase countPos and add it to the div
      countPos++;
  // window.console && console.log('Adding position :'+ countPos);
  // append the div
  event.preventDefault();
  $('#position_fields').append(
'<div id="position'+countPos+'">\
<p>Year: <input type="text" name=year' +countPos+ ' value="">\
<input type="button" value="-" onclick="$(\'#position'+countPos+'\').remove();return false;"></p>'+
'<textarea name="desc'+countPos+'" rows="8" cols="80" ></textarea>\
</div>'
  );
   });

   /* Validate education data */
   $('#addEdu').click(function(event){
    event.preventDefault();
    if(countEdu >= 9)
    {
      alert('You can\'t add more than 9 educations');
      return;
    }

    countEdu++;

'<div>'
event.preventDefault();
    $('#position_fields').append(
'<div id="edu'+countEdu+'">\
 <p>Year: <input type="text" name=edu_year' +countEdu+ ' value="">\
 <input type="button" value="-" onclick="$(\'#edu'+countEdu+'\').remove();return false;"></p>'+
  '<p>School: <input type="text" size="80" class="school" name=edu_school' +countEdu+ ' value="">\
</div>'
    );
    $('.school').autocomplete({
source: "school.php"
    }); 

     });

     $('.school').autocomplete({
source: "school.php"
    });


  });
</script>
</body>
</html>

