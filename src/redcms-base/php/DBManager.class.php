<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/
class DBManager extends PDO {
	
	/**
	 * FIXME litteral value instead of PDO::MYSQL_ATTR_INIT_COMMAND only to fix a bug in php 5.3 (or is it only in EasyPHP??)
	 * 
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 */
	function DBManager($dsn, $username, $password) {
		//parent::__construct($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
		parent::__construct($dsn, $username, $password, array(1002 => 'SET NAMES \'UTF8\''));
	}
	var $_queries = array();
	function prepare($statement, array $driver_options = null){
		$this->_queries[] = $statement;
		return parent::prepare($statement);
	}
	function query($statement){
		$this->_queries[] = $statement;
		return parent::query($statement);
	}
	
	/**
	 * FIXME only works for MYSQL tables
	 *  Backup the db or just some table
	 *
	 * Credits http://davidwalsh.name/backup-mysql-database-php
	 * Modifed to use PDO
	 * 
	 * @param $targetFileName string 
	 * @param $tables (array | string) 
	 * @return boolean true if process was completed successfully
	 */
	function exportTablesToFile($targetFileName, $tables = '*') {
		$return = '';
		//get all of the tables
		if($tables == '*') {
			$tables = array();
			$stmt = $this->query('SHOW TABLES');
			while($row = $stmt->fetch(PDO::FETCH_NUM)) {
				$tables[] = $row[0];
			}
		} else {
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}

		//cycle through
		foreach($tables as $table) {
			$return.= 'DROP TABLE IF EXISTS '.$table.";\n\n";
			
			$row2 = $this->query('SHOW CREATE TABLE '.$table)->fetch(PDO::FETCH_NUM);
			$return.= $row2[1].";\n\n";
			
			$result = $this->query('SELECT * FROM '.$table);
			$num_fields = $result->columnCount();
			for ($i = 0; $i < $num_fields; $i++) {
				while($row = $result->fetch(PDO::FETCH_NUM)) {
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++)
					{
						if (!isset($row[$j])) {
							$row[$j] = 'NULL';
						}else{
							$row[$j] = addslashes($row[$j]);
							$row[$j] =  '"'.str_replace("\n","\\n",$row[$j]).'"';
						}
						$return.= (isset($row[$j]))?$row[$j]:'""';
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n\n";
				}
			}
			$return.="\n\n\n";
		}

		//save file
		$handle = fopen($targetFileName,'w+');
		fwrite($handle,$return);
		fclose($handle);
		
		return true;
	}

	/**
	 * Credits: http://www.phpsources.org/scripts373-PHP.htm
	 *
	 * @param $filename
	 * @param $errmsg
	 * @return unknown_type
	 */
	function importFile($filename) {

		$return = false;
		$sql_start = array('INSERT', 'UPDATE', 'DELETE', 'DROP', 'GRANT', 'REVOKE', 'CREATE', 'ALTER');
		$sql_run_last = array('INSERT');

		if (file_exists($filename)) {
			$lines = file($filename);
			$queries = array();
			$query = '';

			if (is_array($lines)) {
				foreach ($lines as $line) {
					$line = trim($line);

					if(!preg_match("'^--'", $line)) {
						if (!trim($line)) {
							if ($query != '') {
								$first_word = trim(strtoupper(substr($query, 0, strpos($query, ' '))));
								if (in_array($first_word, $sql_start)) {
									$pos = strpos($query, '`')+1;
									$query = substr($query, 0, $pos) .  substr($query, $pos);
								}

								$priority = 1;
								if (in_array($first_word, $sql_run_last)) {
									$priority = 10;
								}

								$queries[$priority][] = $query;
								$query = '';
							}
						} else {
							$query .= $line;
						}
					}
				}

				ksort($queries);

				foreach ($queries as $priority=>$to_run) {
					foreach ($to_run as $i=>$sql) {
						try {
							$this->query($sql);
						}catch (Exception $e){
							//$redCMS = RedCMS::getInstance();
							//FIXME do the error logging here
							//$redCMS->logger->log('Error on importing query:'.$sql, 'error');
						}
					}
				}
			}
		}
	}
}
?>