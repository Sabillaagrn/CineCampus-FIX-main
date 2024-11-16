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

// Ambil ID komentar dari request
$commentId = $_POST['id'];

// Hapus komentar berdasarkan ID
$sql = "DELETE FROM comments WHERE id = $commentId";
if ($conn->query($sql) === TRUE) {
    echo "Comment deleted successfully";
} else {
    echo "Error deleting comment: " . $conn->error;
}

$conn->close();
?>
