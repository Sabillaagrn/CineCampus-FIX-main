<?php
session_start();
include("connect.php");

// Menghapus session untuk logout
session_unset();
session_destroy();

// Arahkan kembali ke halaman login setelah logout
header("Location: login.php");
exit();
?>
