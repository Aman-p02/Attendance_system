<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../supabaseConn.php';

if (isset($_POST['randomNo'], $_POST['subject'], $_GET['dbName'])) {
    $randomNo = $_POST['randomNo'];
    $subject = $_POST['subject'];
    $tableName = $_GET['dbName'];

    try {
        $stmt = $pdo->prepare("UPDATE \"allTeacher\" SET \"teacherSub\" = ?, \"otp\" = ? WHERE \"username\" = ?");
        $stmt->execute([$subject, $randomNo, $tableName]);
        echo "Number and subject updated successfully";
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
    }
} else {
    echo "No random number or subject received.";
}
?>

