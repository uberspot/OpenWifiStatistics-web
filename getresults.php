<?php

require_once('statsModel.php');
require_once('statModel.php');

if(isset($_GET['order']) && isset($_GET['from']) && isset($_GET['count'])) {

	$order = $_GET['order'];
	$from = $_GET['from'];
	$count = $_GET['count'];
	
	$results = new statsModel();
	
	echo '{"results":[';
	foreach($results->getResults($order,$from,$count) as $result) {
		echo '{"date":"'.$result->getTime().'","bssid":"'.
				$result->getBssid().'","ssid":"'.
				$result->getSsid().'","capabilities":"'.
				$result->getCapabilities().'","frequency":"'.
				$result->getFrequency().'","power":"'.
				$result->getLevel().'","provider":"'.$result->getProvider().'"},';
	}
	echo ']}';
} else {
	echo 'ERROR';
}

?>
