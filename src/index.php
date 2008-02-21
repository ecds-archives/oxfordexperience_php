<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$id = $_GET["id"];

$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);

html_head("Browse", true);

include("xml/browse-head.xml");

print '<div class="content">';

print '<h2>Oxford Experience Documents</h2>';

// query for all volumes -- eXist
/*$query = 'for $b in /TEI.2//div1
order by ($b/p/date/@value)
return
<result>
{$b/@id}
{$b/head}
<docdate>
{$b/p/date/@value}
</docdate>
</result>';*/

$query = 'for $a in /TEI.2/teiHeader
return 
<result>
{$a/../@id}
{$a//titleStmt/title}
{$a//titleStmt/author/name}
</result>';

$xsl_file = "browse.xsl";
$xsl_params = array('mode' => "flat", "vol" => $vol);

$maxdisplay = "110"; //show all the issues
$position = "1"; //start here

// run the query 
$xmldb->xquery($query, $position, $maxdisplay);
$xmldb->xslTransform($xsl_file, $xsl_params);
$xmldb->printResult();




include("xml/footer.xml");
?> 
   
</div>
   



</body>
</html>
