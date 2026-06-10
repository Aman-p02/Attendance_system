<?php
require_once '../supabaseConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollno = $_POST['rollno'];
    $studName = $_POST['studentName'];
    $passwords = $_POST['password'];

    try {
        $stmt = $pdo->prepare("INSERT INTO \"allStudent\" (\"rollno\", \"studentName\", \"passwords\") VALUES (?, ?, ?)");
        $stmt->execute([$rollno, $studName, $passwords]);
        echo 'success';
    } catch (PDOException $e) {
        echo 'error';
    }
}
?>
