<?php
require "login.php";
$array=getParameterValues();
$user=$array[0];
$pass=$array[1];
$conn=mysqli_connect('localhost', $user, $pass, 'cp476');
if(isset($_POST['add'])){
    $StudentID = $_POST['StudentID'];
    $Name = $_POST['Name'];
    $Course = $_POST['Course'];
    $One = $_POST['Test1'];
    $Two = $_POST['Test2'];
    $Three = $_POST['Test3'];
    $Final = $_POST['FinalExam'];
    if (empty($_POST['StudentID']) or empty($_POST['Name']) or
        empty($_POST['Course']) or empty($_POST['Test1']) or
            empty($_POST['Test2']) or empty($_POST['Test3']) or empty($_POST['FinalExam']) ) {
        $query="SELECT * FROM name WHERE StudentID='$StudentID'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) { //check if student already exists
            $query="SELECT * FROM name WHERE StudentID='$StudentID' AND Name='$Name'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) >! 0) {
                echo "StudentID and Name do not match";
            }else{
                $query="INSERT INTO Course (StudentID, Course, Test1,Test2,Test3)
    VALUES ('$StudentID', '$Course', '$One','$Two','$Three','$Final');";
                $result = mysqli_query($conn, $query);
                if ($result){
                    echo "Addition successful";
                }else{
                    echo "Addition unsuccessful";
                }

            }
        }else{ //Create new student in both tables
            $query="INSERT INTO Course (StudentID, Course, Test1,Test2,Test3)
    VALUES ('$StudentID', '$Course', '$One','$Two','$Three','$Final');";
            $result = mysqli_query($conn, $query);
            $query1="INSERT INTO Name (StudentID, name) VALUES ('$StudentID', '$Name');";
            $result1=mysqli_query($conn, $query1);
            if ($result and $result1){
                echo "Addition successful in both tables";
            }else{
                echo "Addition unsuccessful in one or more tables";
            }
        }

    }else{
        echo "Please fill all information";
    }

}
if(isset($_POST['GoBack'])){
    header('Location: mainpage.php');
}
?>



<form method="POST">
    <label for="StudentID">StudentID:</label>
    <input type="text" name="StudentID" id="StudentID">
    <label for="Name">Name:</label>
    <input type="text" name="Name" id="Name">
    <label for="Course">Course:</label>
    <input type="text" name="Course" id="Course">
    <label for="Test1">Test1:</label>
    <input type="text" name="Test1" id="Test1">
    <label for="Test2">Test2:</label>
    <input type="text" name="Test2" id="Test2">
    <label for="Test3">Test3:</label>
    <input type="text" name="Test3" id="Test3">
    <label for="FinalExam">FinalExam:</label>
    <input type="text" name="FinalExam" id="FinalExam">
    <button type="submit" name="add">ADD</button>
    <button class="backbutton">GoBack</button>

    <style>
        .backbutton {
            position: fixed;
            top: 0;
            left: 0;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
        }
    </style>
</form>
