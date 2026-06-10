<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../supabaseConn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        try {
            $stmt = $pdo->prepare("SELECT * FROM \"$username\" WHERE \"passwords\" = ?");
            $stmt->execute([$password]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['username'] = $username;
                echo 'success';
            } else {
                echo 'failure';
            }
        } catch (PDOException $e) {
            echo 'query_failure';
        }
    } else {
        echo 'invalid_post_data';
    }
} else {
    echo 'Invalid request method';
}
?>
