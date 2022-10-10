<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELVIS AISOSA IGIEBOR</title>
</head>
<body>
 <h1>Igiebor Elvis MD5 Cracker</h1>
 
 <p>
     This application takes md5 hash of a four digit pin and check all possible 10,000 digit pins to determine the pin.
 </p>

 <pre>
Debug Output:
<?php
$goodtext = "Not found";
$totalchecks = 0;
// If there is no parameter, this code is all skipped
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    // This is our alphabet
    //$txt = "abcdefghijklmnopqrstuvwxyz"; 
    $txt = "0123456789";
    $show = 15;

    // My outer loop to go through the alphabet for the first position

    for($a=0; $a<strlen($txt); $a++)
    {
        $ch1 = $txt[$a]; // the first of four characters

        // my first inner loop

        for($b=0; $b<strlen($txt);$b++ )
        {
            $ch2 = $txt[$b]; // my second character
            // third inner loop

            for($c=0;$c<strlen($txt);$c++)
            {
                $ch3 = $txt[$c];
                
                // fourth loop
                for($d=0;$d<strlen($txt);$d++)
                {
                    $ch4 = $txt[$d];

                    // concatenete the four characters together
                    // to form the possible pre hash test

                    $try = $ch1.$ch2.$ch3.$ch4;
                    // run the hash to see if they match
                    $check = hash('md5', $try);
                    $totalchecks = $totalchecks + 1;
                    if($check == $md5)
                    {
                        $goodtext = $try;
                        break; // leave the inner loop
                    }

                    if($show > 0)
                    {
                        print "$check $try\n";
                        $show = $show - 1;
                    }
                    

                }
            }
        }
        
    }
    // Compute elapsed time
    $time_post = microtime(true);
    print "Elapsed time: ";
    print $time_post-$time_pre;
    print "\n";
}
?>
</pre>

<!-- Use the very short syntax and call htmlentities() -->
<p>Original Text: <?= htmlentities($goodtext); ?></p>
<p>Total checks : <?= $totalchecks ?></p>
<form>
<input type="text" name="md5" size="40" />
<input type="submit" value="Crack MD5"/>
</form>
<ul>
<li><a href="index.php">Reset</a></li>





</body>
</html>