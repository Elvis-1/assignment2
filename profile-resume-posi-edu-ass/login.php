<?php // Do not put any HTML above this line


session_start();

require_once "pdo.php";
if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123



// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        error_log("Login fail ".$_POST['email']);
        header("Location: login.php");
        return;
    } 
    
    else {
        $check = $_POST['email'];
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            error_log("Login fail ".$_POST['email']);
            header("Location: login.php");
            return;
           
        }
        
        else{

            $check = hash('md5', $salt.$_POST['pass']);

            $stmt = $pdo->prepare('SELECT user_id, name FROM users
       
                WHERE email = :em AND password = :pw');
       
            $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
       
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ( $row !== false ) {

                $_SESSION['name'] = $row['name'];
       
                $_SESSION['user_id'] = $row['user_id'];
       
                // Redirect the browser to index.php
                header("Location: index.php");
       
                return;
            }else{
                $_SESSION['error'] = 'Invalid email address';
                header("Location: login.php");
       
                return;
            }
 
        }

    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Elvis Aisosa Igiebor b4f9264d</title>

</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error']) ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.$_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="nam">Email</label>
<input type="text" name="email" id="nam"><br/>
<span id></span>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit"  onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>

</div>

<script>
    function doValidate() {
         console.log('Validating...');
         try {
             pw = document.getElementById('id_1723').value;
             em = document.getElementById('nam').value;
             var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
             console.log("Validating pw="+pw);
             if (pw == null || pw == "") {
                 alert("Both fields must be filled out");
                 return false;
             } 
             if(!em.match(validRegex))
             {
                alert('Invalid email address');
                return false;
             }

            //  if (em == null || em == "") {
            //      alert("Both fields must be filled out");
            //      return false;
            //  }
             return true;
         } catch(e) {
             return false;
         }
         return false;
     }
</script>
</body>
