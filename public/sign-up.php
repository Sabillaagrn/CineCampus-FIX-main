<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi NIM panjang 10 dan password yang sama
    if (strlen($nim) != 10) {
        echo "<script>alert('NIM harus TEPAT sepuluh angka!');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('PASSWORD DOES NOT MATCH!');</script>";
    } else {
        // Hash password
        $hashed_password = md5($password);

        // Periksa apakah NIM sudah ada di database
        $checkNIM = "SELECT * FROM users WHERE nim='$nim'";
        $result = $conn->query($checkNIM);

        if ($result->num_rows > 0) {
            echo "<script>alert('NIM sudah terdaftar.');</script>";
        } else {
            // Simpan data ke database jika validasi berhasil
            $insertQuery = "INSERT INTO users (nama, nim, password) VALUES ('$nama', '$nim', '$hashed_password')";
            if ($conn->query($insertQuery) === TRUE) {
                echo "<script>alert('Akun berhasil dibuat. Silakan login.'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineCampus - Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
    <script>
        function validateForm() {
            const nim = document.forms["signUpForm"]["nim"].value;
            const password = document.forms["signUpForm"]["password"].value;
            const confirmPassword = document.forms["signUpForm"]["confirm_password"].value;

            if (nim.length !== 10) {
                alert("NIM harus TEPAT sepuluh angka!");
                return false;
            }
            if (password !== confirmPassword) {
                alert("PASSWORD DOES NOT MATCH!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body class="bg-gradient-to-b from-bg_red via-bg_red to-bg_red_2 min-h-screen flex items-center justify-center">

    <?php include 'header-login.php'; ?>

    <div class="absolute inset-0 bg-cover bg-center opacity-30 z-0" style="background-image: url('https://wallpapers.com/images/high/movie-poster-background-xw72c00uspkdklqq.webp');"></div>

    <!-- Sign Up Section -->
    <div class="relative mt-16 z-10 p-8 bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg w-full max-w-sm">
        <h1 class="text-white text-center font-semibold mb-4">CREATE YOUR ACCOUNT</h1>

        <!-- Sign Up Form -->
        <form name="signUpForm" action="sign-up.php" method="POST" onsubmit="return validateForm()">
            <!-- Full Name -->
            <div class="relative mb-4">
                <input type="text" name="nama" placeholder="Enter your full name" class="w-full p-3 rounded bg-white bg-opacity-30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <i class='bx bxs-user-circle absolute right-3 top-3 text-white'></i>
            </div>

            <!-- NIM -->
            <div class="relative mb-4">
                <input type="text" name="nim" placeholder="Enter your NIM" class="w-full p-3 rounded bg-white bg-opacity-30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <i class='bx bxs-id-card absolute right-3 top-3 text-white'></i>
            </div>

            <!-- Password -->
            <div class="relative mb-4">
                <input type="password" name="password" placeholder="Enter your password" class="w-full p-3 rounded bg-white bg-opacity-30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <i class='bx bxs-key absolute right-3 top-3 text-white'></i>
            </div>

            <!-- Confirm Password -->
            <div class="relative mb-4">
                <input type="password" name="confirm_password" placeholder="Confirm your password" class="w-full p-3 rounded bg-white bg-opacity-30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-red-500" required>
                <i class='bx bxs-lock absolute right-3 top-3 text-white'></i>
            </div>

            <!-- Sign Up Button -->
            <button type="submit" class="w-full py-3 mt-3 bg-red-600 text-white rounded hover:bg-red-700 transition duration-200">Sign Up</button>
        </form>

        <h1 class="text-white text-center mt-4">Already have an account? <a href="login.php" class="hover:text-blue-800 transition duration-500">Login</a></h1>
    </div>

</body>
</html>
