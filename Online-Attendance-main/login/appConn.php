<?php
require_once 'supabaseConn.php';

// Get roll no and password from the Android app (or other client)
$rollNo = $_POST['rollNo'];
$password = $_POST['password'];

try {
    $stmt = $pdo->prepare("SELECT * FROM \"allStudent\" WHERE \"rollno\" = ? AND \"passwords\" = ?");
    $stmt->execute([$rollNo, $password]);

    if ($stmt->rowCount() > 0) {
        // Login successful
        echo "success";
    } else {
        // Login failed
        echo "failure";
    }
} catch (PDOException $e) {
    echo "failure";
}
?>
