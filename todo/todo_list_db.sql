-- Create the tasks table
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(255) NOT NULL,
    due_date DATE,
    status ENUM('Pending', 'Completed') DEFAULT 'Pending'
);
