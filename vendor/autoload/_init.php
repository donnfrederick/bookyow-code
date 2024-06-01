<?php

class DB {
	public    $db;

	private   $host = 'localhost';
	private   $user = 'root';
	private   $password = '';
	private   $name = 'bookyow';

	private   $executionError;

	public function __construct() {
		$this->db = mysqli_connect($this->host ,$this->user ,$this->password, $this->name);
	}

	public function execute($query) {
		$result = [];
		if ($this->identifyQuery($query)) {
			$execution = mysqli_query($this->db, $query);
            
            if ($this->queryError()) {
            	return $this->executionError;
            }
            
            return 0;
		} else {
			$execution = mysqli_query($this->db, $query);

			if ($this->queryError()) {
            	return $this->executionError;
            }

            while($row = mysqli_fetch_array($execution)) array_push($result, $row);

            return $result;
		}
	}

	public function findAll($table) {
	    $query = "SELECT *
	              FROM $table
	              WHERE delete_flg = '0'
	              ORDER BY id;";
	    return $this->execute($query);
	}

	public function getExecutionError() {
		return $this->executionError;
	}

	private function identifyQuery($query) {
		if (strtok($query, " ") == 'SELECT') {
			return 0;
		} else {
			return 1;
		}
	}

	private function queryError() {
		if(mysqli_errno($this->db) != 0) {
            $this->executionError = mysqli_error($this->db);
            return 1;
        } else {
        	return 0;
        }
	}
}

$db = new DB();