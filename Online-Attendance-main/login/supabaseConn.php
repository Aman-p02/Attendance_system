<?php
$host = "aws-0-eu-central-1.pooler.supabase.com";
$port = "6543";
$dbname = "postgres";
$user = "postgres.jmnwximojkkzkitegkaf";
$password = "Beastmodeon0212";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";

try {
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
