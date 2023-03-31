<style type="text/css">

legend {
    font-size:  1.4em;
    font-weight:  bold;
    background:#40f749;
    border:1px solid #000;
}
* html legend{  
    margin-top:-10px;
    position:relative;
}
</style>
<div style = "position:static;">
<form method="POST">
    <legend>Add Student Grade</legend>	
</form>
</div>

<?php
session_start();
$user = $_SESSION['username'];
$pass = $_SESSION['password'];
$db = $_SESSION['database'];
$conn = new mysqli('localhost', $user, $pass, $db);
#Prepared Statements
$preparedstatement1 = $conn->prepare("INSERT INTO coursetable (StudentID,Course,Test1,Test2,Test3,Finalexam) VALUES (?,?,?,?,?,?)");
$preparedstatement1->bind_param('isdddd',$StudentID, $Course, $One,$Two,$Three,$Finalexam);

$preparedstatement2 = $conn->prepare("INSERT INTO nametable (StudentID,Name) VALUES (?,?)");
$preparedstatement2->bind_param('is',$StudentID, $Name);

$preparedstatement3 = $conn->prepare("INSERT INTO coursetable (StudentID,Course,Test1,Test2,Test3,Finalexam) VALUES (?,?,?,?,?,?)");
$preparedstatement3->bind_param('isdddd',$StudentID, $Course, $One,$Two,$Three,$Finalexam);



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

    }

    #Valid values entered run query
    else{
        
		$query="SELECT * FROM nametable WHERE StudentID='$StudentID'";
        $result = mysqli_query($conn, $query);
       
		if (mysqli_num_rows($result) > 0) { //check if student already exists
            $query="SELECT * FROM nametable WHERE StudentID='$StudentID' AND Name='$Name'";
            $result = mysqli_query($conn, $query);
            
			if (mysqli_num_rows($result) >! 0) {
                echo "StudentID and Name do not match";
            }
			
			else{
				$preparedstatement3->execute();
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
            if ($result){
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
if(isset($_POST['main'])){
	header('Location: mainpage.php');
}
?>




<style type="text/css">

label {
    margin-bottom: 20px;
}

input[type='number']{
    width: 170px;
}
</style>

<form method="POST">
	<button type="submit" name="main">Main Page</button><br><br>

    <label for="StudentID">StudentID:</label><br>
    <input type="text" name="StudentID" id="StudentID" placeholder="Enter StudentID" pattern="[0-9]{9}" title="Nine Digits"><br><br>

    <label for="Name">Name:</label><br>
    <input type="text" name="Name" id="Name" placeholder="Enter Full Name" pattern="[A-Z]{1}[a-z].{0,} [A-Z]{1}[a-z].{0,}" title="First and Last Name with Capitalization"><br><br>
    
    <label for="Course">Course:</label><br>
    <input type="text" name="Course" id="Course" placeholder="Enter Course ID" pattern="[A-Z]{2}[0-9]{3}" title="Two capital letters followed by three digits, Ex. CP220"><br><br>

    <label for="Test1">Test1:</label><br>
    <input type="number" step="0.1" name="Test1" id="Test1" placeholder="Enter Test 1 Value" min="0" max="100"><br><br>

    <label for="Test2">Test2:</label><br>
    <input type="number" step="0.1" name="Test2" id="Test2" placeholder="Enter Test 2 Value" min="0" max="100"><br><br>

    <label for="Test3">Test3:</label><br>
    <input type="number" step="0.1" name="Test3" id="Test3" placeholder="Enter Test 3 Value" min="0" max="100"><br><br>

    <label for="Finalexam">Final Exam:</label><br>
    <input type="number" step="0.1" name="Finalexam" id="Finalexam" placeholder="Enter Final Exam Value" min="0" max="100"><br><br>

    <button type="submit" name="add">ADD</button>

</form>
