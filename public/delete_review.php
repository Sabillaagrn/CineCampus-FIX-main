<?php
session_start(); // Start the session to access stored reviews

// Check if review_index is set in POST data
if (isset($_POST['review_index'])) {
    $reviewIndex = $_POST['review_index'];
    
    // Check if the review index exists in the session
    if (isset($_SESSION['reviews'][$reviewIndex])) {
        // Remove the review from the session
        unset($_SESSION['reviews'][$reviewIndex]);
        // Reindex the reviews array to avoid gaps
        $_SESSION['reviews'] = array_values($_SESSION['reviews']);
    }
}

// Redirect back to the main review page
header('Location: reviews.php');
exit();
