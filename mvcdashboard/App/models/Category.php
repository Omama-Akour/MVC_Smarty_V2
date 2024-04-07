<?php

namespace App\models;

use App\models\Database;
use Exception;
class Category
{
    protected $table = 'categories'; 
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function all()
    {
        $query = "SELECT * FROM $this->table";
        $result = $this->database->query($query);

        if (!$result) {
            // Handle query error
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    


    public function find($id)
    {
        // $query = "SELECT * FROM $this->table WHERE id = ?";
        $query = "SELECT c.*, COALESCE(COUNT(ct.id), 0) AS contents_count
        FROM categories c
        LEFT JOIN contents ct ON c.id = ct.category_id
        WHERE c.id = ?
        GROUP BY c.id";
        
        
        $result = $this->database->prepare($query);
        $result->bind_param('i', $id);
        $result->execute();

        return $result->get_result()->fetch_object();
    }




    public function create($data)
    {
        try {
            // Ensure that the parent category exists if provided
            if (isset($data['parent_id'])) {
                $parentCategory = $this->find($data['parent_id']);
                if (!$parentCategory) {
                    // Parent category does not exist
                    return false;
                }
            }

            $category_name = $this->database->escapeString($data['category_name']);
            $parent_id = isset($data['parent_id']) ? (int) $data['parent_id'] : null;

            $query = "INSERT INTO $this->table (category_name, parent_id) VALUES (?, ?)";
            $result = $this->database->prepare($query);
            $result->bind_param('si', $category_name, $parent_id);

            // Execute the query
            if ($result->execute()) {
                return $this->database->lastInsertId();
            } else {
                // Error occurred
                return false;
            }
        } catch (Exception $e) {
            // Handle exceptions
            return false;
        }
    }




    public function update($id, $data)
    {
        // Validate if the provided parent category ID exists
        if (isset($data['parent_id']) && $data['parent_id'] !== null) {
            $parentCategory = $this->find($data['parent_id']);
            if (!$parentCategory) {
                throw new Exception('Parent category ID does not exist');
            }
        }
    
        $category_name = $this->database->escapeString($data['category_name']);
        $parent_id = isset($data['parent_id']) ? (int) $data['parent_id'] : null;
    
        $query = "UPDATE $this->table SET category_name = ?, parent_id = ? WHERE id = ?";
        $result = $this->database->prepare($query);
        $result->bind_param('sii', $category_name, $parent_id, $id);
        $result->execute();
    }







    public function delete($categoryId)
    //////
    {
        $query = "DELETE FROM $this->table WHERE id = ?";
        $result = $this->database->prepare($query);
        $result->bind_param('i', $categoryId);
        $result->execute();
    }
    
     


    public function getCategoriesWithContentCount()
    {
        // Query to fetch categories along with their content count
        $sql = "SELECT c.*, COUNT(ct.id) AS contents_count
                FROM categories c
                LEFT JOIN contents ct ON c.id = ct.category_id
                GROUP BY c.id";

        // Execute the query
        $result = $this->database->query($sql);

        // Fetch the results as objects
        $categories = [];
        while ($row = $result->fetch_object()) {
            $categories[] = $row;
        }

        return $categories;
    }
    



    public function count() {
        $qry = "SELECT COUNT(*) AS count FROM categories";
        $result = $this->database->query($qry);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }




    public function store($data)
    {
        try {
            // Validate if the provided parent category ID exists
            if (isset($data['parent_id']) && $data['parent_id'] !== null) {
                $parentCategory = $this->find($data['parent_id']);
                if (!$parentCategory) {
                    throw new Exception('Parent category ID does not exist');
                }
            }
    
            // Create the new category
            $categoryId = $this->create($data);
    
            // If parent category ID is provided, update the newly created category with the parent ID
            if (isset($data['parent_id']) && !empty($data['parent_id'])) {
                $this->update($categoryId, ['parent_id' => $data['parent_id']]);
            }
    
            return $categoryId;
        } catch (Exception $e) {
            // Handle exceptions
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
  



public function searchByName($searchTerm)
{
    // Construct the SQL query to search for categories and count their contents
    $sql = "SELECT c.*, COUNT(ct.id) AS contents_count
            FROM categories c
            LEFT JOIN contents ct ON c.id = ct.category_id
            WHERE c.category_name LIKE '%" . $this->database->escapeString($searchTerm) . "%'
            GROUP BY c.id";

    $result = $this->database->query($sql);

    $searchResults = [];
    while ($row = $result->fetch_object()) {
        $searchResults[] = $row;
    }

    return $searchResults;
}



public function getCategories($parentId = null)
{
    $categories = [];

    // Fetch categories based on the provided parent ID
    $query = "SELECT c.*, p.category_name AS parent_name 
              FROM categories c 
              LEFT JOIN categories p ON c.parent_id = p.id 
              WHERE c.parent_id " . ($parentId === null ? "IS NULL" : "= $parentId");
              
    $result = $this->database->query($query);

    while ($row = $result->fetch_object()) {
        // Add the current category to the list
        $category = $row;

        // Recursively fetch subcategories
        $category->sub = $this->getCategories($category->id);

        // Add the current category to the list
        $categories[] = $category;
    }

    return $categories;
}

}
