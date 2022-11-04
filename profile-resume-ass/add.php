<?php 

require_once "pdo.php";
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
   
    if(strlen($_POST['first_name'])<1 )
    {
        $_SESSION['error'] = 'All fields are required'; 
        header("Location: add.php");
        return;
   
    }else if(strlen($_POST['last_name'])<1 )
    {
        $_SESSION['error'] = 'All fields are required'; 
        header("Location: add.php");
        return;
        
    }else if(strlen($_POST['email'])<1 )
    {
        $_SESSION['error'] ='All fields are required'; 
        header("Location: add.php");
        return;
        
    }else if(strlen($_POST['headline'])<1 )
    {
        $_SESSION['error'] = 'All fields are required'; 
        header("Location: add.php");
        return;
        
    }else if(strlen($_POST['summary'])<1 ){
        $_SESSION['error'] = 'All fields are required'; 
        header("Location: add.php");
        return;
    } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['error'] = "Email must have an at-sign (@)";
       // error_log("Login fail ".$_POST['email']);
        header("Location: add.php");
        return;
       
    }
    
    else{
     

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
    $_SESSION['success'] = "Record added";
    header("Location: index.php");
    return;
   // $_POST['mileage'] = $_POST['year'] = $_POST['make'] = '';

    }


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
<title>Elvis Aisosa Igiebor bbf82110</title>
<?php 
require_once "bootstrap.php";

?>
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
</script>
</body>

