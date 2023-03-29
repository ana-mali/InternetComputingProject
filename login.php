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

<form method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username">
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <br>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <input type="submit" value="Log in">
</form>
