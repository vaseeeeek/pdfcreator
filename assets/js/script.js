/* Событие клика для генерации PDF */
$('#generate-pdf').on('click', function() {
    $.post('generate_pdf.php', function() {
        alert('PDF создан успешно!');
    });
});
