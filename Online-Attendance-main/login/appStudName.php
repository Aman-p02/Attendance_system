<?php
require_once 'supabaseConn.php';

$rollNo = $_POST['rollNo'];

try {
    $stmt = $pdo->prepare("SELECT \"studentName\" FROM \"allStudent\" WHERE \"rollno\" = ?");
    $stmt->execute([$rollNo]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo $row['studentName'];
    } else {
        echo "Student not found";
    }
} catch (PDOException $e) {
    echo "Student not found";
}
?>


