<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $database = 'cp476'; //name of database

    // Check if the username and password are valid
    $conn = mysqli_connect('localhost', $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die('Could not connect to database: ' . mysqli_connect_error());
    } else {
        $_SESSION['authenticated'] = true;
        header('Location: mainpage.php');
        exit;
    }

    // Close the database connection
    mysqli_close($conn);
}
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
