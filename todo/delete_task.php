<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id = $task_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
