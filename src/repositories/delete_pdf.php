<!-- Ahmed Emad Al-deen Hassan (software engineering )-->
<!-- deleting an already exsisting PDF-->
<!--
@modified 2024-07-18 by Mohamed Alkhatim
@brief    Applied mvc architecture
-->
 
<?php
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    // Database connection
    $dbconn = pg_connect("host=localhost dbname=ass3 user=postgres password=webdev")
        or die('Could not connect: ' . pg_last_error());

    $id = $_GET['id'];

    // Delete PDF record from database
    $query = "DELETE FROM pdfs WHERE id = $1";
    $result = pg_query_params($dbconn, $query, array($id));

    // Return success or failure
    if ($result) {
        http_response_code(204); // No content
    } else {
        http_response_code(500); // Internal server error
    }

    // Close database connection
    pg_close($dbconn);
}
?>
