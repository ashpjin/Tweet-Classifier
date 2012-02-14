<?php
class db_accessor{

    //connection information
    private $database;      // twitter
    private $username;      // root
    private $password;      // adam17
    private $host;          // localhost
	
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
}
?>
