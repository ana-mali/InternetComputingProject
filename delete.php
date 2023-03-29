<?php
require 'mainpage.php';
$user = $_SESSION['username'];
$pass = $_SESSION['password'];
$db = $_SESSION['database'];
$conn = new mysqli('localhost', $user, $pass, $db);

$preparedstatement1 = $conn->prepare("DELETE FROM coursetable WHERE StudentID=? AND Course=?");
$preparedstatement1->bind_param('is',$StudentID, $Course);

$preparedstatement2 = $conn->prepare("DELETE FROM nametable WHERE StudentID=?");
$preparedstatement2->bind_param('is',$StudentID);

$preparedstatement3 = $conn->prepare("DELETE FROM nametable WHERE StudentID=?");
$preparedstatement3->bind_param('is',$StudentID);

#If delete button clicked
if(isset($_POST['delete'])){
    
	#Retrieve delete text boxes
	$StudentID = $_POST['StudentID'];
    $Course = $_POST['Course'];
	
	if (empty($_POST($Course)) {
		$preparedstatement2->execute();
		
	#Prepared statement
	$preparedstatement1->execute();
    #$query="DELETE FROM CourseTable WHERE StudentID="+$StudentID +"and Course="+$Course+";";
    #$result = mysqli_query($conn, $query);
    
	#Check if delete result is successful
	if ($result) {
        echo "Deletion successful";
    }
    else{
        echo "Deletion was unsuccessful, please check if input exists";
    }

	#If text box is empty
	if(isset($_POST['course'])){
        header('Location: mainpage.php');
		exit;
    }
	
}

#if(isset($_POST['course'])){
		#header('Location: mainpage.php');
		#exit;
	#}

?>

<form method="POST">
    <p><br> <br> </p>

    <label for="StudentID">StudentID:</label>
    <input type="text" name="StudentID" id="StudentID">
    <label for="Course">Course:</label>
    <input type="text" name="Course" id="Course">
    <button type="submit" name="delete">DELETE</button>
    <button class="backbutton">GoBack</button>
	<button type="submit" name="course">COURSE!</button>

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
