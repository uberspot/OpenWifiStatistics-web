<?php
require_once('statsModel.php');
require_once('statModel.php');

if(isset($_GET['type'])) {
	echo "lat	lo	description".PHP_EOL;
	$wifis = new statsModel();
	switch($_GET['type']) {
		case "open":
			$results = $wifis->getResults(8,-1,0,"`capabilities`='[open]'");
			break;
		case "wep":
			$results = $wifis->getResults(8,-1,0,"`capabilities`='[WEP]'");
			break;
		case "other":
			$results = $wifis->getResults(8,-1,0,"`capabilities`<>'[open]' AND `capabilities`<>'[WEP]'");
			break;
	}
	foreach($results as $result) {
		echo $result->getLatitude().'	'.$result->getLongitude().'	'.$result->getSsid().PHP_EOL;
    }
}

?>
