<?php
// Memulai sesi
session_start();

// Menyimpan data review di sesi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST['rating'];
    $review = htmlspecialchars($_POST['review']); // Mencegah XSS

    // Menyimpan data review ke array di sesi
    $_SESSION['reviews'][] = [
        'rating' => $rating,
        'review' => $review
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submitted Reviews</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gradient-to-b from-bg_red via-bg_red to-bg_red_2 text-white">
    <div class="flex flex-col items-center min-h-screen">
        <h1 class="text-4xl font-istok font-bold mt-10">All Reviews</h1>

        <!-- Card untuk setiap review -->
        <?php if (!empty($_SESSION['reviews'])): ?>
            <?php foreach ($_SESSION['reviews'] as $reviewData): ?>
                <div class="w-10/12 md:w-8/12 lg:w-6/12 mt-4 bg-[#402020] rounded-lg p-8 shadow-md">
                    <!-- Menampilkan Rating -->
                    <p class="text-gray-300 mb-2">Rating: <?php echo $reviewData['rating']; ?>/5</p>
                    
                    <!-- Menampilkan Review -->
                    <p class="text-gray-300"><?php echo $reviewData['review']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-300">No reviews yet. Submit your review!</p>
        <?php endif; ?>
    </div>
</body>
</html>
