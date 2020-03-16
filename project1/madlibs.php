<!DOCTYPE html>
<html>
<head>
    <title>Mad Lib</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <h1>Mad Libs</h1>
    <h2>Fill in the noun, verb adjective, and adverb: </h2>
    <p id="story">"-noun-'s always -verb- -adverb-. No wonder they are so -adjective-!"</p>
    
<?php
    
    // If submit is pressed, try to execute... 
    if (isset($_POST['submit']))
    {
        
        
        $noun = $_POST['noun'];
        $verb = $_POST['verb'];
        $adjective = $_POST['adjective'];
        $adverb = $_POST['adverb'];
        $output_lib = false;
        
        // Validation if anything in form is empty
        if (empty($noun) || empty($verb) || empty($adjective) || empty($adverb))
        {
            echo 'Please finish the story to submit!';
            $output_lib = true;
        }
    }
    else
    {
        $output_lib = true;
    }
    // If the form is not empty... 
    if ((!empty($noun)) && (!empty($verb)) && (!empty($adjective)) && (!empty($adverb)))
    {
        // Database connection to insert data into database
        $dbc = mysqli_connect('localhost', 'root', '', 'mad_lib')
                or die('Error connecting to MySQL server.');
        $query = "INSERT INTO UserLib(noun, verb, adjective, adverb)" .
                "VALUES('$noun', '$verb', '$adjective', '$adverb')";
        $result = mysqli_query($dbc, $query)
                or die('Error connecting to MySQL server.');
        mysqli_close($dbc);
        $output_lib = true;
    }
    // The form to be filled by user
    if ($output_lib)
    {
?>  
        <form id="form" method="post" action="madlibs.php">
            <label for="noun">Enter a noun: </label><br />
            <input type="text" name="noun" value="<?php echo $noun; ?>" size="20"/><br />
            <label for="verb">Enter a verb: </label><br />
            <input type="text" name="verb" value="<?php echo $verb; ?>" size="20"/><br />
            <label for="adverb">Enter a adverb: </label><br />
            <input type="text" name="adverb" value="<?php echo $adverb; ?>" size="20"/><br />
            <label for="adjective">Enter a adjective: </label><br />
            <input type="text" name="adjective" value="<?php echo $adjective; ?>" size="20"/><br />
            <input type="submit" name="submit" value="Submit" />
        </form>
<?php
    }
    // Display the user input 
    if ((!empty($noun)) && (!empty($verb)) && (!empty($adjective)) && (!empty($adverb)))
    {
        // Database connection to recieve table information to be disiplayed
        $dbc = mysqli_connect('localhost', 'root', '', 'mad_lib')
                or die('Error connecting to MySQL server.');
        $query2 = "SELECT * FROM UserLib ORDER BY id DESC";
        $result2 = mysqli_query($dbc, $query2)
                or die('Error connecting to MySQL server.');
        mysqli_close($dbc);
        while ($row = mysqli_fetch_array($result2))
            {
                echo "<p id=\"lib\">" . $row['noun'] . "s always " . $row['verb'] 
                        . " " . $row['adverb'] . ". No wonder they are so " 
                        . $row['adjective'] . "!<br /></p>"; 
            }
    }
        
?>
    
</body>
</html> 