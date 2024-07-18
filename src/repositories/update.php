
<?php
// Ahmed Emad Al-deen Hassan (software engineering)
// updating an already exsisting PDF
// @modified 2024-07-18 by Mohamed Alkhatim
// @brief    Applied mvc architecture

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

    // Check if the PDF already exists in the database
    $checkQuery = "SELECT COUNT(*) FROM pdfs WHERE title = $1";
    $checkResult = pg_query_params($dbconn, $checkQuery, array($title));
    $rowCount = pg_fetch_result($checkResult, 0, 0);

    if ($rowCount > 0) {
        // Update existing PDF details in the database
        $query = "UPDATE pdfs SET author = $1, file_path = $2 WHERE title = $3";
        $result = pg_query_params($dbconn, $query, array($author, $filePath, $title));
    } else {
        // Insert new PDF details into the database
        $query = "INSERT INTO pdfs (title, author, file_path) VALUES ($1, $2, $3)";
        $result = pg_query_params($dbconn, $query, array($title, $author, $filePath));
    }

    if ($result) {
        header('Location: /');
        exit;
        //echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to upload PDF'));
    }
}

// Close database connection
pg_close($dbconn);
?>
