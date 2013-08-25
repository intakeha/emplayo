#!/usr/bin/php
<?php

// SET THE FILE TO BE CONVERTED
$string = file_get_contents(dirname(__FILE__) . '/ref_tables.sql');

preg_match_all('/CREATE TABLE `(\w*)` \(\s(  `(\w*)` .*\s)*/', $string, $matches);

$matches_sql = $matches[0];
$php_code = '';
$drop_coe = '';
foreach ($matches_sql as $match) {
	preg_match_all('/`(\w*)` (\w*)/', $match, $names);
	
	$table_name = trim(str_replace('`', '', $names[0][0]));
	
	$drop_code .= '$'.'this->drop_table("'.$table_name.'");'."\n";
	
	$php_code .= "// $table_name\n";
	$php_code .= '$'.$table_name.' = $this->create_table("'.$table_name.'", array("id"=>false));' . "\n\n";
	
	$count = 0;
	foreach ($names[1] as $name) {
		if ($count == 0) {
			$count += 1;
			continue;
		}
		$name = str_replace('`', '', $name);
		$type = '';
		$options = null;
		
		
		
		switch($names[2][$count]) {
			case 'int':
				$type = 'integer';
				break;
			case 'tinyint':
				$type = 'tinyinteger';
				break;                            
			case 'mediumint':
				$type = 'smallinteger';
				break;                            
			case 'smallint':
				$type = 'smallinteger';
				break;
			case 'varchar':
				$type = 'string';
				break;
			case 'timestamp':
				$type = 'timestamp';
				$options = ", array('default' => 'CURRENT_TIMESTAMP')";
				break;
			case 'text':
				$type = 'text';
				break;
			case 'double':
				$type = 'integer';
				break;
			case 'float':
				$type = 'float';
				break;
			case 'decimal':
				$type = 'decimal';
				break;                            
			case 'tinyint':
				$type = 'boolean';
				break;
			case 'char':
				$type = 'string';
				break;
			case 'tinytext':
				$type = 'mediumtext';
				break;
			case 'binary':
				$type = 'binary';
				break;
			case 'datetime':
				$type = 'datetime';
				break;
			case 'date':
				$type = 'date';
				break;                            
			case 'bit':
				$type = 'boolean';
				break;
			default:
				exit('error!!! ' . $names[2][$count]);
		}
		
		if ($name == 'id' || $name == 'uid') {
			$options = ", array('primary_key' => true, 'auto_increment' => true, 'null' => false, 'unsigned' => true)";
		}
		$php_code .= '$'."$table_name".'->column("'.$name.'", "'.$type.'"'.$options.');'."\n";
		
		$count += 1;
		
	}
	$php_code .= "\n".'$'."$table_name".'->finish();'."\n\n";	
}

echo $php_code . "\n\n";
echo $drop_code;
