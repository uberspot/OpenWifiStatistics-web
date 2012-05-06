<?php

	require_once('statsModel.php');
	require_once('statModel.php');


	if(isset($_GET['longtitude']) && isset($_GET['latitude'])) {
		$long = $_GET['longtitude'];
		$lat = $_GET['latitude'];
		
		$km = 50;
		$km = $km*0.005;
		
		$results = new statsModel();
		
		$first = true;
		foreach($results->getResultsByLocation($long,$lat,$km) as $result) {
			if(!$first)
				echo ',';
			else
				$first = false;
			echo $result->getSsid().','.$result->getLongitude().','.$result->getLatitude();
		}		
	} else {
		echo "ERROR";
	}
?>
