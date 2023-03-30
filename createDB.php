<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = mysqli_connect('localhost', $username, $password, 'cp476');

    // Check connection error
    if ($conn->connect_error) {
        die('Connection error: ' . $conn->connect_error);
    }


    $database_name = 'CP476';
    echo "The database '$database_name' exists, will begin inserting data";
    //name table
    $data = file_get_contents("NameFile.txt");
    $data_lines = explode("\n", $data);
    $records = array();
    $x = 0;
    foreach ($data_lines as $line) {
        $fields = explode(",", $line);
        if (count($fields) == 2) {
            $records[$x] = $fields;
            $x += 1;
        }
    }

    foreach ($records as $record) {
        $stmt = $conn->prepare("INSERT INTO nametable (StudentID, Name) VALUES (?, ?)");
        $stmt->bind_param("ss", $record[0], $record[1]);

        if (!$stmt->execute()) {
            echo "Record executed unsuccessfully";
        }

        $stmt->close();

    }
    echo "Done inserting nametable";

    $data = file_get_contents("CourseFile.txt");
    $data_lines = explode("\n", $data);
    $records1 = array();
    $x = 0;
    foreach ($data_lines as $line) {
        $fields = explode(",", $line);
        if (count($fields) == 6) {
            $records1[$x] = $fields;
            $x += 1;
        }
    }

    foreach ($records1 as $record) {
        $stmt = $conn->prepare("INSERT INTO coursetable (StudentID,Course,Test1,Test2,Test3,Finalexam) VALUES (?,?,?,?,?,?);");
        $stmt->bind_param("ssdddd", $record[0], $record[1],$record[2],$record[3],$record[4],$record[5]);

        if (!$stmt->execute()) {
            echo "Record executed unsuccessfully";
        }

    }
    echo "Done inserting coursetable";
}
    ?>


<form method="POST">
    <label for="username">username:</label>
    <input type="text" name="username" id="username">
    <br>
    <label for="password">password:</label>
    <input type="password" name="password" id="password">
    <br>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <input type="submit" value="Log in">
</form>
