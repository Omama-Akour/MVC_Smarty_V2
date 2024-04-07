<?php
namespace App\models;

use App\models\Database;
use Exception;

class Content {
    private $db;
    protected $table = 'contents'; 
    public function __construct() {
        $this->db = new Database();
    }

    public function all() {
        $sql = "SELECT * FROM contents"; // Fetch all content from the 'contents' table
        $result = $this->db->query($sql);
        $contents = [];
        while ($row = $result->fetch_assoc()) {
            $contents[] = $row;
        }
        return $contents;
    }   
    public function searchAndFilter($request) {
        $sql = "SELECT * FROM contents WHERE 1";
    
        // Add search condition if search query is provided
        if (!empty($request['search'])) {
            $searchTerm = $this->db->escapeString($request['search']);
            $sql .= " AND (content_title LIKE '%$searchTerm%' OR content LIKE '%$searchTerm%')";
        }
    
        // Add category filter if category_id is provided
        if (!empty($request['category_id'])) {
            $categoryId = $this->db->escapeString($request['category_id']);
            $sql .= " AND category_id = $categoryId";
        }
    
        // Debugging: Output the SQL query for inspection
        // You can remove or comment this line after debugging
    
        // Execute the query
        return $this->db->Query($sql);
    }
    
    
    public function getCategoryName($categoryId) {
    $sql = "SELECT category_name FROM categories WHERE id = " . $this->db->escapeString($categoryId);
    $result = $this->db->Query($sql);
    $row = $result->fetch_assoc();
    return $row['category_name'];
}

    public function find($id) {
        // Escape the ID parameter to prevent SQL injection
        $escapedId = $this->db->escapeString($id);
    
        // Query for a single content item based on the ID
        $sql = "SELECT * FROM contents WHERE id = $escapedId";
    
        // Execute the query and return the result
        $result = $this->db->Query($sql);
    
        // Fetch a single row from the result set
        return $result->fetch_assoc();
    }
    
    
    

    public function create($data, $addedBy) {
        // Escape data and ensure they are set properly
        $contentTitle = $this->db->escapeString($data['content_title']);
        $content = $this->db->escapeString($data['content']);
        $category_id = $this->db->escapeString($data['category_id']);
        
        // Check if the user is logged in
        if(isset($_SESSION['user_id'])) {
            $addedBy = $_SESSION['user_id']; // Assuming user_id is the ID of the user
        } else {
            // Redirect the user to the login page or handle the situation accordingly
            // For example:
            header("Location:/mvcdashboard/login");
            exit();
        }
        
        // Ensure $addedBy is a string before passing it to escapeString
        $addedBy = (string) $addedBy;
    
        $addedDate = date('Y-m-d H:i:s');
    
        // Check if the provided category ID is not empty
        if (empty($category_id)) {
            throw new Exception('Category ID is empty');
        }
    
        // Check if the provided category ID exists in the categories table
        $category = $this->db->find($category_id, 'categories');
        if (!$category) {
            throw new Exception('Category ID does not exist');
        }
    
        // Insert the content into the contents table
        $sql = "INSERT INTO contents (content_title, content, category_id, added_by, added_date) 
                VALUES ('$contentTitle', '$content', '$category_id', '$addedBy', '$addedDate')";
        return $this->db->Query($sql);
    }





    
    public function update($id, $data) {
        // Check if all required keys are set in the data array
        if (!isset($data['content_title']) || !isset($data['content']) || !isset($data['category_id'])) {
            throw new Exception('Required keys are missing in the data array');
        }
    
        // Escape data and ensure they are set properly
        $contentTitle = $this->db->escapeString($data['content_title']);
        $content = $this->db->escapeString($data['content']);
        $categoryId = $this->db->escapeString($data['category_id']);
    
        // Check if the provided category ID exists in the categories table
        $category = $this->db->find($categoryId, 'categories');
        if (!$category) {
            throw new Exception('Category ID does not exist');
        }
    
        // Update the content in the contents table
        $sql = "UPDATE contents 
                SET content_title = '$contentTitle', content = '$content', category_id = '$categoryId' 
                WHERE id = " . $this->db->escapeString($id);
        return $this->db->Query($sql);
    }
    
     


    public function delete($contentId)
    {
        $query = "DELETE FROM $this->table WHERE id = ?";
        $result = $this->db->prepare($query);
        $result->bind_param('i', $contentId);
        $result->execute();
    }
    
    




    // public function getByCategory($categoryId) {
    //     $sql = "SELECT * FROM contents WHERE category_id = " . $this->db->escapeString($categoryId);
    //     return $this->db->Query($sql);
    // }
    
    
    public function count() {
        $qry = "SELECT COUNT(*) AS count FROM contents";
        $result = $this->db->query($qry);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
   
    public function paginate($offset, $limit) {
        $sql = "SELECT * FROM contents LIMIT $offset, $limit";
        return $this->db->Query($sql);
    }

    
}
