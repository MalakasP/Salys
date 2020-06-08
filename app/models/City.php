<?php

class City {
	
	private $city_table = '';
	
	public function __construct() {
		$this->city_table = config::DB_PREFIX . 'city';
	}
	
	public function getCity($id) {
		$query = "  SELECT *
					FROM {$this->city_table}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	public function getCountryCityList($limit = null, $offset = null, $country, $order, $search = null, $from = null, $to = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}

		$searchFor = "";
		if(isset($search)){
			$searchFor .= "AND `name` LIKE '{$search}'";
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
				$searchFor .= "AND `timestamp` >= '{$from}'";
				if(isset($to)){
					$searchFor .= "AND '{$to}' >= `timestamp`";
				}
			} else if (isset($to)){
				$searchFor .= "AND '{$to}' >= `timestamp`";
			}
		}
		
		$query = "  SELECT *
					FROM {$this->city_table}
					WHERE `fk_country` ='{$country}'
					{$searchFor}
					ORDER BY `name` {$order}
					{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	/**
	 * City quantity 
	 * @return type
	 */
	public function getCountryCityListCount($country, $search = null, $from = null, $to = null) {
		$searchFor = "";
		if(isset($search)){
			$searchFor .= "AND `name` LIKE '{$search}'";
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
				$searchFor .= "AND `timestamp` >= '{$from}'";
				if(isset($to)){
					$searchFor .= "AND '{$to}' >= `timestamp`";
				}
			} else if (isset($to)){
				$searchFor .= "AND '{$to}' >= `timestamp`";
			}
		}

		$query = "  SELECT COUNT(`id`) as `count`
					FROM {$this->city_table}
					WHERE `fk_country` ='{$country}'
					{$searchFor}";
		$data = mysql::select($query);
		
		return $data[0]['count'];
	}
	
	/**
	 * City insertion
	 * @param type $data
	 */
	public function insertCity($data) {
		$query = "  INSERT INTO {$this->city_table}
                                (
                                    `name`,
                                    `area`,
                                    `population`,
                                    `postal_code`,
									`timestamp`,
                                    `fk_country`
                                )
                                VALUES
                                (
                                    '{$data['name']}',
                                    '{$data['area']}',
                                    '{$data['population']}',
                                    '{$data['postal_code']}',
									CURRENT_DATE,
                                    '{$data['country']}'
								)";
		$data = mysql::query($query);
		return $data;
	}
	
	/**
	 * City update
	 * @param type $data
	 */
	public function updateCity($data) {
		$query = "  UPDATE {$this->city_table}
                    SET     `area`='{$data['area']}',
                            `population`='{$data['population']}',
                            `postal_code`='{$data['postal_code']}',
							`timestamp`= CURRENT_DATE
					WHERE   `id`='{$data['id']}'";
		mysql::query($query);
	}
	
	/**
	 * City delete
	 * @param type $id
	 */
	public function deleteCity($id) {
		$query = "  DELETE FROM {$this->city_table}
					WHERE `id`='{$id}'";
					
		mysql::query($query);
	}

	/**
	 * Delete country's cities
	 * @param type $id
	 */
	public function deleteCountryCities($country) {
		$query = "  DELETE FROM {$this->city_table}
					WHERE `fk_country`='{$country}'";
					
		mysql::query($query);
	}
	
	/**
	 * Get Auto Increment of city table
	 */
	public function getAutoIncrement() {
		$query = " 	SELECT `AUTO_INCREMENT`
					FROM  INFORMATION_SCHEMA.TABLES
					WHERE TABLE_SCHEMA = 'salys'
					AND   TABLE_NAME   = '{$this->city_table}'";
		$result = mysql::query($query);
		return $result;
	}

	/**
	 * Set Auto Increment of city table
	 */
	public function setAutoIncrement($autoIncrement) {
		$query = " ALTER TABLE {$this->city_table} AUTO_INCREMENT = {$autoIncrement}";
		mysql::query($query);
	}
}