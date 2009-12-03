<?php

/* Configuration settings for entire site */


$in_production = true;


// set level of php error reporting --  ONLY display errors
// (will hide ugly warnings if databse goes offline/is unreachable)
//error_reporting(E_ERROR);	// for production
error_reporting(E_ERROR | E_PARSE);    // for development


//root directory and url for wilson website
//development
$basedir = "/home/ahickco/public_html/oxfordexperience";
$server = "wilson.library.emory.edu";
$base_path = "/~ahickco/schanges/";
$base_url = "http://$server$base_path/";



// root directory and url where the website resides
// production version
/* $basedir = "/home/httpd/html/beck/southernchanges";
$server = "beck.library.emory.edu";
$base_path = "/southernchanges";
$base_url = "http://$server$base_path/";
*/

// add basedir to the php include path (for header/footer files and lib directory)
set_include_path(get_include_path() . ":" . $basedir . ":" . "$basedir/lib" . ":" . "$basedir/content");

//shorthand for link to main css file
$cssfile = "oxfexp.css";
$csslink = "<link rel='stylesheet' type='text/css' href='$base_url/$cssfile'>";


/* exist settings  */
if ($in_production) {
  $server = "bohr.library.emory.edu";           //production
} else {
  $server = "wilson.library.emory.edu";         // test
}

if($in_production) {
  $port = "7080";
 } else {
  $port = "8080";
 }
$db = "oxfordexperience";

$exist_args = array('host'   => $server,
	      	    'port'   => $port,
		    'db'     => $db,
		    'dbtype' => "exist");

// shortcut to include common tei xqueries
$teixq = 'import module namespace teixq="http://www.library.emory.edu/xquery/teixq" at
"xmldb:exist:///db/xquery-modules/tei.xqm"; '; 


?>
