<?php
session_start();
require_once '../supabaseConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // This is the rollno
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM \"allStudent\" WHERE \"rollno\" = ? AND \"passwords\" = ?");
        $stmt->execute([$username, $password]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $studentName = $row['studentName'];
            $_SESSION['username'] = $username;
            echo 'success';
        } else {
            echo 'error';
        }
    } catch (PDOException $e) {
        echo 'error';
    }
}
?>
