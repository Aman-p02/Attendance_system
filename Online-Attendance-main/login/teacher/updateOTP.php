<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../supabaseConn.php';

if (isset($_POST['randomNo'], $_GET['dbName'])) {
    $randomNo = $_POST['randomNo'];
    $tableName = $_GET['dbName'];

    try {
        $stmt = $pdo->prepare("UPDATE \"allTeacher\" SET \"otp\" = ? WHERE \"username\" = ?");
        $stmt->execute([$randomNo, $tableName]);
        echo "OTP updated successfully";
    } catch (PDOException $e) {
        echo "Error updating record: " . $e->getMessage();
    }
} else {
    echo "No random number received.";
}
?>

