<?php

namespace App\controllers;

use App\models\Category;
use Exception;
use Smarty;

class CategoryController
{
    private $categoryModel;
    private $smarty;

    public function __construct()
    {
        session_start();
        $this->categoryModel = new Category();
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(BASE_PATH . DIRECTORY_SEPARATOR . 'templates');
        
    }
    public function index($request)
    {
        try {
            // Pagination logic
            $perPage = 10; // Number of categories per page
            $page = isset($request['page']) ? (int) $request['page'] : 1; // Current page
    
            // Check if search term is provided
            $searchTerm = isset($request['search']) ? $request['search'] : null;
    
            if ($searchTerm) {
                // Perform search
                $searchResults = $this->categoryModel->searchByName($searchTerm);
               
    
                // Paginate the search results
                $paginatedData = $this->paginate($searchResults, $page, $perPage);
            } else {
                // Fetch categories with content count
                $categoriesData = $this->categoryModel->getCategoriesWithContentCount();
                
    
                // Paginate the categories
                $paginatedData = $this->paginate($categoriesData, $page, $perPage);
            }
    
            $pagination = $paginatedData['pagination'];
            $paginatedCategories = $paginatedData['data'];
    
            // Pass paginated categories data to the view
            $this->smarty->assign('categories', $paginatedCategories);
            $this->smarty->assign('pagination', $pagination);
            $this->smarty->display('categories/index.tpl');
        } catch (Exception $e) {
            // Handle the exception, e.g., log error, display a message, etc.
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    

    public function create()
    {
        // Fetch top-level categories
        $categories = $this->categoryModel->getCategories();

        // Pass categories data to the view
        $this->smarty->assign('categories', $categories);
        $this->smarty->display('categories/create.tpl');
    }

    public function store($request)
    {
        // Validate form data
        if (empty($request['category_name'])) {
            // Handle validation error
            echo "Category name cannot be empty";
            exit();
        }

        // Create new category instance
        $data = [
            'category_name' => $request['category_name'],
            'parent_id' => isset($request['parent_category']) && $request['parent_category'] !== '' ? $request['parent_category'] : null
        ];

        // Store the category
        $category_id = $this->categoryModel->store($data);
        header("Location: /mvcdashboard/categories");
       
    } 
  

    public function edit($request)
    {
        // Fetch category by ID
        $category = $this->categoryModel->find($request['id']);

        // Fetch all categories
        $categories = $this->categoryModel->getCategories();

        // Pass category data and categories list to the view
        $this->smarty->assign('category', $category);
        $this->smarty->assign('categories', $categories);
        $this->smarty->display('categories/edit.tpl');
    }
    public function update($request)
    {
        try {
            // Validate form data
            if (empty($request['category_name'])) {
                throw new Exception("Category name cannot be empty");
            }

            // Prepare data for update
            $data = [
                'category_name' => $request['category_name'],
                'parent_id' => isset($request['parent_category']) && $request['parent_category'] !== '' ? $request['parent_category'] : null
            ];

            // Check if 'category_id' key exists in the request
            if (!isset($request['id'])) {
                throw new Exception("Category ID is missing");
            }

            // Perform the update operation
            $this->categoryModel->update($request['id'], $data);

            // Redirect back to the index page after successful update
            header("Location: /mvcdashboard/categories");
            exit();
        } catch (Exception $e) {
            // Handle the exception, e.g., log error, display a message, etc.
            echo "Error: " . $e->getMessage();
        }
    }

  
public function destroy($request)
{
    // Delete category
    $this->categoryModel->delete($request['id']);

    // Redirect back to the index page
    header("Location: /mvcdashboard/categories");
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
// Add a new method to handle search requests
public function search($request)
{
    try {
        // Check if search term is provided
        if (!isset($request['search']) || empty($request['search'])) {
            throw new Exception("Search term is required");
        }

        // Perform the search
        $searchTerm = $request['search'];
        $searchResults = $this->categoryModel->searchByName($searchTerm);

        // Pass search results to the view
        $this->smarty->assign('categories', $searchResults);
        $this->smarty->display('categories/index.tpl');
    } catch (Exception $e) {
        // Handle the exception, e.g., log error, display a message, etc.
        echo "Error: " . $e->getMessage();
    }
}

 
}
