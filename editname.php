<style type="text/css">

legend {
    font-size:  1.4em;
    font-weight:  bold;
    background:#26e9ff;
    border:1px solid #000;
}
* html legend{  
    margin-top:-10px;
    position:relative;
}
</style>
<div style = "position:static;">
<form method="POST">
    <legend>Modify/Delete Student Name</legend>	
</form>
</div>

<?php
session_start();
$user = $_SESSION['username'];
$password = $_SESSION['password'];
$db = $_SESSION['database'];
$conn = new mysqli("localhost", $user, $password, $db);
$id=mysqli_real_escape_string($conn, $_GET['id']);
$name = mysqli_real_escape_string($conn, $_GET['name']);
$query = "SELECT name FROM Nametable WHERE StudentID =$id";
$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);
$ps = $conn->prepare("UPDATE Nametable SET name=? WHERE StudentID=$id");
$ps->bind_param('s', $name);
if(isset($_POST['edit'])){
	$name = $_POST['name'];
	$ps->execute();
	header("Location:mainpage.php");
}
if(isset($_POST['delete'])){
	$dquery= "DELETE FROM Nametable WHERE StudentID=$id AND name='$name'";
	$conn->query($dquery);
	header("Location:mainpage.php");
}
echo "<form method='post'>";
echo "<label for='name'>Name:</label><br>";
echo "<input type='text' name='name' id='name' value='".$row['name']."' pattern='[A-Z]{1}[a-z].{0,} [A-Z]{1}[a-z].{0,}' title='First and Last Name with Capitalization'><br><br>";
echo "<input type='submit' name='edit' value='Modify'/>";
echo "<input type='submit' name='delete' value='Delete'/>";
echo "</form>";
?>
