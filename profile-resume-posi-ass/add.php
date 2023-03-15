<?php 

require_once "pdo.php";
require_once "utils.php";
session_start();
if(isset($_POST['logout']))
{
    header('Location: index.php');
    return;
}

if(!isset($_SESSION['name']) || !isset($_SESSION['user_id'])){
Die('ACCESS DENIED');
}




if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) )
{
 
  //  echo $_SESSION['name'];
   // validate profile
  $msg = validateProfile();

  if(is_string($msg))
  {
    $_SESSION['error'] = $msg;
    header("Location: add.php");
    return;
  }
    
    
         // validate position
        $msg = validatePos();
        if(is_string($msg))
        {
          $_SESSION['error'] = $msg;
          header("Location: add.php");
          return;
        }

        $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
      
      $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
      );
  
$profile_id = $pdo->lastInsertId();
// insert the position entries
$rank = 1;

for($i=1; $i<=9; $i++) {
  if ( ! isset($_POST['year'.$i]) ) continue;
  if ( ! isset($_POST['desc'.$i]) ) continue;

  $year = $_POST['year'.$i];
  $desc = $_POST['desc'.$i];

  $stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :desc)');

$stmt->execute(array(
  ':pid' => $profile_id,
  ':rank' => $rank,
  ':year' => $year,
  ':desc' => $desc)
);
$rank++;
}




    $_SESSION['success'] = "Record added";
    header("Location: index.php");
    return;
   // $_POST['mileage'] = $_POST['year'] = $_POST['make'] = '';

    


 }
 
//  else{
//     $_SESSION['error'] = "All fields are required";
//    // header("Location: add.php");
//    //  return;
// }

?>



<!DOCTYPE html>
<html>
<head>
<title>Elvis Aisosa Igiebor 1b2a9cbe</title>
<?php 
require_once "bootstrap.php";

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container">
   
<h1>Adding Profile for <?php if(isset($_SESSION['name'])){echo $_SESSION['name']; } ?></h1>
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
<span class="text-bg-danger" id="error"></span>
<form method="POST">
<div class="container">
  <div class="row">
    <div class="col-md-8">
    <div class="col-md-8">
    <div class="mb-3">
    <label for="make">Firt Name</label>
    <input  type="text" class="form-control" name="first_name" id="first_name">
    </div>
    <div class="mb-3">
    <label for="make">Last Name</label>
    <input  type="text" class="form-control" name="last_name" id="last_name">
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Email</label>
      <input type="email" name ="email" class="form-control" id="email" placeholder="name@example.com">
    </div>
    <div class="mb-3">
      <label for="headline" class="form-label">Headline</label>
      <input type="text" class="form-control" name="headline" id="headline" placeholder="Software Engineer">
    </div>
    <div class="mb-3">
    <label for="summary" class="form-label">Summary</label>
    <textarea class="form-control" id="summary" name="summary" rows="3"></textarea>
    </div>
    <br>
    <div class="mb-3">
    <label for="summary" class="form-label">Position :</label>
    <input class="" type="button" id="addPos" name="" value="+" rows="3">
    </div>
    <div id="position_fields">

    </div>

    <br><br>
    <input type="submit" onclick=" return doValidate();" class = "btn btn-success mb-3" value="Add">
    <input type="submit" class = "btn btn-primary" name="logout" value="Cancel">
    </div>
    
  </div>
  
</div>


</form>
<!-- <br>
<button><a href="view.php">View Autos</a></button> -->

<script>
    function doValidate(){
        console.log('Validating ...');
         try{
  console.log('Validating ...');
  
  first_name = document.getElementById('first_name').value;
  last_name = document.getElementById('last_name').value;
  em = document.getElementById('email').value;
  hd = document.getElementById('headline').value;
  sm = document.getElementById('summary').value;
  if(first_name == null || first_name == "" || last_name == null || last_name == "" || em == null || em == "" || hd == null || hd == "" || sm == null || sm == "")
  {
    document.getElementById('error').innerHTML = 'All fields are required';
return false;
  }
  console.log('worked');
   return true;
        }catch(e)
         {
             console.log(e);
             return false;
         }
         return false;
    }

    countPos = 0;
  
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




    });
</script>
</body>

