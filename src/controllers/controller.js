/* Ahdy Emad-Eldeen Mohammed (Software Engineering) */
/* Scripts for fetching pdfs from database, deleteing a pdf, editing a pdf */
/*
@modified 2024-07-18 by Mohamed Alkhatim
@brief    Applied mvc architecture
*/

document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch and display PDFs from server
    fetchPDFs();
    // Call fetchPDFs initially to populate the list
});


function fetchPDFs() {
    fetch('../repositories/get_pdfs.php')
        .then(response => response.json())
        .then(data => {
            const pdfList = document.getElementById('pdfList');
            pdfList.innerHTML = ''; // Clear existing list

            data.forEach(pdf => {
                const li = document.createElement('li');
                li.innerHTML = `
                        <strong>${pdf.title}</strong> by ${pdf.author}
                        <a href="../repositories/download.php?id=${pdf.id}" download>Download</a>
                        <button onclick="deletePDF(${pdf.id})">Delete</button>
                        <button onclick="editPDF(${pdf.id})">Edit</button>
                    `;
                pdfList.appendChild(li);
            });
        });
}

// Function to delete PDF
function deletePDF(id) {
    if (confirm('Are you sure you want to delete this PDF?')) {
        fetch(`../repositories/delete_pdf.php?id=${id}`, { method: 'DELETE' })
            .then(response => {
                if (response.ok) {
                    fetchPDFs(); // Refresh PDF list after deletion
                } else {
                    alert('Failed to delete PDF');
                }
            });
    }
}

function editPDF(id) {
    window.location.href = 'edit.html';
    var title;
    fetch('../repositories/get_pdfs.php')
        .then(response => response.json())
        .then(data => {
            const pdfList = document.getElementById('pdfList');
            pdfList.innerHTML = ''; // Clear existing list

            data.forEach(pdf => {
                if (pdf.id == id) {
                    window.location.href = 'edit.html/title?name=' + pdf.title;
                    //console.log(title);
                }
            });
        });

    //document.getElementById("title").value = title;
}
