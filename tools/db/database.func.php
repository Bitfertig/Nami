<?php

/**
 * 
 * 
 */
 
 
/**
 * Import SQL data.
 *
 * @param string $args as the queries of sql data , you could use file get contents to read data args
 * @param string/array $tables_whitelist 'all' = all tables; array('tbl1',...) = only listet tables
 * @param string $dbhost database host
 * @param string $dbuser database user
 * @param string $dbpass database password
 * @param string $dbname database name
 *
 * @return string complete if complete
 */
function database_import( $args, $tables_whitelist, $dbhost, $dbuser, $dbpass, $dbname ) {

	// check mysqli extension installed
	if ( !function_exists('mysqli_connect') ) {
		die('This scripts need mysql extension to be running properly! Please resolve!');
	}

	$mysqli = @new mysqli( $dbhost, $dbuser, $dbpass, $dbname );
	
	 if ( $mysqli->connect_error ) {
		print_r( $mysqli->connect_error );
		return false;
	}

	// DROP all tables (be carefull...)
	$mysqli->query('SET foreign_key_checks = 0');
	if ( $result = $mysqli->query("SHOW TABLES") ) {
	    while ( $row = $result->fetch_array(MYSQLI_NUM) ) {
	    	if ( $tables_whitelist=='all' || in_array($row[0], (array)$tables_whitelist) ) {
	        	$mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
	        }
	    }
	}
	$mysqli->query('SET foreign_key_checks = 1');


	$querycount = 11;
	$queryerrors = '';
	$lines = (array) $args;
	if ( is_string( $args ) ) {
		$lines =  array( $args ) ;
	}

	if ( ! $lines ) {
		return 'cannot execute ' . $args;
	}

	$scriptfile = false;
	foreach ($lines as $line) {
		$line = trim( $line );
		// if have -- comments add enters
		if (substr( $line, 0, 2 ) == '--') {
				$line = "\n" . $line;
		}
		if (substr( $line, 0, 2 ) != '--') {
			$scriptfile .= ' ' . $line;
			continue;
		}
	}

	$queries = explode( ';', $scriptfile );
	foreach ($queries as $query) {
		$query = trim( $query );
		++$querycount;

		if ( $query == '' ) {
			continue;
		}


		if ( ! $mysqli->query( $query ) ) {
			$queryerrors .= 'Line ' . $querycount . ' - ' . $mysqli->error . '<br />';
			continue;
		}
	}


	if ( $queryerrors ) {
		return 'There was an error on File: ' . $filename . '<br />' . $queryerrors;
	}
	
	if( $mysqli && ! $mysqli->error ) {
		@$mysqli->close();
	}   

	return 'Complete dumping database!';
}



/**
 * Export SQL data.
 *
 * if directory writable will be make directory inside of directory if not exist, else will be die
 *
 * @param string directory, as the directory to put file
 * @param string $outname as file name just the name
 * @param string/array $tables_whitelist 'all' = all tables; array('tbl1',...) = only listet tables
 * @param string $dbhost database host
 * @param string $dbuser database user
 * @param string $dbpass database password
 * @param string $dbname database name
 *
 */
function database_backup( $directory, $outname, $tables_whitelist, $dbhost, $dbuser, $dbpass, $dbname ) {
	
	// check mysqli extension installed
	if ( !function_exists('mysqli_connect') ) {
		die('This scripts need mysql extension to be running properly! Please resolve!');
	}

	$mysqli = @new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	
	if ( $mysqli->connect_error ) {
		print_r( $mysqli->connect_error );
		return false;
	}

	$dir = $directory;
	$result = '<p>Could not create backup directory on :'.$dir.' Please Please make sure you have set Directory on 755 or 777 for a while.</p>';  
	$res = true;
	if ( !is_dir( $dir ) ) {
		if( !@mkdir( $dir, 755 ) ) {
			$res = false;
		}
	}

	$n = 1;
	if ( $res ) {

		$name = $outname.'_'.date('Y-m-d-H-i-s');

		$fullname = $dir.'/'.$name.'.sql'; # full structures

		if ( !$mysqli->error ) {
			$sql = "SHOW TABLES";
			$show = $mysqli->query($sql);
			while ( $row = $show->fetch_array() ) {
				if ( $tables_whitelist=='all' || in_array($row[0], (array)$tables_whitelist) ) {
					$tables[] = $row[0];
				}
			}

			if ( !empty( $tables ) ) {

	// Cycle through
	$return = '';
	foreach ( $tables as $table )
	{
		$result     = $mysqli->query('SELECT * FROM '.$table);
		$num_fields = $result->field_count;
		$row2       = $mysqli->query('SHOW CREATE TABLE '.$table );

		$row2       = $row2->fetch_row();
		$return    .= 
"\n
-- ---------------------------------------------------------
--
-- Table structure for table : `{$table}`
--
-- ---------------------------------------------------------

".$row2[1].";\n";

		for ($i = 0; $i < $num_fields; $i++) 
		{

			$n = 1 ;
			while ( $row = $result->fetch_row() )
			{ 
				

				if ( $n++ == 1 ) { # set the first statements
					$return .= 
"
--
-- Dumping data for table `{$table}`
--

";  
				/**
				 * Get structural of fields each tables
				 */
				$array_field = array(); #reset ! important to resetting when loop 
				while ( $field = $result->fetch_field() ) # get field
				{
					$array_field[] = '`'.$field->name.'`';
					
				}
				$array_f[$table] = $array_field;
				// $array_f = $array_f;
				# endwhile
				$array_field = implode(', ', $array_f[$table]); #implode arrays

					$return .= "INSERT INTO `{$table}` ({$array_field}) VALUES\n(";
				} else {
					$return .= '(';
				}
				for ($j=0; $j<$num_fields; $j++) 
				{
					
					$row[$j] = str_replace('\'','\'\'', preg_replace("/\n/","\\n", $row[$j] ) );
					if ( isset( $row[$j] ) ) { $return .= is_numeric( $row[$j] ) ? $row[$j] : '\''.$row[$j].'\'' ; } else { $return.= '\'\''; }
					if ( $j<($num_fields-1) ) { $return.= ', '; }
				}
					$return.= "),\n";
			}
			# check matching
			@preg_match("/\),\n/", $return, $match, false, -3); # check match
			if ( isset( $match[0] ) )
			{
				$return = substr_replace( $return, ";\n", -2);
			}

		}
		
			$return .= "\n";

	}

$return = 
"-- ---------------------------------------------------------
--
-- Simple SQL Dump
-- 
--
-- Host Connection Info: ".$mysqli->host_info."
-- Generation Time: ".date('F d, Y \a\t H:i A ( e )')."
-- Server version: ".$mysqli->server_info."
-- PHP Version: ".PHP_VERSION."
--
-- ---------------------------------------------------------\n\n

SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
".$return."
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

# end values result


				if( @file_put_contents( $fullname, $return ) ) { # 9 as compression levels
				
					$result = $name.'.sql'; # show the name
				
				} else {
					$result = '<p>Error when saving the export.</p>';
				}

			} else {

				$result = '<p>Error when executing database query to export.</p>'.$mysqli->error;
			 
			}
		}

	} else {
		$result = '<p>Wrong mysqli input</p>';
	}
 
	if( $mysqli && ! $mysqli->error ) {
		@$mysqli->close();
	}

	return $result;

}