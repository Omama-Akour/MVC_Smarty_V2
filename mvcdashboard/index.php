<?php
// Define base path constant
define('BASE_PATH', __DIR__);

// Autoload Composer dependencies
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'Smarty_configs.php';

// Include routing file
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'router.php';

// Get the requested URL path
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = strtok($request_uri, '?'); // Remove query parameters

// Match the requested URL path to a route
if (isset($routes[$request_uri])) {
    // Extract controller and action from the route
    list($controller_name, $action_name) = explode('@', $routes[$request_uri]);
  
    // Include the controller file (assuming it follows PSR-4 namespace)
    $controller_class = 'App\\controllers\\' . $controller_name;
    if (class_exists($controller_class)) {
        $controller = new $controller_class();
         
        // Call the action method if exists
        if (method_exists($controller, $action_name)) {
            // Pass $request to the controller method if it expects an argument
            $reflectionMethod = new ReflectionMethod($controller_class, $action_name);
            if ($reflectionMethod->getNumberOfParameters() > 0) {
                $controller->$action_name($_REQUEST); // Pass $_REQUEST or any appropriate data
            } else {
                $controller->$action_name();
            }
            exit(); // Stop further execution
        }
    }
}
// If no route is found, handle 404 error
// You can include a custom error page here if desired
?>
