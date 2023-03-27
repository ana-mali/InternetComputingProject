<?php
//required to use mysql connection from log in info
require "login.php";

if(isset($_POST['course'])) {
    $query = "SELECT * FROM course";
    $result = mysqli_query($conn, $query);
    echo "<table>";
    echo "<tr><th>StudentID</th><th>CourseCode</th><th>Test1</th><th>Test2</th><th>Test3</th><th>FinalExam</th></tr>";
    $num_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($i % 6 == 0) {
            echo "<tr>";
        }
        echo "<td>" . $row['StudentID'] . "</td>";
        echo "<td>" . $row['CourseCode'] . "</td>";
        echo "<td>" . $row['Test1'] . "</td>";
        echo "<td>" . $row['Test2'] . "</td>";
        echo "<td>" . $row['Test3'] . "</td>";
        echo "<td>" . $row['FinalExam'] . "</td>";
    }
    echo "</table>";
}

if(isset($_POST['name'])) {
    $query = "SELECT * FROM name";
    $result = mysqli_query($conn, $query);
    echo "<table>";
    echo "<tr><th>StudentID</th><th>name</th><th>";
    $num_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($i % 2 == 0) {
            echo "<tr>";
        }
        echo "<td>" . $row['StudentID'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
    }
    echo "</table>";
}
if(isset($_POST['final'])){
    $query="SELECT name.StudentID, course.Course, ROUND(0.20*(course.Test1+course.Test2 +course.Test3)+0.40*course.FinalExam,1)
    AS FinalGrade FROM NameTable name JOIN CourseTable course ON Course.StudentID = name.StudentID;";
    $result = mysqli_query($conn, $query);
    echo "<table>";
    echo "<tr><th>StudentID</th><th>course</th><th>final</th><th>";
    $num_rows = mysqli_num_rows($result);
    for ($i = 0; $i < $num_rows; $i++) {
        $row = mysqli_fetch_assoc($result);
        if ($i % 3 == 0) {
            echo "<tr>";
        }
        echo "<td>" . $row['StudentID'] . "</td>";
        echo "<td>" . $row['course'] . "</td>";
        echo "<td>" . $row['final'] . "</td>";
    }
    echo "</table>";
}

?>
<form method="POST">
    <button type="submit" name="course">COURSE</button>
    <button type="submit" name="name">NAME</button>
    <button type="submit" name="final">FINAL</button>


</form>
