<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index_style.css">
    <title>Web_project</title>
</head>
<body>

<?php

    if (!empty($_POST['username']) and !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $myfile = file("password.txt");
        $data = [];
        foreach ($myfile as $line) {
            $i=0;
            while ($i < strlen($line)-1) { 
                if ($i < strlen($line)-1) {
                    for ($k=1;$k<=5;$k++) {
                        if ($i < strlen($line)-1) {
                            switch ($k) {
                                case 1:
                                    $newval = ord($line[$i]) - 5;
                                    $line[$i] = chr($newval);
                                    break;
                                case 2:
                                    $newval = ord($line[$i]) - (-14);
                                    $line[$i] = chr($newval);
                                    break;
                                case 3:
                                    $newval = ord($line[$i]) - 31;
                                    $line[$i] = chr($newval);
                                    break;
                                case 4:
                                    $newval = ord($line[$i]) - (-9);
                                    $line[$i] = chr($newval);
                                    break;
                                case 5:
                                    $newval = ord($line[$i]) - 3;
                                    $line[$i] = chr($newval);
                                    break;
                            }
                            $i++;
                        }
                        else {
                            break;
                        }
                    }
                }
                else {
                    break;
                }
            }
            
            $record = explode("*", $line);
            $data[$record[0]] = trim($record[1]);
        }
        
        if (!array_key_exists($username, $data)) {
            echo '<script>alert("NINCS ILYEN FELHASZNÁLÓ!")</script>';
        }
        else {
            if ($data[$username] != $password) {
                echo '<script>alert("HIBÁS JELSZÓ!")</script>';
                echo '<script>setTimeout(function(){ window.location.replace("http://www.police.hu");; }, 3000)</script>';
            }
            else {

                $link = mysqli_connect("localhost", "root","") or die("nem sikerült kapcsolódni az adatbázishoz");
                mysqli_select_db($link,"adatok") or die("nem sikerült kiválasztani az adatbázist");
                $query = mysqli_query($link,"SELECT Titkos FROM tabla WHERE Username='". mysqli_real_escape_string($link, $username ) ."';");
                $row = mysqli_fetch_row($query);
                $szin = $row[0];
                
                switch ($szin) {
                    case "piros":
                        echo '<body style="background-color:red">';
                        break;
                    case "zold":
                        echo '<body style="background-color:green">';
                        break;
                    case "sarga":
                        echo '<body style="background-color:yellow">';
                        break;
                    case "kek":
                        echo '<body style="background-color:blue">';
                        break;
                    case "fekete":
                        echo '<body style="background-color:black">';
                        break;
                    case "feher":
                        echo '<body style="background-color:white">';
                        break;
                }
            }
            
        }

    }

?>

<form class="box" action="index.php" method="POST">
    <h1>Login</h1>
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="" value="Login">

</form>

</body>
</html>