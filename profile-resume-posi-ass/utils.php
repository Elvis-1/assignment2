<?php
function validatePos() {
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_POST['year'.$i]) ) continue;
      if ( ! isset($_POST['desc'.$i]) ) continue;
  
      $year = $_POST['year'.$i];
      $desc = $_POST['desc'.$i];
  
      if ( strlen($year) == 0 || strlen($desc) == 0 ) {
        return "All fields are required";
      }
  
      if ( ! is_numeric($year) ) {
        return "Position year must be numeric";
      }
    }

    // you forgot to check if the user is the owner of the profile
    return true;
  }

  function validateProfile()
  {
    if(strlen($_POST['first_name'])<1 )
    {
        return 'All fields are required'; 
     
   
    } 
    if(strlen($_POST['last_name'])<1 )
    {
      return 'All fields are required'; 

        
    }
     if(strlen($_POST['email'])<1 )
    {
       return 'All fields are required'; 
      
      
        
    } if(strlen($_POST['headline'])<1 )
    {
      return 'All fields are required'; 
   
        
    }
     if(strlen($_POST['summary'])<1 ){
      return 'All fields are required'; 

    } 
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        return "Email must have an at-sign (@)";
 
       
    }

    return true;
  }