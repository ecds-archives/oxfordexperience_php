<?php
include_once("config.php");
include_once("lib/xmlDbConnection.class.php");

$exist_args{"debug"} = true;

$db = new xmlDbConnection($exist_args);

global $title;
global $abbrev;
global $collection;


$kw = $_REQUEST["keyword"];
$doctitle = $_REQUEST["doctitle"];
$auth = $_REQUEST["author"];
$date = $_REQUEST["date"];
//$subj = $_REQUEST["subject"];


$pos = $_REQUEST["position"];
$max = $_REQUEST["max"];

if ($pos == '') $pos = 1;
if ($max == '') $max = 20;

$htmltitle = "The Oxford Experience";

$options = array();
if ($kw) 
  array_push($options, " &= \"$kw\"");
if ($doctitle)
  array_push($options, ".//div/head &= '$doctitle'");
if ($auth)
  array_push($options, "(.//div/byline/docAuthor/name &= '$auth' or .//div/byline/docAuthor/name/@reg &= '$auth')");
if ($date)
  array_push($options, "(.//div/docDate &= '$date' or .//div/docDate/@value &= '$date')");
/*if ($subj)
 array_push($options, ".//keywords/list/item &= '$subj'");*/ //add subj later

// there must be at least one search parameter for this to work
if (count($options)) {

  $searchfilter = "[.//div" . implode(" and ", $options) . "]"; 
  print("DEBUG: Searchfilter is $searchfilter");
  
  $query = "for \$a in /TEI.2$searchfilter
let \$t := \$a//titleStmt//title
let \$doc := \$a/@id
let \$auth := \$a//titleStmt//author/name
let \$date := \$a//sourceDesc//date
let \$matchcount := text:match-count(\$a)
order by \$matchcount descending
return <item>{\$a/@id}";
  if ($kw)	// only count matches for keyword searches
    $query .= "<hits>{\$matchcount}</hits>";
  $query .= "
  {\$t}
  <id>{\$doc}</id>
  {\$auth}
  {\$date}";
  /*  if ($subj)	// return subjects if included in search 
   $query .= "{for \$s in \$a//keywords/list/item return <subject>{string(\$s)}</subject>}";*/

  $query .= "</item>";
  $xsl = "exist-search.xsl";
  $xsl_params = array('mode' => "search", 'keyword' => $kw, 'doctitle' => $doctitle, 'auth' => $auth, 'date' => $date,  'max' => $max);
}


?>
<html>
 <head>
<title><?= $htmltitle ?> : Search Results</title>
    <link rel="stylesheet" type="text/css" href="oxfexp.css">
 <!--   <link rel="shortcut icon" href="ewwrp.ico" type="image/x-icon">
    <script src='<?= $baseurl ?>/projax/js/prototype.js' type='text/javascript'></script>
    <script src='<?= $baseurl ?>/projax/js/scriptaculous.js' type='text/javascript'></script> -->
</head>
<body>

<? include("xml/browse-head.xml") ?>


<div class="content">

<div class="title"><a href="index.html"><?= $title ?></a></div>

<?

// only execute the query if there are search terms
if (count($options)) {

$db->xquery($query, $pos, $max);


  print "<p><b>Search results for texts where:</b></p>
 <ul class='searchopts'>";
  if ($kw) 
    print "<li>document contains keywords '$kw'</li>";
  if ($doctitle)
    print "<li>title matches '$doctitle'</li>";
  if ($auth)
    print "<li>author matches '$auth'</li>";
  if ($date)
    print "<li>date matches '$date'</li>";
  if ($subj)
    print "<li>subject matches '$subj'</li>";
  
  
  print "</ul>";
  
  if ($db->count == 0) {
    print "<p><b>No matches found.</b>
You may want to broaden your search or consult the search tips for suggestions.</p>\n";
    include("searchform.php");
  }
  
  $db->xslTransform($xsl, $xsl_params);
  $db->printResult();
  
} else {
  // no search terms - handle gracefully  
  print "<p><b>Error!</b> No search terms specified.</p>";
}

?>


</div>	

</body></html>
