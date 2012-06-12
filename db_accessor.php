<?php
class db_accessor{

    //connection information
    private $database;      // twitter
    private $username;      
    private $password;     
    private $host;         
	
	//keep the index
	private $index;

    // db connection
    private $conn;

    // open the db connection
    public function __construct($sethost, $setuser, $setpass, $setdatabase){

        $this->host = $sethost;
        $this->username = $setuser;
        $this->password = $setpass;
        $this->database = $setdatabase;

        $this->conn = mysql_connect($this->host, $this->username, $this->password)
            or die('ERROR: Could not connect to host: ' . mysql_error());

         mysql_select_db($this->database)
            or die ('ERROR: Could not enter database.');
    }

    // close the db connection
    public function __destruct() {
        mysql_close($this->conn);
    }

	//get a tweet
	public function get_tweets($limit){
		$query = "SELECT message_text_clean FROM search_result ORDER BY created DESC LIMIT " . $limit . ";";
		$res = mysql_query($query);

		if(!$res){
			echo "ERROR (QUERY): " . mysql_error() . "\n";
			return false;
		}
		else {
			return $res;
		}
	}

	//gets random tweets; return array of message_text_clean(s)
	public function get_random_tweets($limit){
		$random_ids = $this->get_id_range($limit);
		$tweet_array = array();

		for($index = 0; $index < $limit; $index++){
			$query = "SELECT message_text_clean AS message FROM search_result WHERE id >= " . $random_ids[$index] . " LIMIT 0,1;";
        	$res = mysql_query($query);

			if(!$res){
				echo "ERROR (QUERY): " . mysql_error() . "\n";
				return false;
			}
			else {
		    	$tweet_array[$index] = mysql_fetch_object($res)->message;
			}
		}
		return $tweet_array;
	}

	//gets max and min id # from table
	public function get_id_range($limit){
		$range_result = mysql_query("SELECT MAX(id) AS max_id , MIN(id) AS min_id FROM search_result");
		$range_row = mysql_fetch_object($range_result);
		$random_ids = array();
		
		// echo "min = " . $range_row->min_id . ", max = " . $range_row->max_id . "\n";
		while(sizeof($random_ids) != $limit){
			for($index = sizeof($random_ids); $index < $limit; $index++){
				$random_ids[$index] = mt_rand($range_row->min_id , $range_row->max_id);
			}
			$random_ids = array_unique($random_ids);
		}
		return $random_ids;
		
		//$result = mysql_query( " SELECT * FROM search_result WHERE id >= $random LIMIT 0,1");
	}
}
?>
