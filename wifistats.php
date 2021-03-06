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

require_once('configuration.php');

if(isset($_POST['submit'])) {
    $BSSID = sanitizeString($_POST['bssid']);
    $SSID = sanitizeString($_POST['ssid']);
    $capabilities = sanitizeString($_POST['capabilities']);
    $frequency = sanitizeString($_POST['frequency']);
    $level = sanitizeString($_POST['level']);
    $provider = sanitizeString($_POST['provider']);
    $latitude = sanitizeString($_POST['latitude']);
    $longitude = sanitizeString($_POST['longitude']);

    if( empty($BSSID) || empty($frequency) 
        || empty($level) || empty($latitude) || empty($longitude)) 
        { exit; }
    if( empty($capabilities) ) {
        $capabilities = "[open]";
    }
    
    if(isset($GLOBALS['password']))
			mysql_connect($GLOBALS['host'], $GLOBALS['user'], $GLOBALS['password']);
		else
			mysql_connect($GLOBALS['host'], $GLOBALS['user']);

    mysql_select_db($GLOBALS['database'] ) or die("Unable to select database");

    mysql_query("INSERT INTO `scan_results` (`bssid`,`ssid`,`capabilities`,`frequency`,`level`,`provider`,`latitude`,`longitude`) VALUES 
                                        ('$BSSID','$SSID','$capabilities','$frequency','$level','$provider','$latitude','$longitude')");
    mysql_close();
}
?>
