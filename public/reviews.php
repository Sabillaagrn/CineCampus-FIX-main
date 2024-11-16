<?php
session_start(); // Start the session to store and display reviews

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the last accessed movie title
$lastMovie = isset($_SESSION['last_movie']) ? $_SESSION['last_movie'] : "No movie selected";

// Handle new review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review'])) {
    $reviewText = htmlspecialchars($_POST['review']); // Sanitize review text
    $newReview = [
        'rating' => 5, // Default rating (adjustable if rating input is added)
        'review' => $reviewText
    ];
    // Save the review to the session
    $_SESSION['reviews'][] = $newReview;
}

// Handle review deletion
if (isset($_POST['delete_review'])) {
    $reviewIndex = $_POST['review_index'];
    unset($_SESSION['reviews'][$reviewIndex]); // Remove the review
    $_SESSION['reviews'] = array_values($_SESSION['reviews']); // Reindex reviews
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineCampus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <style>
      html {
        scroll-behavior: smooth; /* Smooth scrolling */
      }
    </style>
  </head>
  <body class="bg-gradient-to-b from-bg_red via-bg_red to-bg_red_2 text-white">
    <!-- Header Section -->
    <?php include 'header.php'; ?>

    <!-- Review Section -->
    <div class="flex flex-col items-center justify-center min-h-screen">
        <h1 class="text-4xl font-istok font-bold text-white mt-10">REVIEWS</h1>
        <p class="text-lg font-istok text-gray-300 mt-2">WRITE YOUR REVIEW ABOUT THIS MOVIE HERE</p>

        <form action="reviews.php#all_reviews" method="POST" class="w-10/12 md:w-8/12 lg:w-6/12 mt-4 bg-[#402020] rounded-lg p-8 shadow-md">
            <p class="text-gray-300 mb-4">TO: <?php echo htmlspecialchars($lastMovie); ?></p>

            <!-- Input Review -->
            <textarea name="review" class="w-full h-64 p-4 text-gray-300 bg-[#2b1a1a] rounded-lg resize-none placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FFC65D]" placeholder="WRITE HERE" required></textarea>

            <!-- Submit Button -->
            <button type="submit" class="mt-6 bg-white text-black px-6 py-2 rounded hover:bg-gray-300 transition duration-200">SUBMIT</button>
        </form>

        <?php if (!empty($_SESSION['reviews'])): ?>
        <h2 id="all_reviews" class="text-3xl font-istok font-bold text-white mt-12">All Reviews</h2>
        <?php foreach ($_SESSION['reviews'] as $index => $reviewData): ?>
            <div class="w-10/12 md:w-8/12 lg:w-6/12 mt-4 bg-[#402020] rounded-lg p-8 shadow-md">
                <!-- Display Rating -->
                <p class="text-gray-300 mb-2">Rating: <?php echo $reviewData['rating']; ?>/5</p>

                <!-- Display Review -->
                <p class="text-gray-300"><?php echo $reviewData['review']; ?></p>

                <!-- Delete Button -->
                <form action="reviews.php" method="POST" class="mt-4">
                    <input type="hidden" name="review_index" value="<?php echo $index; ?>">
                    <button type="submit" name="delete_review" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-200">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-300 mt-4">No reviews yet. Submit your review!</p>
        <?php endif; ?>
    </div>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
  </body>
</html>
