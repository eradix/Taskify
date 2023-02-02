<?php
date_default_timezone_set('Asia/Manila');

class Category
{
    //properties
    private $conn;

    public $category_id;
    public $category_name;
    public $category_description;
    public $created_date;
    public $updated_date;


    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //list all categories
    public function index()
    {
        //sql statement
        $sql = "SELECT * from categories order by category_name";

        //prepare
        $stmt = $this->conn->prepare($sql);

        //execute
        $stmt->execute();

        return $stmt;
    }

    //show category info
    public function show()
    {
        //sql statement
        $sql = "SELECT * from categories ";
        $sql .= "WHERE category_id = ? ";

        //prepare
        $stmt = $this->conn->prepare($sql);

        //bind id
        $stmt->bindParam(1, $this->category_id, PDO::PARAM_INT);

        //execute
        $stmt->execute();

        //fetch data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //check if row has been fetch
        if ($row) {
            //set properties
            $this->category_id              = $row['category_id'];
            $this->category_name            = $row['category_name'];
            $this->category_description     = $row['category_description'];
            $this->created_date             = $row['created_date'];
            $this->updated_date             = $row['updated_date'];
        }
        //if no data has been fetch echo error
        else {
            return null;
        }
    }

    //create a category
    public function create()
    {
        try {

            //sql insert query
            $sql = "INSERT INTO categories (category_name, category_description) ";
            $sql .= "VALUES  (:category_name, :category_description)";

            //prepare statement
            $stmt = $this->conn->prepare($sql);

            //clean and sanitize data
            $this->category_name            = clean_input($this->category_name);
            $this->category_description     = clean_input($this->category_description);

            //bind parameters
            $stmt->bindPAram(':category_name', $this->category_name);
            $stmt->bindPAram(':category_description', $this->category_description);

            //execute
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //update a category
    public function update()
    {
        //current timestamp
        $now = date("Y-m-d H:i:s");

        try {

            //sql insert query
            $sql = "UPDATE categories SET category_name = :category_name, category_description = :category_description, updated_date = '$now'";
            $sql .= "WHERE category_id = :category_id";

            //prepare statement
            $stmt = $this->conn->prepare($sql);

            //clean and sanitize data
            $this->category_name            = clean_input($this->category_name);
            $this->category_description     = clean_input($this->category_description);
            $this->category_id              = clean_input($this->category_id);

            //bind parameters
            $stmt->bindPAram(':category_name', $this->category_name);
            $stmt->bindPAram(':category_description', $this->category_description);
            $stmt->bindPAram(':category_id', $this->category_id);

            //execute
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //delete category
    public function delete()
    {
        //create query
        $sql = "DELETE FROM categories WHERE category_id = :category_id Limit 1";

        try {

            //prepare statement
            $stmt = $this->conn->prepare($sql);

            //clean and sanitize data
            $this->category_id = clean_input($this->category_id);

            //bind parameters
            $stmt->bindPAram(':category_id', $this->category_id, PDO::PARAM_INT);

            //execute
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
