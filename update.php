<?php
require "login.php";
$array=getParameterValues();
$user=$array[0];
$pass=$array[1];
$conn=mysqli_connect('localhost', $user, $pass, 'cp476');
if(isset($_POST['sbutton'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT * FROM Course WHERE StudentID LIKE '%$search_term%' OR Course LIKE '%$search_term%'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['StudentID'] . "</td>";
            echo "<td>" . $row['Course'] . "</td>";
            echo "<td>" . $row['Test1'] . "</td>";
            echo "<td>" . $row['Test2'] . "</td>";
            echo "<td>" . $row['Test3'] . "</td>";
            echo "<td>" . $row['FinalExam'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo '<form method="POST" action="update_row.php">';
        echo '<input type="hidden" name="id" value="' . $row['StudentID'] . '">';
        echo '<input type="submit" name="update" value="Update">';
        echo '</form>';
    }else {
        echo "No results found";
    }

// Code for handling the update button
    if (isset($_POST['update'])) {
        foreach ($_POST['update'] as $index => $id) {
            // Get the updated values for this row
            $ID = mysqli_real_escape_string($conn, $_POST['StudentID'][$index]);
            $course = mysqli_real_escape_string($conn, $_POST['Course'][$index]);
            $One = mysqli_real_escape_string($conn, $_POST['Test1'][$index]);
            $Two = mysqli_real_escape_string($conn, $_POST['Test2'][$index]);
            $Three = mysqli_real_escape_string($conn, $_POST['Test3'][$index]);
            $Final = mysqli_real_escape_string($conn, $_POST['FinalExam'][$index]);
            // Update the row in the database
            $query = "UPDATE Course SET course='$course', Test1='$One', Test2='$Two', Test3='$Three', FinalExam='$Final' WHERE StudentID='$ID'";
            $result = mysqli_query($conn, $query);
            // Check if the update was successful
        if ($result) {
                echo "Row updated successfully!";
        } else {
            echo "Error updating row: " . mysqli_error($conn);
        }
        }
    }
}
?>

<script>
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = btn.dataset.id;
            const name = btn.parentElement.parentElement.querySelector('td:nth-child(1)').innerText;
            const description = btn.parentElement.parentElement.querySelector('td:nth-child(2)').innerText;

            document.querySelector('#edit-form input[name="id"]').value = id;
            document.querySelector('#edit-form input[name="name"]').value = name;
            document.querySelector('#edit-form input[name="description"]').value = description;

            document.querySelector('#edit-form').style.display = 'block';
        });
    });
</script>
<form method="POST">
    <label for="Search">Search by StudentID or Course Code:</label>
    <input type="text" name="search" id="search">
    <button type="submit" name="sbutton">SEARCH</button>
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
<form id="edit-form" method="post" style="display: none;">
    <input type="hidden" name="id">
    <label>Course:</label>
    <input type="text" name="course">
    <label>Test1:</label>
    <input type="text" name="Test1">
    <label>Test2:</label>
    <input type="text" name="Test2">
    <label>Test3:</label>
    <input type="text" name="Test3">
    <label>FinalExam:</label>
    <input type="text" name="FinalExam">
    <button type="submit">Save</button>
</form>