<?php

require_once('templates/template.php');
echo Template::header("Index");
echo Template::contentStart();
?>
<h1>Open Wifi Statistics</h1>
<p>This is Open Wifi Statistics project Web Interface.</p>
<h2>Interesting Links</h2>
<p>
	<a href="https://github.com/uberspot/OpenWifiStatistics-web">Web Interface @ Github</a><br/>
	<a href="https://github.com/uberspot/OpenWifiStatistics">Android Client @ Github</a><br/>
	<a href="https://play.google.com/store/apps/details?id=com.ows.OpenWifiStatistics#?t=W251bGwsMSwxLDUwMSwiY29tLm93cy5PcGVuV2lmaVN0YXRpc3RpY3MiXQ..">Android Client @ Google Play</a><br/>
</p>

<?php
echo Template::contentEnd();
echo Template::footer();
?>
