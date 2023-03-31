<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Check if the username and password are valid
    $database = 'cp476';
    $conn = new mysqli("localhost", $username, $password, $database);
    // Check if the connection was successful
	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;
	$_SESSION["database"] = $database;
	$_SESSION["connection"]=$conn;
	header('Location: mainpage.php');
}

    // Close the database connection
    //mysqli_close($conn);
?>

<style type="text/css">

legend {
    font-size:  1.4em;
    font-weight:  bold;
    background:#dcf500;
    border:1px solid #000;
}
* html legend{  
    margin-top:-10px;
    position:relative;
}
</style>

<form method="POST">
    <legend>Login Student Grade Database</legend><br>
    <label for="username">Username:</label><br>
    <input type="text" name="username" id="username">
    <br><br>
    <label for="password">Password:</label><br>
    <input type="password" name="password" id="password">
    <br><br>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <input type="submit" value="Log in">
</form>
