<?php
require mainpage.php;
if(isset($_POST['delete'])){
    $StudentID = $_POST['StudentID'];
    $Course = $_POST['Course'];
    $query="DELETE FROM Course WHERE StudentID="+$StudentID +"and Course="+$Course+";";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Deletion successful";
    }
    else{
        echo "Deletion was unsuccessful please check if input exists";
    }
}


?>

<form method="POST">
    <label for="StudentID">StudentID:</label>
    <input type="text" name="StudentID" id="StudentID">
    <label for="Course">Course:</label>
    <input type="text" name="Course" id="Course">
    <button type="submit" name="delete">DELETE</button>
</form>