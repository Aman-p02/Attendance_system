<?php
require_once '../supabaseConn.php';

$tableName = $dbUser.'d';

try {
    $stmt = $pdo->prepare("DELETE FROM \"$tableName\"");
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error deleting rows: " . $e->getMessage();
}
?>

