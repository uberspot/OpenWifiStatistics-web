<?php
class Template {
	public static function header($title="",$script="") {
		
		if(!empty($title))
			$title = ' &bull; '.$title; 
		
		$head = <<<HEAD
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
		<title>Open Wifi Statistics$title</title>
		<script type="text/javascript">// <![CDATA[  
			var mobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
			var cssLink = document.createElement("link");
			cssLink.setAttribute("type", "text/css");
			cssLink.setAttribute("rel", "stylesheet");
			if(mobile) {  
				cssLink.setAttribute("href", "templates/handheld.css");
			} else {
				cssLink.setAttribute("href", "templates/style.css");
			}			
			document.head.appendChild(cssLink);
		// ]]></script> 
		$script
	</head>
	<body>
	<div id="menu">
		<img src="templates/Wifi_logo.png" alt="logo" height="60" />
		<a href="results.php" class="abox">Results</a>
		<a href="map.php" class="abox">Map</a>
		<a href="stats.php" class="abox">Stats</a>
	</div>
HEAD;
		return $head;
	}
	
	public static function footer() {
		$foot = <<<FOOT
	</body>
</html>
FOOT;
		return $foot;
	}

	public static function contentStart() {
		return "<div id='content'>";
	}
	
	public static function contentEnd() {
		return "</div>";
	}
	
}

?>
