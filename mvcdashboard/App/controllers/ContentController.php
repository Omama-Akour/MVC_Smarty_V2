<?php

namespace App\controllers;

use App\models\Content;
use App\models\Category;
use Smarty;
use Exception;

session_start();

class ContentController {
    
    private $categoryModel;
    private $contentModel;
    private $smarty;

    public function __construct() {
        
        $this->categoryModel = new Category();
        $this->contentModel = new Content();
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(BASE_PATH . DIRECTORY_SEPARATOR . 'templates');
    }

    
   public function index($request) {
    try {
        
        
        // Pagination logic
        $perPage = 10; // Number of contents per page
        $page = isset($request['page']) ? (int) $request['page'] : 1; // Current page
        
        // Fetch all categories
        $categories = $this->categoryModel->all();
        $contents = [];

        // Fetch contents based on search and category filters
        if (!empty($request['search']) || !empty($request['category_id'])) {
            $contents = $this->contentModel->searchAndFilter($request);
        } else {
            // If no search or category filter is applied, fetch all contents
            $contents = $this->contentModel->all();
            $paginatedData = $this->paginate($contents, $page, $perPage); // Correct variable name
            
            // Assign paginated data to variables
            $pagination = $paginatedData['pagination'];
            $contents = $paginatedData['data'];
        }
        
        // Update content with category names
        $newContents = [];
        foreach ($contents as $content) {
            $content['category_name'] = $this->contentModel->getCategoryName($content['category_id']);
            $newContents[] = $content;
        }
        $contents = $newContents;

        // Pass data to the view
        $this->smarty->assign('categories', $categories);
        $this->smarty->assign('contents', $contents);
        $this->smarty->assign('pagination', $pagination ?? []); // Ensure $pagination is defined
        $this->smarty->assign('request', $request); // Pass the entire request array to preserve other parameters
        $this->smarty->display('contents/index.tpl');
    } catch (Exception $e) {
        // Handle the exception
        echo "Error: " . $e->getMessage();
    }
}


    public function create() {
        // Fetch all categories for dropdown
        $categories = $this->categoryModel->all();
        
        // Assign categories to Smarty variable
        $this->smarty->assign('categories', $categories);
        
        // Render the view
        $this->smarty->display('contents/create.tpl');
    }
    // Store a newly created content in the database
    public function store($request) {
        // Check if all required keys are set in the request array
        if (!isset($request['content_title']) || !isset($request['content']) || !isset($request['category_id'])) {
            // Handle the missing keys situation differently
           
            return;
        }
    
        // Check if the user is logged in
        if(isset($_SESSION['user_id'])) {
            $addedBy = $_SESSION['user_id']; // Assuming user_id is the ID of the user
        } else {
            // Redirect the user to the login page or handle the situation accordingly
           
            header("Location:/mvcdashboard/login");
            exit();
        }
    
        // Create new content using data from request and the user ID
        $this->contentModel->create($request, $addedBy);
    
        // Redirect to the index page after storing the content
        header("Location: /mvcdashboard/contents");
        exit();
    }
    
    
   
public function edit($request) {
    // Ensure the 'id' parameter is set in the request
    if (!isset($request['id'])) {
        // Handle the case where 'id' is missing
        echo "ID parameter is missing";
        return;
    }

    // Get the ID of the content to be edited
    $id = $request['id'];

    // Fetch the content by ID
    $content = $this->contentModel->find($id);

    // Check if content is found
    if ($content) {
        // Fetch all categories
        $categories = $this->categoryModel->all();

        // Pass content data and categories list to the view
        $this->smarty->assign('content', $content);
        $this->smarty->assign('categories', $categories);
        $this->smarty->display('contents/edit.tpl');
    } else {
        
        echo "Content not found";
    }
}


public function update($request)
{
    // Validate form data
    if (empty($request['content_title'])) {
        // Handle validation error
        echo "Content title cannot be empty";
        exit();
    }

    // Check if 'content' key exists in the request
    if (!isset($request['content'])) {
        // Handle the case where 'content' key is missing
        echo "Content is missing";
        exit();
    }

    // Update content data
    $data = [
        'content_title' => $request['content_title'],
        'content' => $request['content'],
        'category_id' => $request['category_id'],
        'added_by' => $request['added_by'], // Assuming 'added_by' and 'added_date' are provided in the request
        'added_date' => $request['added_date']
    ];
    $this->contentModel->update($request['id'], $data);

    // Redirect back to the index page
    header("Location: /mvcdashboard/contents");
    exit();
}




public function destroy($request)
{
    // Delete category
    $this->contentModel->delete($request['id']);

    // Redirect back to the index page
    header("Location: /mvcdashboard/contents");
    exit();
}
private function paginate($data, $page, $perPage)
{
    $totalItems = count($data);
    $totalPages = ceil($totalItems / $perPage);

    $page = max(1, min($page, $totalPages));

    $offset = ($page - 1) * $perPage;
    $perPageData = array_slice($data, $offset, $perPage);

    $pagination = [];
    for ($i = 1; $i <= $totalPages; $i++) {
        $pagination[] = [
            'url' => "/mvcdashboard/categories?page=$i",
            'num' => $i
        ];
    }

    return ['data' => $perPageData, 'pagination' => $pagination];
}
 
}