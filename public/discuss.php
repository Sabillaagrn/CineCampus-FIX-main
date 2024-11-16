<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CineCampus</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body class="bg-gradient-to-b from-bg_red via-bg_red to-bg_red_2 text-white">
<div class="min-h-screen bg-gradient-to-b from-bg_red via-bg_red to-bg_red_2 text-white flex flex-col items-center">
    <!-- Header Section -->
    <?php include 'header.php' ?>

    <!-- ISI KONTEN DISCUSSION PAGE -->
    <div class="max-w-4xl mx-auto p-8">
        <!-- Title Section -->
        <div class="text-center flex flex-row gap-8 mb-8">
            <h1 class="text-3xl font-bold mb-6">Discussion Forum</h1>
            <p class="text-lg mt-2 font-semibold">13 BOM DI JAKARTA</p>
        </div>

        <!-- Discussion Comments -->
        <div class="space-y-6">
            <!-- Komentar akan di-load di sini -->
        </div>

        <!-- Comment Input -->
        <div class="flex items-center space-x-4 mt-8">
            <i class='bx bxs-user-circle text-4xl'></i>
            <input id="commentInput" class="flex-1 bg-gray-700 text-white rounded-full px-4 py-2 text-sm" placeholder="Type Here">
            <button id="submitComment" type="button" class="text-white bg-gray-700 px-4 py-2 rounded-lg text-sm">Send</button>
        </div>
    </div>
</div>

<!-- Footer Section -->
<?php include 'footer.php'; ?>

<script>
    // Fungsi untuk mengambil dan menampilkan komentar
    function fetchComments() {
        fetch('fetch_comments.php')
            .then(response => response.json())
            .then(comments => {
                const commentSection = document.querySelector('.space-y-6');
                commentSection.innerHTML = ''; // Bersihkan komentar yang ada

                comments.forEach(comment => {
                    const commentDiv = document.createElement('div');
                    commentDiv.classList.add('flex', 'items-start', 'mb-6', 'space-x-4');
                    commentDiv.innerHTML = `
                        <div class="bg-gray-500 rounded-full w-12 h-12 flex items-center justify-center">
                            <i class='bx bxs-user text-2xl text-white'></i>
                        </div>
                        <div class="bg-gray-800 p-4 rounded-lg flex-1 text-sm">
                            <p>${comment.comment_text}</p>
                            <div class="flex space-x-4 mt-2 text-gray-400">
                                <button class="hover:text-red-500">
                                    <i class='bx bx-heart'></i>
                                </button>
                                <button class="hover:text-blue-500">
                                    <i class='bx bx-share-alt'></i>
                                </button>
                                <button class="hover:text-green-500">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="hover:text-white px-3 py-1 rounded-lg text-xs">Reply</button>
                                <button onclick="deleteComment(${comment.id})" class="hover:text-red-700 px-3 py-1 rounded-lg text-xs">Delete</button>
                            </div>
                        </div>
                    `;
                    commentSection.appendChild(commentDiv);
                });
            });
    }

    // Fungsi untuk mengirimkan komentar
    document.getElementById('submitComment').addEventListener('click', function() {
        const commentInput = document.getElementById('commentInput');
        const comment = commentInput.value.trim();

        if (comment) {
            fetch('submit_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'comment=' + encodeURIComponent(comment)
            })
            .then(response => response.text())
            .then(data => {
                commentInput.value = ''; // Bersihkan input
                fetchComments(); // Segarkan daftar komentar
            });
        }
    });

    // Fungsi untuk menghapus komentar
    function deleteComment(commentId) {
        if (confirm("Apakah Anda yakin ingin menghapus komentar ini?")) {
            fetch('delete_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(commentId)
            })
            .then(response => response.text())
            .then(data => {
                fetchComments(); // Refresh daftar komentar setelah penghapusan
            });
        }
    }

    // Ambil komentar ketika halaman dimuat
    window.onload = function() {
        fetchComments();
    };
</script>

</body>
</html>
