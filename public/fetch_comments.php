<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "discussion_db";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data komentar
$sql = "SELECT id, comment_text FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);

$comments = [];
while($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

echo json_encode($comments);

$conn->close();
?>
