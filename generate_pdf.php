<?php
/* Подключение библиотек и установка параметров */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once('config.php');
require_once('utils.php');

$mpdf = new \Mpdf\Mpdf([
    'margin_top' => 30,
    'margin_footer' => 10
]);

$projectFiles = scanDirectory(PROJECT_ROOT);

/* Функция для форматирования пути файла */
function formatPath($path)
{
    global $projectFiles;
    return str_replace(PROJECT_ROOT, '', $path);
}

/* Стили для PDF */
$stylesheet = file_get_contents('styles.css');
$mpdf->WriteHTML($stylesheet, 1);

/* Заголовок документа */
$mpdf->WriteHTML('<h1 class="title">Структура проекта:</h1>');

/* Список всех файлов и папок */
/* Список всех файлов и папок */
foreach ($projectFiles as $filePath) {
    if (strpos($filePath, '.git') === false) { // Исключаем папку .git и ее содержимое
        $mpdf->WriteHTML('<p class="file-path">' . formatPath($filePath) . '</p>');
    }
}

/* Разделитель */
$mpdf->WriteHTML('<hr class="section-divider">');

foreach ($projectFiles as $filePath) {
    if (strpos($filePath, '.git') === false) {
        $content = file_get_contents($filePath);
        $formattedContent = htmlspecialchars($content);

        $mpdf->WriteHTML('<h2 class="file-title">Описание файла: ' . formatPath($filePath) . '</h2>');
        $mpdf->WriteHTML('<pre class="file-content">НАЧАЛО ОПИСАНИЯ' . "\n" . $formattedContent . "\n" . 'КОНЕЦ ОПИСАНИЯ</pre>');
        $mpdf->WriteHTML('<hr class="section-divider">');

        // Добавление новой страницы для следующего файла
        $mpdf->AddPage();
    }
}

/* Подвал с номером страницы */
$mpdf->SetHTMLFooter('<div style="text-align: right;">{PAGENO}</div>');

/* Сохранение PDF */
$mpdf->Output('project_structure.pdf', 'F');
?>