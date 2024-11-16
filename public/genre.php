<?php
// Sambungkan ke database
include 'connect.php';

// Ambil genre dari parameter URL
$selected_genre = isset($_GET['genre']) ? $_GET['genre'] : '';

// Query untuk mengambil film sesuai genre
$query = "SELECT * FROM movies WHERE genre LIKE ?";
$stmt = $conn->prepare($query);
$like_genre = "%$selected_genre%";
$stmt->bind_param("s", $like_genre);

// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title> CINECAMPUS </title>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
            <link rel="stylesheet" href="css/style.css"/>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="w-full h-auto min-h-screen flex flex-col bg-gradient-to-b from-background1 via-background1 to-background2">
            <!-- Header Section -->
            <?php include 'header.php'; ?>
                <div>
                    <h1 class="flex flex-col items-center py-10 px-5 text-center text-3xl text-inter text-white font-istok font-bold">
                        Genre : 
                        <?php
                            // Ambil genre dari parameter URL
                            $selected_genre = isset($_GET['genre']) ? $_GET['genre'] : 'Genre Tidak Diketahui';

                            // Tampilkan nama genre
                            echo htmlspecialchars($selected_genre);
                        ?>
                    </h1>
                </div>
                
            <?php
                // Sambungkan ke database
                include 'connect.php';

                // Ambil genre dari parameter URL (default kosong jika tidak ada)
                $selected_genre = isset($_GET['genre']) ? $_GET['genre'] : '';

                // Query untuk mengambil film sesuai genre
                if ($selected_genre) {
                    $query = "SELECT * FROM movies WHERE genre LIKE ?";
                    $stmt = $conn->prepare($query);
                    $like_genre = "%$selected_genre%";
                    $stmt->bind_param("s", $like_genre);
                } else {
                    $query = "SELECT * FROM movies";
                    $stmt = $conn->prepare($query);
                }

                // Eksekusi query
                $stmt->execute();
                $result = $stmt->get_result();

                // Tampilkan hasil
                if ($result->num_rows > 0) {
                    echo '<div class="flex flex-wrap justify-center gap-8 mt-8">';
                    while ($row = $result->fetch_assoc()) {
                        echo '
                            <div class="movie-item text-center">
                                <img src="' . $row['poster'] . '" alt="' . $row['name'] . '" class="w-36 h-auto rounded-lg shadow-lg">
                                <p class="mt-2 text-sm text-white text-center mx-auto w-36 font-inter">' . $row['name'] . '</p>
                            </div>
                        ';
                    }
                    echo '</div>';
                } else {
                    echo '<p class="text-white text-center mt-10">No movies found for this genre.</p>';
                }

                $stmt->close();
                $conn->close();
            ?>

        </div>
            
        <?php include 'footer.php'; ?>
    </body>
</html>