<!-- Ahdy Emad-Eldeen Mohammed (Software Engineering) -->
 <!-- Search for row from database with id then drop from the table -->
<!--
@modified 2024-07-18 by Mohamed Alkhatim
@brief    Applied mvc architecture
-->

<?php
// Database connection
$dbconn = pg_connect("host=localhost dbname=ass3 user=postgres password=webdev")
    or die('Could not connect: ' . pg_last_error());

// File upload handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];

    $fileName = $_FILES['pdfFile']['name'];
    $fileTempName = $_FILES['pdfFile']['tmp_name'];

    // Move uploaded file to server directory
    $uploadDirectory = '../../storage/';
    $filePath = $uploadDirectory . $fileName;
    move_uploaded_file($fileTempName, $filePath);

    // Insert PDF details into database
    $query = "INSERT INTO pdfs (title, author, file_path) VALUES ($1, $2, $3)";
    $result = pg_query_params($dbconn, $query, array($title, $author, $filePath));

    if ($result) {
        header('Location: ../../index.html');
        exit;
        //echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to upload PDF'));
    }
}

// Close database connection
pg_close($dbconn);
?>
