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
if(isset($_POST['edit'])){
	$test1 = $_POST['test1'];
	$test2 = $_POST['test2'];
	$test3 = $_POST['test3'];
	$final = $_POST['final'];
	$ps->execute();
	header("Location:mainpage.php");
}


echo "<form method='post'>";
echo "<label for='test1'>Test 1:</label>";
echo "<input type='text' name='test1' id='test1' value='".$row['Test1']."'><br>";
echo "<label for='test2'>Test 2:</label>";
echo "<input type='text' name='test2' id='test2' value='".$row['Test2']."'/><br>";
echo "<label for='test3'>Test 3:</label>";
echo "<input type='text' name='test3' id='test3' value='".$row['Test3']."'/><br>";
echo "<label for='final'>Final Exam:</label>";
echo "<input type='text' name='final' id='final' value='".$row['Finalexam']."'/><br>";
echo "<input type='submit' name='edit' value='Modify'/>";
echo "</form>";
?>