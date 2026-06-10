<?php
require_once '../supabaseConn.php';

// Secret code for faculty registration - only real teachers should know this
define('FACULTY_SECRET_CODE', '016');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Server-side secret code validation
    $secretCode = isset($_POST['secretCode']) ? trim($_POST['secretCode']) : '';
    if ($secretCode !== FACULTY_SECRET_CODE) {
        echo 'invalid_secret';
        exit;
    }

    $tableName = $_POST['username'];

    // Create a table named 'your_table'
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS \"$tableName\" (
        \"teacherName\" VARCHAR(1000) NOT NULL,
        \"teacherSub\" VARCHAR(1000) NOT NULL,
        \"passwords\" VARCHAR(255) NOT NULL
    )";

    try {
        $pdo->exec($sqlCreateTable);
        
        $newTable = $tableName.'d';
        $sqlstudentTable = "CREATE TABLE IF NOT EXISTS \"$newTable\" (
            \"rollno\" VARCHAR(255) NOT NULL,
            \"studentName\" VARCHAR(1000) NOT NULL
        )";
        
        $pdo->exec($sqlstudentTable);

        $teacherName = $_POST['teacherName'];
        $passwords = $_POST['passwords'];
        $tearcherSub = $_POST['teacherSub'];
        $tearcherSub1 = $_POST['teacherSub1'];

        // Insert records
        $stmtInsert = $pdo->prepare("INSERT INTO \"$tableName\" (\"teacherName\", \"teacherSub\", \"passwords\") VALUES (?, ?, ?)");
        $stmtInsert->execute([$teacherName, $tearcherSub, $passwords]);
        
        if (!empty($tearcherSub1)) {
            $stmtInsert->execute(['', $tearcherSub1, '']);
        }

        $stmtTeacherInsert = $pdo->prepare("INSERT INTO allteacher (otp, teacherName, username, teacherSub, division, semester) VALUES (?, ?, ?, ?, ?, ?)");
        $stmtTeacherInsert->execute(['', $teacherName, $tableName, 'abc', '', '']);
        
        echo 'success';
        
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }
}
?>
