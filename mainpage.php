<?php
//required to use mysql connection from log in info
session_start();

$user = $_SESSION['username'];
$password = $_SESSION['password'];
$db = $_SESSION['database'];
$conn = new mysqli("localhost", $user, $password, $db);
if(isset($_POST['delete'])){
    header('Location: delete.php');
}
if(isset($_POST['add'])){
    header('Location: add.php');
}
if(isset($_POST['logout'])){
	session_destroy();
	header('Location: login.php');
	die();
}
?>
<div style = "position:static;">
<form method="POST">
    <legend>Database Access</legend>
    <button type="submit" name="course">COURSE</button>
    <button type="submit" name="name">NAME</button>
    <button type="submit" name="final">FINAL</button>
    <button type="submit" name="delete">DELETE</button>
    <button type="submit" name="add">ADD</button>
	<button type="submit" name="logout">LOG OUT</button>
</form>
</div>
<?php
echo "<div style='position:static;'>";

if(isset($_POST['course'])) {

    $query = "SELECT * FROM CourseTable";
	
    $result = $conn->query($query);
    echo "<table>";
    echo "<tr><th>StudentID</th><th>Course</th><th>Test1</th><th>Test2</th><th>Test3</th><th>Finalexam</th></tr>";
    $num_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
		
        echo "<tr><form action='edit.php' method='get'>";
        
        echo "<td>" . $row['StudentID'] . "</td>";
        echo "<td>" . $row['Course'] . "</td>";
        echo "<td>" . $row['Test1'] . "</td>";
        echo "<td>" . $row['Test2'] . "</td>";
        echo "<td>" . $row['Test3'] . "</td>";
        echo "<td>" . $row['Finalexam'] . "</td>";
		echo "<td><input type='hidden' name='id' value='".$row['StudentID']."'/><input type='hidden' name='course' value='".$row['Course']."'/><input type='submit' value='Edit'/></td>";
		echo "</form></tr>";
    }
    echo "</table>";
}

if(isset($_POST['name'])) {
    $query = "SELECT * FROM NameTable";
    $result = mysqli_query($conn, $query);
    echo "<table>";
    echo "<tr><th>StudentID</th><th>Name</th><th>";
    $num_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($i % 2 == 0) {
            echo "<tr>";
        }
        echo "<td>" . $row['StudentID'] . "</td>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
if(isset($_POST['final'])){
    $query="SELECT name.StudentID, course.Course, ROUND(0.20*(course.Test1+course.Test2 +course.Test3)+0.40*course.FinalExam,1)
    AS FinalGrade FROM NameTable name JOIN CourseTable course ON Course.StudentID = name.StudentID;";
    $result = mysqli_query($conn, $query);
    echo "<table>";
    echo "<tr><th>StudentID</th><th>Course</th><th>FinalGrade</th><th>";
    $num_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($i % 3 == 0) {
            echo "<tr>";
        }
        echo "<td>" . $row['StudentID'] . "</td>";
        echo "<td>" . $row['Course'] . "</td>";
        echo "<td>" . $row['FinalGrade'] . "</td>";
        echo"</tr>";
    }
    echo "</table>";
}

echo "</div>";
?>