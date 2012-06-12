<html>
<head>
<title>Classifier Results</title>
</head>
<body>
<h2><center>Results of Ratings</h2>
<br/>
<?php
	include_once("db_accessor.php");

	# call bash script to log the data before classification
	$output = shell_exec('./bash_scripts/log_data_version.sh');
#	echo "<h2><center> $output </h2>";

	# generate unique random number for associated test files
	$random_suffix = rand() . "." . rand() . "." . rand();
	# putenv("VAR1=$random_suffix);
	# system("/home/ashpjin/public_html/classify/bash_scripts/compare_classifiers.sh");

	$num_tweets_to_classify = 10;

	$accessor = new db_accessor('localhost', 'root', 'adam17', 'twitter');
    $tweet_array = $accessor->get_random_tweets($num_tweets_to_classify);
	
	# store the random tweets in a text file for classification purposes
	$test_data_filename = "/home/ashpjin/public_html/classify/text_files/user/datafiles/test_data_$random_suffix.txt";
	$fwriter = fopen($test_data_filename, "c");
	for($index = 0; $index < $num_tweets_to_classify; $index++){
		fwrite($fwriter, $tweet_array[$index] . "\n");
	}

## write messages to random temp file for classification?	

	echo "<table border='1' align='center' cellpadding='10px'>
		<tr>
		 	<th align='center'>Index</th>
			<th width='400px'>Message</th>
			<th width='100px'>Classification based on your rating</th>
			<th width='100px'>Classification based on all users</th>
		</tr>";

	for($index = 0; $index < $num_tweets_to_classify; $index++){
		echo "<tr>";
		echo "<td align='center'>" . ($index + 1) . "</td>";
		echo "<td>" . $tweet_array[$index] . "</td>";
        echo "<td align='center'><img src='images/green_checkmark.png' alt='Relevant' width='25' height='25' /></td>";
		echo "<td align='center'><img src='images/red_x.png' alt='Irrelevant' width='25' height='25'/></td>";
	    echo "</tr>";
	}
	echo "</table>";
?>
</body>
