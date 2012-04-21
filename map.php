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
			var markerclusterer;
			$("#map").goMap({
				markers: [';
				 $g = '';
				 $i = '';
				 foreach($results->getResults(8,-1,0) as $result) {
					 switch($result->getCapabilities()) {
						 case "[open]": $g = 'g1';$i='1.png';break;
						 case "[WEP]":  $g = 'g2';$i='2.png';break;
						 default: $g = 'g3';$i='3.png';break;
					 }
					 $script .= '{latitude:'.$result->getLatitude()
							.',longitude:'.$result->getLongitude()
							.',title:\''.$result->getSsid().'\',group:\''.$g.'\',icon:\'img/'.$i.'\'},';
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

				markerclusterer = new MarkerClusterer($.goMap.map, markers);
			});	
			$("#group").change(function() {
				var group = $(this).val();
				
				var markers = [];

				for (var i in $.goMap.markers) {
					
					var temp = $($.goMap.mapId).data($.goMap.markers[i]);
					
					if(temp.group == group || group == \'all\') {
						markers.push(temp);
					}
				}
				markerclusterer.clearMarkers();
				markerclusterer = new MarkerClusterer($.goMap.map, markers);
			});
		});
		
    </script>';
    
    //$script = JSMin::minify($script);
	
    $out = Template::header("Map",$script);
    $out .= '<div id="map-box"><div id="map"></div></div>';
    $out .= '<select id="group">
			<option value="all">Show all wifi spots</option>
			<option value="g1">Show only open</option>
			<option value="g2">Show only wep</option>
			<option value="g3">Show only the rest</option>
			</select>';

    $out .= Template::footer();
    
    $file = fopen($cache,'w');
    fwrite($file,$out);
    fclose($file);
    echo file_get_contents($cache);
?>
