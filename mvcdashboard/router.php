<?php
// routes.php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);

    // Autoload Composer dependencies
    require_once BASE_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


// Adjusted path for UserController
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'UserController.php';

// Adjusted path for HomeController
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'HomeController.php';
//////////Adjusted path for DashboardController
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'DashboardController.php';
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'CategoryController.php';
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'ContentController.php';



require_once BASE_PATH . DIRECTORY_SEPARATOR . 'Smarty_configs.php';
}

// Output the path for debugging
// echo(BASE_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
// exit();

$routes = [
    '/mvcdashboard/' => 'HomeController@index',
    '/mvcdashboard/login' => 'UserController@login',
    '/mvcdashboard/register' => 'UserController@register', // Route for login page
    '/mvcdashboard/dashboard' => 'DashboardController@index', // Route for dashboard
    '/mvcdashboard/logout' => 'UserController@logout',
    // Add more routes as needed
    ////////////for CATEGORIES////////////////////////////////////////////////////
    '/mvcdashboard/categories' => 'CategoryController@index',
    '/mvcdashboard/categories/create' => 'CategoryController@create',
    '/mvcdashboard/categories/store' => 'CategoryController@store',
    // '/mvcdashboard/categories' => 'CategoryController@show',
    '/mvcdashboard/categories/edit' => 'CategoryController@edit',
    '/mvcdashboard/categories/update' => 'CategoryController@update',
    '/mvcdashboard/categories/destroy' => 'CategoryController@destroy',
    '/mvcdashboard/categories/index2' => 'CategoryController@index2',
    'mvcdashboard/categories/search'=>'CategoryController@search',
    //////////////////////////FOR CONTENT/////////////////////////////////////////////////
   
    '/mvcdashboard/contents' => 'ContentController@index',
    '/mvcdashboard/contents/create' => 'ContentController@create',
    '/mvcdashboard/contents/store' => 'ContentController@store',
    '/mvcdashboard/contents/edit' => 'ContentController@edit',
    '/mvcdashboard/contents/update' => 'ContentController@update',
    '/mvcdashboard/contents/destroy' => 'ContentController@destroy',
];
// Define a function to generate route URLs
function generateRoute($routeName, $params = array()) {
    // Your logic to generate route URLs
    // Example implementation:
    switch ($routeName) {
        case 'categories.show':
            return '/mvcdashboard/categories/' . $params['id'];
        case 'categories.edit':
            return '/mvcdashboard/categories/' . $params['id'] . '/edit';
        case 'categories.destroy':
            return '/mvcdashboard/categories/' . $params['id'] . '/destroy';
        // Add more cases for other routes
        default:
            return '/';
    }
}

?>
