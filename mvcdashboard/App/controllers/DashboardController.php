<?php
namespace App\controllers;

use App\models\Category;
use App\models\Content;
use App\models\User;
use Smarty;

class DashboardController {
    private $categoryModel;
    private $contentModel;
    private $userModel;
    private $smarty;

    public function __construct() {
        session_start();
        $this->categoryModel = new Category();
        $this->contentModel = new Content();
        $this->userModel = new User();
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(BASE_PATH . DIRECTORY_SEPARATOR . 'templates');
    }

    public function index() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!$this->userModel->isLoggedIn()) {
            // Redirect to login page if not logged in
            header('Location: /mvcdashboard/login');
            exit();
        }

        // Fetch username from session if set
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';

        // Fetch count of categories and content
        $categoryCount = $this->categoryModel->count();
        $contentCount = $this->contentModel->count();

        // Assign data to Smarty template
        $this->smarty->assign('username', $username);
        $this->smarty->assign('categoryCount', $categoryCount);
        $this->smarty->assign('contentCount', $contentCount);

        // Display dashboard template
        $this->smarty->display('dashboard.tpl');
    }
}
?>
