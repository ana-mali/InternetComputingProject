<style type="text/css">

legend {
    font-size:  1.4em;
    font-weight:  bold;
    background:#ff8b38;
    border:1px solid #000;
}
* html legend{  
    margin-top:-10px;
    position:relative;
}
</style>
<div style = "position:static;">
<form method="POST">
    <legend>Modify/Delete Student Grade</legend>	
</form>
</div>

<?php
session_start();
$user = $_SESSION['username'];
$password = $_SESSION['password'];
$db = $_SESSION['database'];
$conn = new mysqli("localhost", $user, $password, $db);
$id=mysqli_real_escape_string($conn, $_GET['id']);
$course=mysqli_real_escape_string($conn, $_GET['course']);
$query = "SELECT * FROM CourseTable WHERE StudentID=$id AND Course='$course'";
$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);
$ps = $conn->prepare("UPDATE CourseTable SET Test1=?, Test2=?, Test3=?, Finalexam=? WHERE StudentID=$id AND Course='$course'");
$ps->bind_param('dddd', $test1, $test2, $test3, $final);

# If modify button pressed
if(isset($_POST['edit'])){
	$test1 = $_POST['test1'];
	$test2 = $_POST['test2'];
	$test3 = $_POST['test3'];
	$final = $_POST['final'];
	$ps->execute();
	header("Location:mainpage.php");
}

# If delete button pressed
if(isset($_POST['delete'])){
	$dquery= "DELETE FROM CourseTable WHERE StudentID=$id AND Course='$course'";
	$conn->query($dquery);
	header("Location:mainpage.php");
}
echo "<form method='POST'>";
echo "<label for='test1'>Test 1:</label><br>";
echo "<input type='number' step='0.1' name='test1' id='test1' value='".$row['Test1']."' min='0' max='100'/><br><br>";
echo "<label for='test2'>Test 2:</label><br>";
echo "<input type='number' step='0.1' name='test2' id='test2' value='".$row['Test2']."' min='0' max='100'/><br><br>";
echo "<label for='test3'>Test 3:</label><br>";
echo "<input type='number' step='0.1' name='test3' id='test3' value='".$row['Test3']."' min='0' max='100'/><br><br>";
echo "<label for='final'>Final Exam:</label><br>";
echo "<input type='number' step='0.1' name='final' id='final' value='".$row['Finalexam']."' min='0' max='100'/><br><br>";
echo "<input type='submit' name='edit' value='Modify'/>";
echo "<input type='submit' name='delete' value='Delete'/>";
echo "</form>";
?>
