<?php
// Database connection
$dbconn = pg_connect("host=localhost dbname=ass3 user=postgres password=webdev")
    or die('Could not connect: ' . pg_last_error());

// Fetch all PDFs from database
$query = "SELECT * FROM pdfs ORDER BY id DESC";
$result = pg_query($dbconn, $query);

$pdfs = array();
while ($row = pg_fetch_assoc($result)) {
    $pdfs[] = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'author' => $row['author'],
        'file_path' => $row['file_path']
    );
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($pdfs);

// Close database connection
pg_close($dbconn);
?>
