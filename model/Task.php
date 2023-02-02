<?php
date_default_timezone_set('Asia/Manila');

class Task
{
	//properties
	private $conn;

	public $task_id;
	public $task_name;
	public $task_description;
	public $task_slug;
	public $due_date;
	public $status;
	public $category_id;
	public $user_id;
	public $created_date;
	public $updated_date;
	public $category_name;
	public $user_name;

	//constructor
	public function __construct($db)
	{
		$this->conn = $db;
	}

	//list all tasks
	public function index()
	{
		//sql statement
		$sql = "SELECT t.task_id, t.task_name, t.task_slug, t.task_description, t.due_date, t.status, t.category_id, t.user_id, t.created_date, t.updated_date, c.category_name, u.name ";
		$sql .= "from tasks as t left join categories as c ";
		$sql .= "On t.category_id = c.category_id ";
		$sql .= "left join users as u ";
		$sql .= "On t.user_id = u.user_id ";
		$sql .= "ORDER BY t.due_date";

		//prepare
		$stmt = $this->conn->prepare($sql);

		//execute
		$stmt->execute();


		return $stmt;
	}

	//show task info
	public function show()
	{
		//sql statement
		$sql = "SELECT t.task_id, t.task_name, t.task_description, t.task_slug, t.due_date, t.status, t.category_id, t.user_id, t.created_date, t.updated_date, c.category_name, u.name ";
		$sql .= "from tasks as t left join categories as c ";
		$sql .= "On t.category_id = c.category_id ";
		$sql .= "left join users as u ";
		$sql .= "On t.user_id = u.user_id ";
		$sql .= "WHERE t.task_id = ? ";
		$sql .= "ORDER BY t.due_date";

		//prepare
		$stmt = $this->conn->prepare($sql);

		//bind id
		$stmt->bindParam(1, $this->task_id, PDO::PARAM_INT);

		//execute
		$stmt->execute();

		//fetch data
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		//check if row has been fetch
		if ($row) {
			//set properties
			$this->task_id 				= $row['task_id'];
			$this->task_name 			= $row['task_name'];
			$this->task_description 	= $row['task_description'];
			$this->task_slug 			= $row['task_slug'];
			$this->due_date 			= $row['due_date'];
			$this->status 				= $row['status'];
			$this->category_id 			= $row['category_id'];
			$this->user_id 				= $row['user_id'];
			$this->created_date 		= $row['created_date'];
			$this->updated_date 		= $row['updated_date'];
			$this->user_name 			= $row['name'];
		}
		//if no data has been fetch return null
		else {
			return null;
		}
	}

	//create a new task
	public function create()
	{
		try {
			//sql insert query
			$sql = "INSERT INTO tasks (task_name, task_description, task_slug, due_date, status, user_id, category_id ) ";
			$sql .= "VALUES  (:task_name, :task_description, :task_slug, :due_date, :status, :user_id, :category_id)";

			//prepare statement
			$stmt = $this->conn->prepare($sql);

			//clean and sanitize data
			$this->task_name 		= clean_input($this->task_name);
			$this->task_description = clean_input($this->task_description);
			$this->task_slug		= to_slug(clean_input($this->task_name));
			$this->due_date 		= clean_input($this->due_date);
			$this->status 			= clean_input($this->status);
			$this->user_id 			= clean_input($this->user_id);
			$this->category_id 		= clean_input($this->category_id);

			//bind parameters
			$stmt->bindPAram(':task_name', $this->task_name);
			$stmt->bindPAram(':task_description', $this->task_description);
			$stmt->bindPAram(':due_date', $this->due_date);
			$stmt->bindPAram(':task_slug', $this->task_slug);
			$stmt->bindPAram(':status', $this->status);
			$stmt->bindPAram(':user_id', $this->user_id);
			$stmt->bindPAram(':category_id', $this->category_id);

			//execute
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	//update task
	public function update()
	{
		//current timestamp for update_date column
		$now = date("Y-m-d H:i:s");

		try {
			//sql insert query
			$sql = "UPDATE tasks SET task_name = :task_name, task_description = :task_description, task_slug = :task_slug, due_date = :due_date, status = :status, user_id = :user_id, category_id = :category_id, updated_date = '$now'";
			$sql .= "WHERE task_id = :task_id";

			//prepare statement
			$stmt = $this->conn->prepare($sql);

			//clean and sanitize data
			$this->task_name 		= clean_input($this->task_name);
			$this->task_description = clean_input($this->task_description);
			$this->task_slug		= to_slug(clean_input($this->task_name));
			$this->due_date 		= clean_input($this->due_date);
			$this->status 			= clean_input($this->status);
			$this->user_id 			= clean_input($this->user_id);
			$this->category_id 		= clean_input($this->category_id);
			$this->task_id			= clean_input($this->task_id);

			//bind parameters
			$stmt->bindPAram(':task_name', $this->task_name);
			$stmt->bindPAram(':task_description', $this->task_description);
			$stmt->bindPAram(':task_slug', $this->task_slug);
			$stmt->bindPAram(':due_date', $this->due_date);
			$stmt->bindPAram(':status', $this->status);
			$stmt->bindPAram(':user_id', $this->user_id);
			$stmt->bindPAram(':category_id', $this->category_id);
			$stmt->bindPAram(':task_id', $this->task_id);

			//execute
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	//delete task
	public function delete()
	{
		//create query
		$sql = "DELETE FROM tasks WHERE task_id = :task_id Limit 1";

		try {

			//prepare statement
			$stmt = $this->conn->prepare($sql);

			//clean and sanitize data
			$this->task_id = clean_input($this->task_id);

			//bind parameters
			$stmt->bindPAram(':task_id', $this->task_id, PDO::PARAM_INT);

			//execute
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	//search task by task name, category name and user name
	public function search()
	{
		//sql statement
		$sql = "SELECT t.task_id, t.task_name, t.task_description, t.task_slug, t.due_date, t.status, t.category_id, t.user_id, t.created_date, t.updated_date, c.category_name, u.name ";
		$sql .= "from tasks as t left join categories as c ";
		$sql .= "On t.category_id = c.category_id ";
		$sql .= "left join users as u ";
		$sql .= "On t.user_id = u.user_id ";
		$sql .= "WHERE t.task_name like :task_name or c.category_name like :category_name or u.name like :user_name";

		//prepare
		$stmt = $this->conn->prepare($sql);

		//clean and sanitize data
		$this->task_name 		= "%" . clean_input($this->task_name) . "%";
		$this->category_name 	= "%" . clean_input($this->category_name) . "%";
		$this->user_name 		= "%" . clean_input($this->user_name) . "%";

		//bind
		$stmt->bindPAram(':task_name', $this->task_name);
		$stmt->bindPAram(':category_name', $this->category_name);
		$stmt->bindPAram(':user_name', $this->user_name);

		//execute
		$stmt->execute();

		return $stmt;
	}
}
