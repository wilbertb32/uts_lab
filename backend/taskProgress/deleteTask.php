<?php

$dsn = "mysql:host=localhost;dbname=utslab_kelompok1";
$kunci = new PDO($dsn, "root", "");

if (isset($_POST['taskId'])) {
    
    $task_id = filter_var($_POST['taskId'], FILTER_VALIDATE_INT);
    if ($task_id !== false) {
        // Prepare a SQL statement to delete the task
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $kunci->prepare($sql);
        
        // Bind the task ID to the statement
        $stmt->bindParam(1, $task_id, PDO::PARAM_INT);
        
        // Execute the query to delete the task
        if ($stmt->execute()) {
            // Task was deleted successfully
            echo json_encode(["success" => true, "message" => "Task deleted successfully"]);
        } else {
            // Task deletion failed
            echo json_encode(["success" => false, "message" => "Failed to delete the task"]);
        }
    } else {
        // Invalid task ID
        echo json_encode(["success" => false, "message" => "Invalid task ID"]);
    }
} else {
    // Task ID not provided in the POST request
    // header();
}
