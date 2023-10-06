<?php
/* Функция для сканирования директорий */
function scanDirectory($dir) {
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $files[] = $file->getRealPath();
        }
    }
    return $files;
}
?>
