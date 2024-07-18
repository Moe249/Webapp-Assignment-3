<!-- Ahdy Emad-Eldeen Mohammed (Software Engineering) -->
 <!-- Search for pdf from database with id then retrieve a link to pdf file -->
<?php
if (isset($_GET['id'])) {
    // Database connection
    $dbconn = pg_connect("host=localhost dbname=ass3 user=postgres password=webdev")
        or die('Could not connect: ' . pg_last_error());

    $id = $_GET['id'];

    // Fetch PDF file path from database
    $query = "SELECT file_path FROM pdfs WHERE id = $1";
    $result = pg_query_params($dbconn, $query, array($id));

    if ($row = pg_fetch_assoc($result)) {
        $filePath = $row['file_path'];

        // Download PDF file
        if (file_exists($filePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            readfile($filePath);
        } else {
            echo 'File not found.';
        }
    }

    // Close database connection
    pg_close($dbconn);
}
?>
