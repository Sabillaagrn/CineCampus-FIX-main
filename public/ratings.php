<?php
session_start();

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

$movie_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch movie details
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $movie = $result->fetch_assoc(); // Fetch the movie details
} else {
    die("Movie not found.");
}

// Store the rating if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'])) {
    $rating = $_POST['rating'];

    // Check if there's already a rating for this movie
    $checkRatingSql = "SELECT * FROM ratings WHERE movie_id = ?";
    $checkStmt = $conn->prepare($checkRatingSql);
    $checkStmt->bind_param("i", $movie_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Update rating if it exists
        $updateRatingSql = "UPDATE ratings SET rating = ? WHERE movie_id = ?";
        $updateStmt = $conn->prepare($updateRatingSql);
        $updateStmt->bind_param("di", $rating, $movie_id);
        $updateStmt->execute();
    } else {
        // Insert a new rating if it doesn't exist
        $insertRatingSql = "INSERT INTO ratings (movie_id, rating) VALUES (?, ?)";
        $insertStmt = $conn->prepare($insertRatingSql);
        $insertStmt->bind_param("id", $movie_id, $rating);
        $insertStmt->execute();
    }

    $_SESSION['rating'] = $rating; // Optionally store the rating in session for feedback
}

// Simpan informasi nama movie ke session
$movieId = isset($_GET['id']) ? $_GET['id'] : 0;

// Ambil nama movie dari database
$sql = "SELECT name FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movieId);
$stmt->execute();
$stmt->bind_result($movieTitle);
$stmt->fetch();
$stmt->close();

// Simpan nama movie ke session
$_SESSION['last_movie'] = $movieTitle;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineCampus - Rating</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body class="bg-gradient-to-b from-bg_red via-bg_red to-bg_red_2 text-white">
    <!-- Header Section -->
    <?php include 'header.php'; ?>

    <!-- Rating Section -->
    <div class="w-full flex flex-col items-center py-10 px-5 text-center">
        <h1 class="text-4xl font-istok font-bold">RATINGS</h1>
        <p class="text-lg mt-3 font-istok">Place your rating about this movie here</p>

        <!-- Movie Poster and Rating Options -->
        <div class="flex flex-col md:flex-row items-center mt-8 space-y-5 md:space-y-0 md:space-x-10">
            <!-- Movie Poster -->
            <div class="w-52 h-72 bg-black overflow-hidden">
                <img src="<?php echo $movie['poster']; ?>" alt="<?php echo htmlspecialchars($movie['name']); ?>" class="w-full h-full object-cover drop-shadow-2xl shadow-2xl">
                <p class="mt-2 font-bold text-lg"><?php echo htmlspecialchars($movie['name']); ?></p>
            </div>

            <!-- Rating Options -->
            <div class="flex flex-col items-center">
                <p class="text-lg mb-4">How much stars for the movie?</p>
                <form action="reviews.php" method="POST">
                    <div class="flex space-x-2" id="starRating">
                        <!-- Star Icons with inline JavaScript interaction -->
                        <svg onclick="setRating(1)" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cursor-pointer star">
                            <polygon points="12 2 15 8 22 9 17 14 18 21 12 17 6 21 7 14 2 9 9 8 12 2"></polygon>
                        </svg>
                        <svg onclick="setRating(2)" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cursor-pointer star">
                            <polygon points="12 2 15 8 22 9 17 14 18 21 12 17 6 21 7 14 2 9 9 8 12 2"></polygon>
                        </svg>
                        <svg onclick="setRating(3)" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cursor-pointer star">
                            <polygon points="12 2 15 8 22 9 17 14 18 21 12 17 6 21 7 14 2 9 9 8 12 2"></polygon>
                        </svg>
                        <svg onclick="setRating(4)" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cursor-pointer star">
                            <polygon points="12 2 15 8 22 9 17 14 18 21 12 17 6 21 7 14 2 9 9 8 12 2"></polygon>
                        </svg>
                        <svg onclick="setRating(5)" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="cursor-pointer star">
                            <polygon points="12 2 15 8 22 9 17 14 18 21 12 17 6 21 7 14 2 9 9 8 12 2"></polygon>
                        </svg>
                    </div>
                    
                    <!-- Numeric Rating Input -->
                    <p class="text-lg mt-4">OR</p>
                    <p class="text-lg mt-4">Tell us your score!</p>
                    <div class="w-20 h-16 bg-transparent border border-sky-200 rounded-full flex items-center justify-center mt-2 text-2xl">
                        <input type="number" id="numericRating" name="rating" min="0" max="10" step="0.1" placeholder="0.0" class="bg-transparent text-center text-white w-full h-full rounded-full focus:outline-none" value="<?php echo $_SESSION['rating'] ?? ''; ?>" />
                    </div>
                    <button type="submit" class="mt-4 px-6 py-2 bg-white text-black rounded-lg font-semibold">Submit Rating</button>
                    <input type="hidden" name="id" value="<?php echo $movieId; ?>">
                </form>
            </div>
        </div>

        <script>
            // Function to set rating based on star click
            function setRating(rating) {
                document.getElementById('numericRating').value = rating;
                updateStars(rating);
            }

            function updateStars(rating) {
                const stars = document.querySelectorAll("#starRating .star");
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.setAttribute("fill", "white");
                    } else {
                        star.setAttribute("fill", "none");
                    }
                });
            }
        </script>
    </div>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
</body>
</html>
