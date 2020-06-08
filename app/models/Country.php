<?php

class Country {
	
    private $country_table = '';
    private $city_table = '';
	
	public function __construct() {	
        $this->country_table = config::DB_PREFIX . 'country';
        $this->city_table = config::DB_PREFIX . 'city';
	}
	
	public function getCountry($id) {
		$query = "  SELECT *
					FROM {$this->country_table}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	public function getCountryList($limit = null, $offset = null, $order, $search = null, $from = null, $to = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}

		$searchFor = "";
		if(isset($search)){
			$searchFor .= "WHERE `name` LIKE '{$search}'";
			if(isset($from)){
				$searchFor .= "AND `timestamp` >= '{$from}'";
				if(isset($to)){
					$searchFor .= "AND '{$to}' >= `timestamp`";
				}
			} else if (isset($to)){
				$searchFor .= "AND '{$to}' >= `timestamp`";
			}
		} else {
			if(isset($from)){
				$searchFor .= "WHERE `timestamp` >= '{$from}'";
				if(isset($to)){
					$searchFor .= "AND '{$to}' >= `timestamp`";
				}
			} else if (isset($to)){
				$searchFor .= "WHERE '{$to}' >= `timestamp`";
			}
		}
		
		$query = "  SELECT *
					FROM {$this->country_table}
					{$searchFor}
					ORDER BY `name` {$order}
					{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	/**
	 * Countries quantity 
	 * @return type
	 */
	public function getCountryListCount($search = null, $from = null, $to = null) {
		$searchFor = "";
		if(isset($search)){
			$searchFor .= "WHERE `name` LIKE '{$search}'";
			if(isset($from)){
				$searchFor .= "AND `timestamp` >= '{$from}'";
				if(isset($to)){
					$searchFor .= "AND '{$to}' >= `timestamp`";
				}
			} else if (isset($to)){
				$searchFor .= "AND '{$to}' >= `timestamp`";
			}
		} else {
			if(isset($from)){
				$searchFor .= "WHERE `timestamp` >= '{$from}'";
				if(isset($to)){
					$searchFor .= "AND '{$to}' >= `timestamp`";
				}
			} else if (isset($to)){
				$searchFor .= "WHERE '{$to}' >= `timestamp`";
			}
		}

		$query = "  SELECT COUNT(`id`) as `quantity`
					FROM {$this->country_table}
					{$searchFor}";
		$data = mysql::select($query);
		
		return $data[0]['quantity'];
	}
	
	/**
	 * Country insertion
	 * @param type $data
	 */
	public function insertCountry($data) {
		$query = "  INSERT INTO {$this->country_table}
                                (
                                    `name`,
                                    `area`,
                                    `population`,
                                    `timestamp`
                                )
                                VALUES
                                (
                                    '{$data['name']}',
                                    '{$data['area']}',
                                    '{$data['population']}',
                                    CURRENT_DATE
                                )";
		$data = mysql::query($query);
		return $data;
	}
	
	/**
	 * Country update
	 * @param type $data
	 */
	public function updateCountry($data) {
		$query = "  UPDATE {$this->country_table}
                    SET     `area`='{$data['area']}',
                            `population`='{$data['population']}',
                            `timestamp`= CURRENT_DATE
					WHERE   `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * Country delete
	 * @param type $id
	 */
	public function deleteCountry($id) {
		$query = "  DELETE FROM {$this->country_table}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}

	/**
	 * Get Auto Increment of country table
	 */
	public function getAutoIncrement() {
		$query = " 	SELECT `AUTO_INCREMENT`
					FROM  INFORMATION_SCHEMA.TABLES
					WHERE TABLE_SCHEMA = 'salys'
					AND   TABLE_NAME   = '{$this->country_table}'";
		$result = mysql::query($query);
		return $result;
	}

	/**
	 * Set Auto Increment of country table
	 */
	public function setAutoIncrement($autoIncrement) {
		$query = " ALTER TABLE {$this->country_table} AUTO_INCREMENT = {$autoIncrement}";
		mysql::query($query);
	}
}