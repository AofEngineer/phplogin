<?php
require("Function.php");

if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.    
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

if ($stmt = $con->prepare('SELECT id, password ,activation_code FROM accounts WHERE username = ?')) {
	
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	
	$stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password,$activation_code);
        $stmt->fetch();
        if (password_verify($_POST['password'], $password)&& $activation_code == "activated") {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            echo 'Welcome ' . $_SESSION['name'] . '!';
            header('Location: home.php');
        } else {
            echo '<div class="login">
                    <p>Incorrect username and/or password!</p>
                  </div>
                  <button type="button" onClick="'."location.href='index.html'".'">Logout</button> 
            ';
        }
    } else {
        echo '<body><div class="login">
        <p>Incorrect username and/or password!</p>
      </div>
      <button type="button" onclick="location.href="index.php";">Logout</button> 
      </body>';
    }
	$stmt->close();
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>		
        <link rel="stylesheet" href="style.css" type="text/css">
	</head>
<html>