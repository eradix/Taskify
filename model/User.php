<?php
date_default_timezone_set('Asia/Manila');

class User
{
    //properties
    private $conn;

    public $user_id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $created_date;
    public $updated_date;

    //constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //list all users
    public function index()
    {
        //sql statement
        $sql = "SELECT * from users order by name";

        //prepare
        $stmt = $this->conn->prepare($sql);

        //execute
        $stmt->execute();

        return $stmt;
    }

    //show user info
    public function show()
    {
        //sql statement
        $sql = "SELECT * from users ";
        $sql .= "WHERE user_id = ? ";

        //prepare
        $stmt = $this->conn->prepare($sql);

        //bind id
        $stmt->bindParam(1, $this->user_id, PDO::PARAM_INT);

        //execute
        $stmt->execute();

        //fetch data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //check if row has been fetch
        if ($row) {
            //set properties
            $this->user_id          = $row['user_id'];
            $this->name             = $row['name'];
            $this->email            = $row['email'];
            $this->password         = $row['password'];
            $this->role             = $row['role'];
            $this->created_date     = $row['created_date'];
            $this->updated_date     = $row['updated_date'];
        }
        //if no data has been fetch return null
        else {
            return null;
        }
    }

    //create a user
    public function create()
    {
        try {

            //sql insert query
            $sql = "INSERT INTO users (name, email, password, role) ";
            $sql .= "VALUES  (:name, :email, :password, :role)";

            //prepare statement
            $stmt = $this->conn->prepare($sql);

            //clean and sanitize data
            $this->name     = clean_input($this->name);
            $this->email    = clean_input($this->email);
            $this->password = sha1(clean_input($this->password));
            $this->role     = clean_input($this->role);

            //bind parameters
            $stmt->bindPAram(':name', $this->name);
            $stmt->bindPAram(':email', $this->email);
            $stmt->bindPAram(':password', $this->password);
            $stmt->bindPAram(':role', $this->role);

            //execute
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //update a user profile
    public function update()
    {
        //current timestamp
        $now = date("Y-m-d H:i:s");

        try {

            //sql insert query
            $sql = "UPDATE users SET name = :name, email = :email, password = :password, role = :role, updated_date = '$now'";
            $sql .= "WHERE user_id = :user_id";

            //prepare statement
            $stmt = $this->conn->prepare($sql);

            //clean and sanitize data
            $this->name         = clean_input($this->name);
            $this->email        = clean_input($this->email);
            $this->password     = sha1(clean_input($this->password));
            $this->role         = clean_input($this->role);
            $this->user_id      = clean_input($this->user_id);

            //bind parameters
            $stmt->bindPAram(':name', $this->name);
            $stmt->bindPAram(':email', $this->email);
            $stmt->bindPAram(':password', $this->password);
            $stmt->bindPAram(':role', $this->role);
            $stmt->bindPAram(':user_id', $this->user_id);

            //execute
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //delete user
    public function delete()
    {
        //create query
        $sql = "DELETE FROM users WHERE user_id = :user_id LIMIT 1";

        try {
            //prepare statement
            $stmt = $this->conn->prepare($sql);

            //clean and sanitize data
            $this->user_id = clean_input($this->user_id);

            //bind parameters
            $stmt->bindPAram(':user_id', $this->user_id, PDO::PARAM_INT);

            //execute
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
