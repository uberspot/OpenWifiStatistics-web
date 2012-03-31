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
    <script src="js/markerclusterer.js"></script>
    <style type="text/css">body{height:100%;padding:0}#map_canvas{height:100%}</style>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key='.$GLOBALS['googlemapapikey'].'&amp;sensor=false"></script>
    <script type="text/javascript">
      function initialize() {
        var myOptions = {
          center: new google.maps.LatLng(37.98, 23.73),
          zoom: 13,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
		var markers = [];';
     $latitude = 0;
     $longtitude = 0;
     foreach($results->getResults(8) as $result) {
		 $script .= '
        markers.push(marker = new google.maps.Marker({
	position: new google.maps.LatLng('.$result->getLatitude().', '.$result->getLongitude().'), 
        title:"<strong>'.$result->getSsid().'</strong> Power:'.$result->getLevel().' Security:'.$result->getCapabilities().'"
		}));
		
		attachMessage(marker);
		';
	}
	$script .= '
		var markerClusterer = new MarkerClusterer(map, markers);
		// Listen for a cluster to be clicked
		google.maps.event.addListener(markerClusterer, \'clusterclick\', function(cluster) {
			var content = \'\';

			// Convert lat/long from cluster object to a usable MVCObject
			var info = new google.maps.MVCObject;
			info.set(\'position\', cluster.center_);

			//Get markers
			var markers = cluster.getMarkers();

			var content = "";
			//Get all the titles + content
			for(var i = 0; i < markers.length; i++) {
				content += markers[i].getTitle()+"<br/>";
			}

			var infowindow = new google.maps.InfoWindow();
			infowindow.close();
			infowindow.setContent(content); //set infowindow content to titles
			infowindow.open(map, info);

		});
		
		function attachMessage(marker) {
		  var message = ["This","is","the","secret","message"];
		  var infowindow = new google.maps.InfoWindow(
			  { content: marker.getTitle(),
				size: new google.maps.Size(50,50)
			  });
		  google.maps.event.addListener(marker, \'click\', function() {
			infowindow.open(map,marker);
		  });
		}
			
		  }
    </script>';
    
    $script = JSMin::minify($script);
	
    $out = Template::header("Map",$script);
    $out .= '<div id="map">
		<div id="map_canvas" style="width:100%; height:100%"></div>
	     </div>
             <script type="text/javascript">initialize()</script>';

    $out .= Template::footer();
    
    $file = fopen($cache,'w');
    fwrite($file,$out);
    fclose($file);
    echo file_get_contents($cache);
?>
