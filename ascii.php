<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IGIEBOR ELVIS PHP</title>
</head>
<body>
 <h1>Igiebor Elvis PHP</h1>   

 <?php 
 $statement = 'This is the ascii art of the first letter of my name';
 $ascii = '************
     *
     *
     * 
     * 
     * 
     * 
     * 
     * 
************'?>
 <?php echo $statement  ?>               
 <pre>

<?php echo $ascii ; ?>


 </pre>
 <pre>The SHA256 hash of IGIEBOR ELVIS is <?php  print hash('sha256', 'Elvis Igiebor');?></pre>
 <p><a href="fail.php">Click here to check the error setting</a></p>
 <p><a href="check.php">Click here for a trace back</a></p>
</body>
</html>