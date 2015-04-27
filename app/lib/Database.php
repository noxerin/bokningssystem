<?php
	/**
	*	Database class
	*	
	*	This class handles all querys and connections to databases
	*
	*	@author Nxi Solutions
	*
	**/
	namespace NXI;
	use PDO;
	
	class Database{
		//Public variables
		public $latestQuery = null;
		public $affected = null;
		//Contains object of pdo
		public $pdo = null;
		
		function __construct($config){
			
			/*
			 *	Construct will take the entire config array to be used in this class,
			 *	now when creating a new obj just import your config variable as a param
			 *
			 */

			$addr 		= $config['mysql']['address'];
			$database 	= $config['mysql']['database'];
			$login 		= $config['mysql']['username'];
			$password 	= $config['mysql']['password'];

			$details = "mysql:host=$addr;dbname=$database;charset=utf8";
			$options  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");
			
			//Start making the object for pdo database
			try{
			
				$this->pdo = new PDO($details, $login, $password, $options);
								
			}catch(Exception $e){
				echo "I'm Sorry, Dave. I'm afraid I can't do that.";
				//echo $e;
			}
		}
		
		function __destruct(){
			$this->pdo = null;
		}
		
		/**
		*
		* 	Perform a single secure query
		*
		* 	Same as upper function except this is a sql-injection secured query
		*
		* 	IN: Statment and either array or up to 6 variables
		*	OUT: Bool
		*
		*	Usage: To use this function first send in statment as querySecured("SELECT * FROM users WHERE user_id = ?", $param)
		*		   and then values either as an array as this querySecured($statment, $array) or for smaller queries 
		*		   querySecured($statment, $param, $param2) for up to 6 values
		*
		*
		**/
		public function query($statement, $params=null, $params2=null, $params3=null, $params4=null, $params5=null, $params6=null){
		
			//Prepare sql-statment with ? at values
			$query = $this->pdo->prepare($statement);
			
			//If values are taken in and not array make array of them
			if(!is_array($params)){
				$tmparr = array(
					$params,
					$params2,
					$params3,
					$params4,
					$params5,
					$params6
				);
				$params = array();
				for($i = 0; $i < 5; $i++){
					if(strlen($tmparr[$i]) > 0){
						$params[$i] = $tmparr[$i];
					}
				}
			}
			
			//Execute query and send in array
			$query->execute($params);
			
			//Set latestQuery
			$this->latestQuery = $query->fetchAll(PDO::FETCH_ASSOC);
			//Set affected rows
			$this->affected = $query->rowCount();
						
			//Retrun if success
			if($this->countRow() != 0):
				return $this->latestQuery;
			else:
				return false;
			endif;
		}
		
		/**
		*	
		*	Count rows from last query
		*
		**/
		public function countRow(){
			return count($this->latestQuery);
		}
		
		/**
		*
		*	Returns affected rows
		*
		**/
		public function affectedRow(){
			return $this->affected;
		}
		
		/** 
		*
		* Xss clean 
		*
		**/
		public function xss_clean($data)
		{
			// Fix &entity\n;
			$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
			$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
			$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
			$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
			
			// Remove any attribute starting with "on" or xmlns
			$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
			
			// Remove javascript: and vbscript: protocols
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', 			'$1=$2nojavascript...', $data);
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
			$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
			
			// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
			$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
			
			// Remove namespaced elements (we do not need them)
			$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
			
			do
			{
				// Remove really unwanted tags
				$old_data = $data;
				$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
			}
			while ($old_data !== $data);
			
			// we are done...
			return $data;
		}

	}
?>