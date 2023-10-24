<?php
// session_start();

$dsn = "mysql:host=localhost;dbname=utslab_kelompok1";
$kunci = new PDO($dsn, "root", "");

function addTask(){
    global $kunci;

    $title = $_POST['title'];
    $description = $_POST['description'];
    $progress = $_POST['progress'];
    $done = $_POST['done'];

    $sql = "INSERT INTO tasks (title, description, progress, done)
            VALUES (?, ?, ?, ?)";

    $stmt = $kunci->prepare($sql);
    $data = [$title, $description, $progress, $done];
    $stmt->execute($data);

    header('Location: ../../uts-lab-main/frontend/homepage/menu.php');
}

function updateTask(){
    global $kunci;

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $progress = $_POST['progress'];
    $done = $_POST['done'];

    $sql = "UPDATE tasks SET title = ?, description = ?, progress = ?
    WHERE id = ?";

    $stmt = $kunci->prepare($sql);
    $data = [$title, $description, $progress, $id];
    $stmt->execute($data);

    header('Location: ../../uts-lab-main/frontend/homepage/menu.php');
}

function deleteTask(){
    global $kunci;

    $id = $_POST['id'];

    $sql = "DELETE FROM tasks WHERE id = ?";

    $stmt = $kunci->prepare($sql);
    $data = [$id];
    $stmt->execute($data);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Location: ../../uts-lab-main/frontend/homepage/menu.php');
}

function deleteSelectedTasks()
{
    global $kunci;

    if (isset($_POST['task_ids']) && is_array($_POST['task_ids'])) {
        $task_ids = $_POST['task_ids'];

        // Create placeholders for the IDs to prevent SQL injection
        $placeholders = implode(',', array_fill(0, count($task_ids), '?'));

        // Delete tasks by their IDs
        $sql = "DELETE FROM tasks WHERE id IN ($placeholders)";
        $stmt = $kunci->prepare($sql);
        $stmt->execute($task_ids);
    }

    header('Location: ../../uts-lab-main/frontend/homepage/menu.php');
}

if ($_POST['mode'] === 'delete') {
    deleteSelectedTasks();
}

if($_POST['mode'] == "add"){
    addTask();
}elseif($_POST['mode'] == "update"){
    updateTask();
}elseif($_POST['mode'] == "delete"){
    deleteTask();
}
    
?>