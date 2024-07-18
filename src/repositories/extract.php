<?php
// Check if a PDF file was uploaded
if ($_FILES['pdf-file']['error'] === UPLOAD_ERR_OK && $_FILES['pdf-file']['type'] === 'application/pdf') {
    // Path where the uploaded PDF file will be saved
    $uploadPath = '../../storage/' . basename($_FILES['pdf-file']['name']);

    // Move the uploaded PDF file to the storage directory
    if (move_uploaded_file($_FILES['pdf-file']['tmp_name'], $uploadPath)) {
        // Use pdfparser to extract text from the uploaded PDF file
        require_once '../../vendor/autoload.php'; // Include pdfparser library

        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($uploadPath);
        $text = $pdf->getText();

        // Return extracted text as JSON response
        header('Content-Type: application/json');
        echo json_encode(['text' => $text]);

        // Delete the uploaded PDF file
        unlink($uploadPath);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Failed to move uploaded file.']);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Invalid PDF file or no file uploaded.']);
}
?>
