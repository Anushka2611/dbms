<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="date"],
        input[type="submit"],
        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="date"] {
            flex: 1;
        }
        input[type="submit"],
        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
        ul {
            padding: 0;
            list-style-type: none;
        }
        li {
            background-color: #f5f5f5;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-info {
            display: flex;
            align-items: center;
            flex: 1;
        }
        .task-name {
            margin-left: 20px; 
            font-size: 18px;
            font-weight: bold;
        }
        .task-date {
            margin-left: auto;
            margin-right: 20px; 
            color: #666;
        }
        .task-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            text-transform: uppercase;
        }
        .bullet {
            margin-right: 10px;
            font-size: 20px;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>To-Do List</h1>

    
    <form action="add_task.php" method="POST">
        <input type="text" name="task_name" placeholder="Add a new task" required>
        <input type="date" name="due_date" id="due_date" required>
        <input type="submit" value="Add Task">
    </form>

    
    <ul>
        <?php
        include 'db_connection.php';

        
        $sql = "SELECT id, task_name, due_date, status FROM tasks ORDER BY id ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $counter = 1; 
            while ($row = $result->fetch_assoc()) {
                echo "<li>
                    <span class='bullet'>{$counter}.</span>
                    <div class='task-info'>
                        <span class='task-name'>{$row['task_name']}</span>
                        <span class='task-date'>Due: {$row['due_date']}</span>
                        <span class='task-status'>{$row['status']}</span>
                    </div>
                    <div class='actions'>
                        <a href='delete_task.php?id={$row['id']}' style='text-decoration: none; color: #e74c3c;'>Delete</a>
                        <button onclick='toggleUpdateFields({$row['id']})' style='background-color: #3498db;'>Edit</button>
                        <form action='update_task.php' method='POST' class='update-fields' id='form_{$row['id']}' style='display:none;'>
                            <input type='hidden' name='task_id' value='{$row['id']}'>
                            <input type='hidden' name='current_task_name' value='{$row['task_name']}'>
                            <input type='text' name='new_task_name' value='{$row['task_name']}' required>
                            <input type='date' name='new_due_date' value='{$row['due_date']}' required>
                            <select name='new_status'>
                                <option value='Pending' " . ($row['status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                <option value='Completed' " . ($row['status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                            </select>
                            <input type='submit' name='update_task' value='Save'>
                        </form>
                    </div>
                </li>";
                $counter++; 
            }
        } else {
            echo "<li>No tasks found</li>";
        }

        $conn->close();
        ?>
    </ul>
</div>

<script>
    function toggleUpdateFields(taskId) {
        var form = document.getElementById('form_' + taskId);
        if (form.style.display === 'none') {
            form.style.display = 'block';
            setMinDate(); 
        } else {
            form.style.display = 'none';
        }
    }

    
    function setMinDate() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('due_date').min = today;
        document.querySelectorAll('.update-fields input[type="date"]').forEach(function(input) {
            input.min = today;
        });
    }

    
    window.onload = setMinDate;
</script>

</body>
</html>