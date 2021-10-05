<?php

class User{

	protected static $db_table = "users";
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;


	public static function find_all_users(){
		return self::find_this_query("SELECT * FROM users");
	}


	public static function find_user_by_id($id){
		$the_result_array = self::find_this_query("SELECT * FROM users WHERE id = {$id} LIMIT 1");
		return !empty($the_result_array)? array_shift($the_result_array): false;
	}


	public static function find_this_query($sql){
		global $database;
		$result = $database->query($sql);
		$the_object_array = array();
		while($row = mysqli_fetch_array($result)){
			$the_object_array[] = self::instantiation($row);
		}
		return $the_object_array;
	}


	public static function instantiation($the_record){
		$the_object = new User();
        foreach ($the_record as $the_attribute => $value) {
        	if($the_object->has_the_attribute($the_attribute)){
        		$the_object->$the_attribute = $value;
        	}
        }
        return $the_object;
	}


	private function has_the_attribute($the_attribute){
		$properties = get_object_vars($this);
		return array_key_exists($the_attribute, $properties);
	}


	public static function verify_user($username, $password){
		global $database;

		$username = $database->escape_string($username);
		$password = $database->escape_string($password);
		$sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
		$the_result_array = self::find_this_query($sql);
		return !empty($the_result_array)? array_shift($the_result_array) : false;
	}


	protected function properties() {
		$properties = array();

		foreach(self::$db_table_fields as $db_field) {
			if(property_exists($this, $db_field)) {
				$properties[$db_field] = $this->$db_field;
			}
		}
		return $properties;
	}


	protected function clean_properties() {
		global $database;
		$clean_properties = array();

		foreach ($this->properties() as $key => $value) {
			$clean_properties[$key] = $database->escape_string($value);
		}
		return $clean_properties;
	}


	public function create_user() {
		global $database;
		$properties = $this->clean_properties();

		$sql = "INSERT INTO " . self::$db_table . "(" . implode(",", array_keys($properties)) . ") ";
		$sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";

		if($database->query($sql)){
			$this->id = $database->the_insert_id();
			return true;
		}
		else{
			return false;
		}
		
	}


	public function update_user() {
		global $database;
		$properties = $this->clean_properties();
		$property_pairs = array();
		foreach ($properties as $key => $value) {
			$property_pairs[] = "{$key}= '{$value}'";
		}

		$sql = "UPDATE " . self::$db_table . " SET " . implode(", ", $property_pairs);
		$sql .= " WHERE id = " . $database->escape_string($this->id);

		$database->query($sql);
		return (mysqli_affected_rows($database->connection) == 1)? true : false;
	}


	public function save() {
		return isset($this->id) ? $this->update_user() : $this->create_user();
	}


	public function delete_user() {
		global $database;

		$sql = "DELETE FROM " . self::$db_table . " WHERE id = " . $database->escape_string($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1)? true : false;
	}




} // End of class






?>