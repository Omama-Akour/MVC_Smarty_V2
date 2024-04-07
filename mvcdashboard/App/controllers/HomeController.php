<?php


namespace App\controllers;
use Smarty;
class HomeController {
    private $smarty;
   
    public function index() { session_start();
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(BASE_PATH . DIRECTORY_SEPARATOR . 'templates'); // Adjusted path for templates directory
        $this->smarty->display('login.tpl');
    }
}

?>
