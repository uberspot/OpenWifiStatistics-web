<?php

$cache = 'cache/map.html';
if(file_exists($cache)) {
	$fromcreation = date('U')-date ('U',filemtime($cache));
	//			hours	min		sec
	$time =    	1   *	30	*	60;//15min
	if($fromcreation < $time) {
		echo file_get_contents($cache);
		exit();
	}
}

require_once('statsModel.php');
require_once('statModel.php');
require_once('templates/template.php');
require_once('configuration.php');
require_once('jsmin.php');

    $results = new statsModel();

    /* Presentation */
	  	    
    $script = '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key='.$GLOBALS['googlemapapikey'].'&amp;sensor=false"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/jquery.gomap-1.3.2.min.js"></script>
    <script src="js/markerclusterer.js"></script>
    <style type="text/css">body{height:100%;padding:0px;overflow:hidden;}#map{height:100%;}</style>
    <script type="text/javascript">
		$(function() { 
			$("#map").goMap({
				markers: [';
				 foreach($results->getResults(8,-1,0) as $result) {
					 $script .= '{latitude:'.$result->getLatitude()
							.',longitude:'.$result->getLongitude().'},';
				 }
			$script .= '],
			mapTypeControl: false,
			maptype: \'ROADMAP\' 
			}); 		
			$.goMap.ready(function() {

				var markers = [];

				for (var i in $.goMap.markers) {
					var temp = $($.goMap.mapId).data($.goMap.markers[i]);
					markers.push(temp);
				}

				var markerclusterer = new MarkerClusterer($.goMap.map, markers);
			});
		});
		
    </script>';
    
    //$script = JSMin::minify($script);
	
    $out = Template::header("Map",$script);
    $out .= '<div id="map-box"><div id="map"></div></div>';

    $out .= Template::footer();
    
    $file = fopen($cache,'w');
    fwrite($file,$out);
    fclose($file);
    echo file_get_contents($cache);
?>
