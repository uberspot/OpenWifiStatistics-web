<?php

	function sanitizeString($word){
   		$word = filter_var(filter_var( trim($word) , FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW), FILTER_SANITIZE_MAGIC_QUOTES) ;
    		if ((strpos($word,'|')>0) || (strpos($word,'\\')>0) || (strpos($word,'/')>0)
           		|| (strpos($word,'>')>0) || (strpos($word,'<')>0) || (strpos($word,'\"')>0)|| (strpos($word,'\'')>0)|| (strpos($word,'`')>0)
           		|| (strpos($word,'~')>0) || (strpos($word,'$')>0) || (strpos($word,'\"')>0)
           		|| (strpos($word,'\'')>0)|| (strpos($word,'`')>0)) {
			$word = "";
		}
		return $word;
	}
	require_once('statsModel.php');
	require_once('statModel.php');


	if(isset($_GET['longtitude']) && isset($_GET['latitude'])) {
		$long = sanitizeString($_GET['longtitude']);
		$lat = sanitizeString($_GET['latitude']);
		
		if(empty($long) || empty($lat)) { 
			echo "Invalid parameters!";
			exit; 
		}

		$km = 50*0.005;
		
		$results = new statsModel();
		
		echo "bssid,ssid,security,latitude,longitude\n";
		foreach($results->getResultsByLocation($long,$lat,$km) as $result) {
			echo $result->getBssid().','.$result->getSsid().','.$result->getCapabilities().','.$result->getLongitude().','.$result->getLatitude()."\n";
		}		
	} else {
		echo "No parameters set!";
	}
?>
