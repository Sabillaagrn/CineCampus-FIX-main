<?php
session_start();
// Connection to the database
$servername = "localhost";
$username = "root";
$password = ""; // Adjust if necessary
$dbname = "login"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get movie ID from URL
$movie_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch the movie based on the ID
$sql = "SELECT id, name, poster, genre, year, duration, short_synopsis, synopsis, director, writer, actors, age_certificate, trailer_link FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineCampus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
</head>

<body>
    <div class="w-full h-full min-h-screen flex flex-col">
        <!-- Header Section -->
        <?php include 'header.php'; ?>

        <?php if ($result->num_rows > 0): ?>
            <?php $movie = $result->fetch_assoc(); ?>
                <div class="w-full h-[550px] flex flex-col relative bg-black">
                    <div class="flex flex-row items-center w-full h-full">
                        <img src="<?php echo $movie['poster']; ?>" alt="<?php echo $movie['name']; ?>" class="absolute w-full h-full object-cover z-0">
                        <div class="absolute w-full h-full bg-black bg-opacity-70 z-0"></div>

                        <div class="w-10/12 flex flex-col ml-28 z-10 p-4">
                            <span class="font-bold font-istok mt-16 text-4xl text-white w-1/2"><?php echo $movie['name']; ?></span>
                            <span class="font-inter mt-5 text-xl text-white w-1/2"><?php echo $movie['short_synopsis']; ?></span>

                            <div class="w-10/12 flex flex-row gap-x-4 mt-5">
                                <a href="#" class="w-fit bg-black bg-opacity-30 text-white px-4 py-2 rounded-full text-sm font-inter hover:drop-shadow-lg duration-200">
                                    <?php echo $movie['age_certificate']; ?>
                                </a>
                                <a href="#" class="w-fit bg-black bg-opacity-30 text-white px-4 py-2 rounded-full text-sm font-inter hover:drop-shadow-lg duration-200">
                                    <?php echo $movie['year']; ?>
                                </a>
                                <a href="#" class="w-fit bg-black bg-opacity-30 text-white px-4 py-2 rounded-full text-sm font-inter hover:drop-shadow-lg duration-200">
                                    <?php echo $movie['duration']; ?>
                                </a>
                            </div>

                            <a href="<?php echo $movie['trailer_link']; ?>" class="w-fit bg-[#FFC65D] text-white px-4 py-2 mt-14 rounded-full text-sm font-inter hover:drop-shadow-lg duration-200">
                                PLAY TRAILER
                            </a>

                            <div class="w-10/12 flex flex-row gap-x-4 mt-5">
                            <a href="ratings.php?id=<?php echo $_GET['id']; ?>" class="w-fit text-white mt-14 px-4 py-2 rounded-full text-sm font-inter hover:drop-shadow-lg duration-200">ULASAN</a>
                                <a href="discuss.php" class="w-fit text-white mt-14 px-4 py-2 rounded-full text-sm font-inter hover:drop-shadow-lg duration-200">FORUM DISKUSI</a>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="relative min-h-screen overflow-hidden m-0 p-10 w-full flex flex-row gap-6 bg-gradient-to-b from-bg_red via-bg_red to-bg_red_2 text-white">
                    <!-- Poster Section -->
                    <div class="poster w-1/4 flex flex-col items-center">
                        <img src="<?php echo $movie['poster']; ?>" alt="<?php echo $movie['name']; ?>" class="w-full rounded-lg mb-4">
                        <p class="text-lg font-semibold mt-2"><?php echo $movie['name']; ?></p>
                        <p class="text-sm text-gray-300"><?php echo $movie['genre']; ?></p>
                        <p class="text-lg font-bold"><?php echo $movie['age_certificate']; ?></p>
                    </div>

                    <!-- Detail Section -->
                    <div class="details w-2/4 bg-black bg-opacity-40 rounded-lg p-6">
                        <div class="icons flex gap-8 mb-6">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-comment text-3xl mb-2"></i>
                                <p class="text-sm font-semibold">REVIEWER</p>
                                <p class="text-sm">89 Reviews</p>
                            </div>
                            <div class="flex flex-col items-center">
                                <i class="fas fa-thumbs-up text-3xl mb-2"></i>
                                <p class="text-sm font-semibold">RATINGS</p>
                                <p class="text-sm">1000+ Ratings</p>
                            </div>
                        </div>
                
                        <div class="detail-info mb-6">
                            <h3 class="text-xl font-semibold mb-2">DETAILS</h3>
                            <p>Director: <?php echo $movie['director']; ?></p>
                            <p>Writer: <?php echo $movie['writer']; ?></p>
                            <p>Actors: <?php echo $movie['actors']; ?></p>
                            <p>Genre: <?php echo $movie['genre']; ?></p>
                            <p>Certificate: <?php echo $movie['age_certificate']; ?></p>
                        </div>
                
                        <div class="synopsis">
                            <h3 class="text-xl font-semibold mb-2">SINOPSIS</h3>
                            <p><?php echo $movie['synopsis']; ?></p>
                        </div>
                    </div>

                    <!-- Platform Section -->
                    <div class="platform w-1/4 flex flex-col items-center gap-4">
                        <h3 class="text-lg font-semibold mb-4">WHERE TO WATCH?</h3>
                        <a href="https://netflix.com" target="_blank">
                            <img src="img/netflix.png" alt="Netflix" class="h-10">
                        </a>
                        <a href="https://primevideo.com" target="_blank">
                            <img src="img/amazon.png" alt="Prime Video" class="h-12">
                        </a>
                        <a href="https://hotstar.com" target="_blank">
                            <img src="img/disney.png" alt="Disney Hotstar" class="h-12">
                        </a>
                        <a href="https://hulu.com" target="_blank">
                            <img src="img/hulu.png" alt="Hulu" class="h-10">
                        </a>
                    </div>

                    <div class="side-text absolute right-10 text-vertical">
                        <p class="tracking-widest">CINECAMPUS</p>
                    </div>
                </div>

                <div class="footer bg-black flex justify-between items-center py-6 px-10 text-gray-400 text-sm">
                    <div class="footer-links flex gap-8">
                        <!-- Footer links can go here -->
                    </div>
                    <div class="social-links flex gap-4">
                        <a href="https://instagram.com" target="_blank" class="hover:text-white"><i class='bx bxl-instagram text-2xl'></i></a>
                        <a href="https://facebook.com" target="_blank" class="hover:text-white"><i class='bx bxl-facebook text-2xl'></i></a>
                        <a href="https://youtube.com" target="_blank" class="hover:text-white"><i class='bx bxl-youtube text-2xl'></i></a>
                    </div>
                </div>

            </div>
        </body>
    </html>

<?php else: ?>
    <p class="text-center text-white">Film tidak ditemukan.</p>
<?php endif; ?>

<?php 
// Close connection
$conn->close(); 
?>
