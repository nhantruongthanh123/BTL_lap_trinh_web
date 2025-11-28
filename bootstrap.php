<?php
define('ROOT', __DIR__);


// Xu ly http root
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $webroot = 'https' . '://' . $_SERVER['HTTP_HOST'];
}
else {
    $webroot = 'http://' . $_SERVER['HTTP_HOST'];
}

$documentRoot = str_replace('\\', '/', strtolower($_SERVER['DOCUMENT_ROOT']));
$rootPath = str_replace('\\', '/', strtolower(ROOT));
$folder = str_replace($documentRoot, '', $rootPath);
$webroot .= $folder;
define('WEBROOT', $webroot);




require_once 'app/config/routes.php';
require_once 'app/config/database.php';
require_once 'app/config/app.php';
require_once 'core/BaseController.php';

