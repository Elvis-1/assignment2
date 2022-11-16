<?php


    /*  EDUCATION FUNCTIONS STARTS  */

  function validateEducation()
  {
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_POST['edu_year'.$i]) ) continue;
      if ( ! isset($_POST['edu_school'.$i]) ) continue;
    
      $year = $_POST['edu_year'.$i];
      $sch = $_POST['edu_school'.$i];
  
      if ( strlen($year) == 0 || strlen($sch) == 0 ) {
        return "All fields are required";
      }
  
      if ( ! is_numeric($year) ) {
        return "Education year must be numeric";
      }
    }

    // you forgot to check if the user is the owner of the profile
    return true;
  }

  function insertEducation($profile_id, $pdo)
  {
    $rank =1;
print('i was called ');
return;
for($i=0; $i<=9; $i++ )
{
  if ( ! isset($_POST['edu_year'.$i]) ) continue;
  if ( ! isset($_POST['edu_school'.$i]) ) continue;

 echo 'year is ' . $year = $_POST['edu_year'.$i];
 echo 'school name is '. $sch = $_POST['edu_school'.$i];
 return;
  // look up the school if its there
  $institution_id = false;
  $stmt = $pdo->prepare("SELECT institution_id FROM institution WHERE name = :name");
  $stmt->execute(array(':name'=>$sch));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row !== false)
  {
    echo 'this is id since it exists '. $institution_id = $row['institution_id'];
  }

  // insert school if it doesn't exist yet
  if($institution_id === false)
  {
    $stmt = $pdo->prepare("INSERT INTO institution(name) VALUES(:name)");
    $stmt->execute(array(':name'=>$school));
    echo 'this is id '. $institution_id = $pdo->lastInsertId();
  }

  // insert into eduction
 $stmt = $pdo->prepare("INSERT INTO education(profile_id, rank, year, institution_id) VALUES(:pd,:rk,:yr, :id)");
  $stmt->execute(array(
    ':pd'=>$profile_id,
    ':rk'=>$rank,
    ':yr'=>$year,
    ':id'=>$institution_id 
  ));

  $rank++;

}
  }

  function loadEducation($profile_id,$pdo){
    $stmt = $pdo->prepare("SELECT year, name FROM education JOIN institution ON education.institution_id = institution.institution_id WHERE profile_id = :pi ORDER BY rank");
    $stmt->execute(array(':pi'=> $profile_id));
    $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $educations;
  }




     /* EDUCATION FUNCTION ENDS   */

  /*  PROFILE FUNCTIONS STARTS  */

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

  function insertProfile($pdo,$user_id)
  {
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

return $profile_id;
  }

    /* PROFILE FUNCTION ENDS   */

  /*  POSITION FUNCTIONS STARTS  */

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



  function insertPosition($pdo, $profile_id){
    $rank = 1;
for($i=1; $i<=9; $i++) {
  if ( ! isset($_POST['year'.$i]) ) continue;
  if ( ! isset($_POST['desc'.$i]) ) continue;

  $year = $_POST['year'.$i];
  $desc = $_POST['desc'.$i];
  $stmt = $pdo->prepare('INSERT INTO Position
    (profile_id, rank, year, description)
    VALUES ( :pid, :rank, :year, :desc)');

  $stmt->execute(array(
  ':pid' =>$profile_id,
  ':rank' => $rank,
  ':year' => $year,
  ':desc' => $desc)
  );

  $rank++;

}
  }

  function loadPosition($pdo, $profile_id){
    $stmt = $pdo->prepare("SELECT * FROM position WHERE profile_id = :pi");
    $stmt->execute(array(':pi'=> $profile_id));
    $positions = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
      $positions[] = $row;
    }
    // $positions = $stmt->fetchAll(PDO::FETCH_ASSOC); // this works too
    return $positions;
  }

  /* POSITION FUNCTION ENDS   */
  

  