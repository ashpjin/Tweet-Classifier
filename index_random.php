<?php
	include_once('db_accessor.php');
	
	$num_tweets_to_classify = 10;
	$msg = "";
	$msg_array_name = "msg_array";

	$user_datapath = "/home/ashpjin/public_html/classify/text_files/user/";
	
	// WHAT TO DO IF NOT SUBMITTED YET
	if($_POST['Submitted'] != 'Submit'){
		$accessor = new db_accessor('localhost', 'root', 'adam17', 'twitter');
		$tweet_array = $accessor->get_random_tweets($num_tweets_to_classify);
	}
	// WHAT TO DO AFTER SUBMISSION
	else if($_POST['Submitted'] == "Submit")
	{

//testing purposes		
//$msg = "hello submitted";
//print_r($_POST);
		$errorMessage = "";
		$tweet_class_array = array();

		$index = 1;

		// check to make sure all the tweets were classified
		while($index <= $num_tweets_to_classify){
	
			$current_classification = "classification" . $index;
			
			if(empty($_POST[$current_classification])){
				$errorMessage .= $current_classification . ":" . " One or more of the tweets are unclassified!";
				break;
			} else {
				$tweet_class_array[$index] = $_POST[$current_classification];
			}
			$index += 1;
		}
		// if there were no errors (i.e. missing classifications in the form)	
		if(empty($errorMessage)) 
		{
			# create unique identifier for this particular user's data
			$random_suffix="";
			$user_rev_filename = "";
			do{
				$random_suffix = rand() . "." . rand() . "." . rand();
				$user_rev_filename = $user_datapath . "relevant/relevant_$random_suffix.txt";
			} while(file_exists($user_rev_filename));

			$user_irrev_filename = $user_datapath . "irrelevant/irrelevant_$random_suffix.txt";

			$user_rev = fopen($user_rev_filename, "c");
			$user_irrev = fopen($user_irrev_filename, "c");
			
			$fs_rev = fopen("text_files/relevant_tweets.txt","a");
			$fs_irrev = fopen("text_files/irrelevant_tweets.txt","a");
			$fs_inapp = fopen("text_files/inappropriate_tweets.txt","a");
			
			//fwrite($fs,$varName . ", " . $varMovie . "\n");
			$index = 1;
			$msg_array = $_POST[$msg_array_name];
			while($index <= $num_tweets_to_classify){
				$tweet_class = $tweet_class_array[$index];
				$current_tweet = $msg_array[$index];
			    
				switch($tweet_class){
					case "R":
						fwrite($fs_rev, $current_tweet . ",\n");
						fwrite($user_rev, $current_tweet . "\n");
						break;
					case "I":
					    fwrite($fs_irrev, $current_tweet . ",\n");
						fwrite($user_irrev, $current_tweet . "\n");
					    break;
					case "IA":
						fwrite($fs_inapp, $current_tweet . ",\n");
						break;
				}
				$index += 1;
			}

 			fclose($fs_rev);
  			fclose($fs_irrev);
   			fclose($fs_inapp);

			fclose($user_rev);
			fclose($user_irrev);

			header("Location: thankyou2.html");
			exit;
		}	
	}

?>
<html>
<head>
<title>Manual (Random) Tweet Classifier</title>
</head>
<body>
<h2><center>Classify Random Tweets</h2>
<br/>
<?php
	if(!empty($msg)){
		echo $msg;
	}
	if(!empty($errorMessage)){
		echo $errorMessage;
	}
?>
<br/>
<?php
	if($_POST['Submitted'] != 'Submit'){
		echo "<form name='classify_tweets' method='POST' action='index_random.php'><table border='1' align='center' cellpadding='10px'>
		<tr>
		<th>Index</th>
		<th width='400px'>Message Text</th>
		<th width='100px'>Relevant</th>
		<th width='100px'>Irrelevant</th>
		<th width='100px'>Inappropriate</th>
		<th width='100px'>I can't tell</th>
		</tr>";
	
		$index = 1;
		while($index <= $num_tweets_to_classify){
			$classification_name = "classification" . $index;
        	echo "<tr>";
        	echo "<td>" . $index . "</td>";
        	echo "<td>" . $tweet_array[($index - 1)] . "</td>";

        	echo "<td align='center'><input type='radio' name='" . $classification_name . "' value='R'></td>";
			echo "<td align='center'><input type='radio' name='" . $classification_name . "' value='I'></td>";
			echo "<td align='center'><input type='radio' name='" . $classification_name . "' value='IA'></td>";
			echo "<td align='center'><input type='radio' name='" . $classification_name . "' value='LANG'></td>";
			echo "</tr>";

			echo "<input type='hidden' name='msg_array[" . $index . "]' value='" . htmlspecialchars($tweet_array[($index - 1)], ENT_QUOTES) . "'>";

			$index = $index + 1;
		}
		echo "</table><br>";  
/*
	echo "<input type='radio' name='classification1' value='R'>";
	echo "<input type='radio' name='classification1' value='I'>";
	echo "<input type='radio' name='classification1' value='IA'>"; */
		echo "<center><input type='submit' width='100px' name='Submitted' value='Submit'/></form>";
	}
?>
<br/>
</body>
</html>
