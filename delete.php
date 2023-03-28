<?php
require "login.php";
$array=getParameterValues();
$user=$array[0];
$pass=$array[1];
$conn=mysqli_connect('localhost', $user, $pass, 'cp476');
if(isset($_POST['delete'])){
    $StudentID = $_POST['StudentID'];
    $Course = $_POST['Course'];
    if ($StudentID=="ana" and $Course=='123'){
        echo 'youre good';
    }
    $query="DELETE FROM Course WHERE StudentID="+$StudentID +"and Course="+$Course+";";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Deletion successful";
    }
    else{
        echo "Deletion was unsuccessful, please check if input exists";
    }

    if(isset($_POST['GoBack'])){
        header('Location: mainpage.php');
    }
}

?>

<form method="POST">
    <p><br> <br> </p>

    <label for="StudentID">StudentID:</label>
    <input type="text" name="StudentID" id="StudentID">
    <label for="Course">Course:</label>
    <input type="text" name="Course" id="Course">
    <button type="submit" name="delete">DELETE</button>
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
