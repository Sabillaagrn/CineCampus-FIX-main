<?php
$host = "localhost"; // Ganti dengan host database Anda
$username = "root";  // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
$database = "discussion_db"; // Nama database

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $user_name = "Anonymous"; // Ganti dengan nama pengguna yang sedang login jika ada

    $stmt = $conn->prepare("INSERT INTO comments (user_name, comment_text) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_name, $comment);
    $stmt->execute();
    $stmt->close();

    echo "Komentar berhasil dikirim";
}

$conn->close();
?>
