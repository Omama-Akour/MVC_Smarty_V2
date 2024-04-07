<?php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);

    // Autoload Composer dependencies
    require_once BASE_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
 

    // Define directory paths relative to BASE_PATH
    $templateDir = BASE_PATH . DIRECTORY_SEPARATOR . 'templates'; 
      
    $compileDir = BASE_PATH . DIRECTORY_SEPARATOR . 'templates_c';
   
    $cacheDir = BASE_PATH . DIRECTORY_SEPARATOR . 'Smarty_Configs' . DIRECTORY_SEPARATOR . 'cache';
    $configDir = BASE_PATH . DIRECTORY_SEPARATOR . 'Smarty_Configs' . DIRECTORY_SEPARATOR . 'config';
   
    $smarty = new Smarty;

    // Set directory paths
    $smarty->setTemplateDir($templateDir);
    $smarty->setCompileDir($compileDir);
    $smarty->setCacheDir($cacheDir);
    $smarty->setConfigDir($configDir);

    // Other Smarty configurations can be set here
}
?>
