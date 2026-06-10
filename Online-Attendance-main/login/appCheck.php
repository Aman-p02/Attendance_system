<?php
require_once 'supabaseConn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rollNo = $_POST['rollNo'];
    $enteredOTP = $_POST['enteredOTP'];

    try {
        // Find teacher with matching OTP
        $stmt = $pdo->prepare("SELECT * FROM \"allTeacher\" WHERE \"otp\" = ?");
        $stmt->execute([$enteredOTP]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $teacherName = $row['username'].'d';

            // Get student name
            $stmt1 = $pdo->prepare("SELECT * FROM \"allStudent\" WHERE \"rollno\" = ?");
            $stmt1->execute([$rollNo]);
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

            if ($row1) {
                $studentName = $row1['studentName'];

                // Insert attendance
                $stmtInsert = $pdo->prepare("INSERT INTO \"$teacherName\" (\"rollno\", \"studentName\") VALUES (?, ?)");
                $stmtInsert->execute([$rollNo, $studentName]);
                echo "correct";
            } else {
                echo "incorrect";
            }
        } else {
            echo "incorrect";
        }
    } catch (PDOException $e) {
        echo "incorrect";
    }
} else {
    echo "Invalid request method";
}
?>


