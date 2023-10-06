<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';
require_once('config.php');
require_once('utils.php');

$mpdf = new \Mpdf\Mpdf();

$projectFiles = scanDirectory(PROJECT_ROOT);

// Функция для форматирования пути файла, убирая часть пути до корневой директории проекта
function formatPath($path) {
    global $projectFiles;
    return str_replace(PROJECT_ROOT, '', $path);
}

// Создание списка всех файлов и папок
$directoryStructure = "Структура проекта:\n";
foreach ($projectFiles as $filePath) {
    $directoryStructure .= formatPath($filePath) . "\n";
}

// Добавление списка файлов и папок в PDF
$mpdf->WriteHTML('<pre>' . $directoryStructure . '</pre>');

// Добавление содержимого каждого файла в PDF
foreach ($projectFiles as $filePath) {
    $content = file_get_contents($filePath);
    $mpdf->WriteHTML('<pre>' . "\n\n" . formatPath($filePath) . "\n\n" . htmlspecialchars($content) . '</pre>');
}

$mpdf->Output('project_structure.pdf', 'F');
?>
