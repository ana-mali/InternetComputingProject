<?php
require "mainpage.php";
$user = $_SESSION['username'];
$pass = $_SESSION['password'];
$db = $_SESSION['database'];
$conn = new mysqli('localhost', $user, $pass, $db);
#Prepared Statements
$preparedstatement1 = $conn->prepare("INSERT INTO coursetable (StudentID,Course,Test1,Test2,Test3,Finalexam) VALUES (?,?,?,?,?,?)");
$preparedstatement1->bind_param('isdddd',$StudentID, $Course, $One,$Two,$Three,$Finalexam);
$preparedstatement2 = $conn->prepare("INSERT INTO nametable (StudentID,Name) VALUES (?,?)");
$preparedstatement2->bind_param('is',$StudentID, $Name);

#Adding Querys
if(isset($_POST['add'])){
	#Assigning values to variables
    $StudentID = $_POST['StudentID'];
    $Name = $_POST['Name'];
    $Course = $_POST['Course'];
    $One = $_POST['Test1'];
    $Two = $_POST['Test2'];
    $Three = $_POST['Test3'];
    $Finalexam = $_POST['Finalexam'];
	
	#Checking if boxes are empty
    if (empty($_POST['StudentID']) or empty($_POST['Name']) or
        empty($_POST['Course']) or empty($_POST['Test1']) or
            empty($_POST['Test2']) or empty($_POST['Test3']) or empty($_POST['Finalexam'])) {

		echo "Please fill all information";

    }else{
        
		$query="SELECT * FROM nametable WHERE StudentID='$StudentID'";
        $result = mysqli_query($conn, $query);
       
		if (mysqli_num_rows($result) > 0) { //check if student already exists
            $query="SELECT * FROM nametable WHERE StudentID='$StudentID' AND Name='$Name'";
            $result = mysqli_query($conn, $query);
            
			if (mysqli_num_rows($result) >! 0) {
                echo "StudentID and Name do not match";
            }
			
			else{
                #$PS->bind_param('isdddd',$StudentID, $Course, $One,$Two,$Three,$Final);
				$PS->execute();
                #$result = mysqli_query($conn, $query);
                if ($result){
                    echo "Addition successful";
                }else{
                    echo "Addition unsuccessful";
                }

            }
        }else{ //Create new student in both tables
            $preparedstatement1->execute();
            #$result = mysqli_query($conn, $query);
            $preparedstatement2->execute();
            #$result1=mysqli_query($conn, $query1);
            if ($result and $result1){
                echo "Addition successful in both tables";
            }else{
                echo "Addition unsuccessful in one or more tables";
            }
        }
    }
	
	#if(isset($_POST['course']||($_POST['name']||($_POST['final'])){
    #header('Location: mainpage.php');
	#}

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
    <label for="Finalexam">FinalExam:</label>
    <input type="text" name="Finalexam" id="Finalexam">
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
