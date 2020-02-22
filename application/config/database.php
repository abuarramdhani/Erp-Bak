<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'postgres',
	'password' => 'password',
	'database' => 'erp',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 5432
);

$db['oracle'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.7.1:1521/PROD', //192.168.7.3:1522/DEV
	'username' => 'apps',
	'password' => 'apps',
	'database' => 'KHS_PROD',//KHS_DEV
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['personalia'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'postgres',
	'password' => 'password',
	'database' => 'Personalia',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 5432
);

$db['quickcom'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'erp',
	'password' => 'qu1ck1953',
	'database' => 'fp_distribusi',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 3306
);

$db['quick'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'erp',
	'password' => 'qu1ck1953',
	'database' => '',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 3306
);


$db['kaizen'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'erp',
	'password' => 'qu1ck1953',
	'database' => 'kaizen',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 3306
);

$db['ticket'] = array(
	'dsn'	=> '',
	'hostname' => 'ictsupport.quick.com',
	'username' => 'admin',
	'password' => '123456',
	'database' => 'ticket1',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['oracle_dev'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.7.3:1522/DEV',
	'username' => 'apps',
	'password' => 'apps',
	'database' => 'KHS_DEV',
	'dbdriver' => 'oci8',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['dpostgre'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'postgres',
	'password' => 'password',
	'database' => 'erp',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 5432
);

$db['tpb_sql'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'erp',
	'password' => 'qu1ck1953',
	'database' => 'quickc01_trackingpengirimanbarang',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	// 'port' => 5432
);


$db['dinas_luar'] = array(
	'dsn'	=> '',
	'hostname' => 'dl.quick.com',
	'username' => 'dl',
	'password' => 'qu1ck',
	'database' => 'quickc01_dinas_luar_online',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 3306
);

$db['daerah'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'root',
	'password' => 'password',
	'database' => 'db_daerah',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['erp_db'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'postgres',
	'password' => 'password',
	'database' => 'erp',
	'dbdriver' => 'postgre',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['spl_db'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'spl',
	'password' => '123321',
	'database' => 'splseksi',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => TRUE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['lantuma'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'erp',
	'password' => 'qu1ck1953',
	'database' => 'db_lantoolmaking',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	'port' => 3306
);

$db['khs_packing'] = array(
	'dsn'	=> '',
	'hostname' => 'database.quick.com',
	'username' => 'erp',
	'password' => 'qu1ck1953',
	'database' => 'khs_packing',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE,
	// 'port' => 5432
);

$efg="";
		$data = explode('.',$_SERVER['SERVER_NAME']);
		if (!empty($data[0])) {
			$efg = $data[0];
		}
		$dsn = 'mysql:dbname=fp_distribusi;host=database.quick.com';
		$user = 'erp';
		$password = 'qu1ck1953';

		try {
			$dbh = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$sql = "SELECT a.id_lokasi,a.lokasi,a.lokasi_kerja,b.host,b.user,b.pass,b.db FROM fp_distribusi.tb_lokasi AS a
					LEFT JOIN fp_distribusi.tb_mysql AS b ON a.id_lokasi=b.id_lokasi 
					WHERE a.status_ = '1'";

		$sth = $dbh->prepare($sql);
		$sth->execute(array($efg));
		$d_result= $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach( $d_result as $row ) {
			$db['my_'.$row['id_lokasi'].'']['hostname'] = ''.$row['host'].'';
			$db['my_'.$row['id_lokasi'].'']['username'] = ''.$row['user'].'';
			$db['my_'.$row['id_lokasi'].'']['password'] = ''.$row['pass'].'';
			$db['my_'.$row['id_lokasi'].'']['database'] = ''.$row['db'].'';
			$db['my_'.$row['id_lokasi'].'']['dbdriver'] = 'mysqli';
			$db['my_'.$row['id_lokasi'].'']['dbprefix'] = '';
			$db['my_'.$row['id_lokasi'].'']['pconnect'] = FALSE;
			$db['my_'.$row['id_lokasi'].'']['db_debug'] = FALSE;
			$db['my_'.$row['id_lokasi'].'']['cache_on'] = FALSE;
			$db['my_'.$row['id_lokasi'].'']['cachedir'] = '';
			$db['my_'.$row['id_lokasi'].'']['char_set'] = 'utf8';
			$db['my_'.$row['id_lokasi'].'']['dbcollat'] = 'utf8_general_ci';
			$db['my_'.$row['id_lokasi'].'']['swap_pre'] = '';
			$db['my_'.$row['id_lokasi'].'']['autoinit'] = TRUE;
			$db['my_'.$row['id_lokasi'].'']['stricton'] = FALSE;
			$db['my_'.$row['id_lokasi'].'']['encrypt'] = FALSE;
			$db['my_'.$row['id_lokasi'].'']['compress'] = FALSE;
			$db['my_'.$row['id_lokasi'].'']['failover'] = array();
			$db['my_'.$row['id_lokasi'].'']['save_queries'] = TRUE;
			$db['my_'.$row['id_lokasi'].'']['port'] = 3306;
			$db['my_'.$row['id_lokasi'].'']['options'] = array(PDO::ATTR_TIMEOUT => 5);
		}
		
		$efg="";
		$data = explode('.',$_SERVER['SERVER_NAME']);
		if (!empty($data[0])) {
			$efg = $data[0];
		}
		$dsn = 'mysql:dbname=fp_distribusi;host=database.quick.com';
		$user = 'erp';
		$password = 'qu1ck1953';

		try {
			$dbh = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}

		$sql = "SELECT a.id_lokasi,a.lokasi,a.lokasi_kerja,b.host,b.user,b.pass,b.db FROM fp_distribusi.tb_lokasi AS a
					LEFT JOIN fp_distribusi.tb_postgres AS b ON a.id_lokasi=b.id_lokasi 
					WHERE a.status_ = '1'";

		$sth = $dbh->prepare($sql);
		$sth->execute(array($efg));
		$d_result= $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach( $d_result as $row ) {
			$db['pg_'.$row['id_lokasi'].'']['hostname'] = ''.$row['host'].'';
			$db['pg_'.$row['id_lokasi'].'']['username'] = ''.$row['user'].'';
			$db['pg_'.$row['id_lokasi'].'']['password'] = ''.$row['pass'].'';
			$db['pg_'.$row['id_lokasi'].'']['database'] = ''.$row['db'].'';
			$db['pg_'.$row['id_lokasi'].'']['dbdriver'] = 'postgre';
			$db['pg_'.$row['id_lokasi'].'']['dbprefix'] = '';
			$db['pg_'.$row['id_lokasi'].'']['pconnect'] = FALSE;
			$db['pg_'.$row['id_lokasi'].'']['db_debug'] = FALSE;
			$db['pg_'.$row['id_lokasi'].'']['cache_on'] = FALSE;
			$db['pg_'.$row['id_lokasi'].'']['cachedir'] = '';
			$db['pg_'.$row['id_lokasi'].'']['char_set'] = 'utf8';
			$db['pg_'.$row['id_lokasi'].'']['dbcollat'] = 'utf8_general_ci';
			$db['pg_'.$row['id_lokasi'].'']['swap_pre'] = '';
			$db['pg_'.$row['id_lokasi'].'']['autoinit'] = TRUE;
			$db['pg_'.$row['id_lokasi'].'']['stricton'] = FALSE;
			$db['pg_'.$row['id_lokasi'].'']['encrypt'] = FALSE;
			$db['pg_'.$row['id_lokasi'].'']['compress'] = FALSE;
			$db['pg_'.$row['id_lokasi'].'']['failover'] = array();
			$db['pg_'.$row['id_lokasi'].'']['save_queries'] = TRUE;
			$db['pg_'.$row['id_lokasi'].'']['port'] = 5432;
			$db['pg_'.$row['id_lokasi'].'']['options'] = array(PDO::ATTR_TIMEOUT => 5);
		}
		
		$db['quickcom_orientasi'] = array(
			'dsn'				=> '',
			'hostname' 			=> 'database.quick.com',
			'username' 			=> 'erp',
			'password' 			=> 'qu1ck1953',
			'database' 			=> 'db_orientasi',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);
		$db['quickcom_hrd_khs'] = array(
			'dsn'				=> '',
			'hostname' 			=> 'database.quick.com',
			'username' 			=> 'erp',
			'password' 			=> 'qu1ck1953',
			'database' 			=> 'hrd_khs',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);

		$db['db_fingerspot'] = array(
			'dsn'				=> '',
			'hostname' 			=> '192.168.168.50',
			'username' 			=> 'root',
			'password' 			=> '123456',
			'database' 			=> 'fin_pro',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);
		$db['db_fingerspot_178'] = array(
			'dsn'				=> '',
			'hostname' 			=> '192.168.168.178',
			'username' 			=> 'root',
			'password' 			=> '123456',
			'database' 			=> 'fin_pro',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);
		$db['db_fingerspot_179'] = array(
			'dsn'				=> '',
			'hostname' 			=> '192.168.168.179',
			'username' 			=> 'root',
			'password' 			=> '123456',
			'database' 			=> 'fin_pro',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);
		$db['db_fingerspot_207'] = array(
			'dsn'				=> '',
			'hostname' 			=> '192.168.168.207',
			'username' 			=> 'root',
			'password' 			=> '123456',
			'database' 			=> 'fin_pro',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);
		$db['dl_153'] = array(
			'dsn'				=> '',
			'hostname' 			=> '192.168.168.142',
			'username' 			=> 'dl',
			'password' 			=> 'qu1ck',
			'database' 			=> 'quickc01_dinas_luar_online',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);
		$db['recruitment'] = array(
			'dsn'				=> '',
			'hostname' 			=> 'quick.co.id',
			'username' 			=> 'quickc01_r33cr11',
			'password' 			=> 'BuZpN^V1MzJH',
			'database' 			=> 'quickc01_r3cru1t',
			'dbdriver' 			=> 'mysqli',
			'dbprefix' 			=> '',
			'pconnect' 			=> FALSE,
			'db_debug' 			=> TRUE,
			'cache_on' 			=> FALSE,
			'cachedir' 			=> '',
			'char_set' 			=> 'utf8',
			'dbcollat' 			=> 'utf8_general_ci',
			'swap_pre' 			=> '',
			'encrypt' 			=> FALSE,
			'compress' 			=> FALSE,
			'stricton' 			=> FALSE,
			'failover' 			=> array(),
			'save_queries'		=> TRUE,
			'port' 				=> 3306
		);
		$db['sweeping'] = array(
			'dsn'	=> '',
        		'hostname' => 'database.quick.com',
                	'username' => 'sweep',
                	'password' => 'qu1ck1953',
                	'database' => 'sweeping_hw',
			'dbdriver' => 'mysqli',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => FALSE,
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => TRUE,
		);