<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_task'])) {
    $task_id = $_POST['task_id'];
    $current_task_name = $_POST['current_task_name'];
    $new_task_name = $_POST['new_task_name'];
    $new_due_date = $_POST['new_due_date'];
    $new_status = $_POST['new_status'];

    $sql = "UPDATE tasks SET task_name = '$new_task_name', due_date = '$new_due_date', status = '$new_status' WHERE id = $task_id AND task_name = '$current_task_name'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating task: " . $conn->error;
    }
}
?>
