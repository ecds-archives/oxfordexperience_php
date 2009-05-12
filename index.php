<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

$id = $_GET["id"];

$exist_args{"debug"} = false;
$xmldb = new xmlDbConnection($exist_args);

html_head("Browse", true);

include("web/xml/browse-head.xml");

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

$query = 'declare namespace tei="http://www.tei-c.org/ns/1.0";
for $a in /tei:TEI
order by $a//tei:title/tei:date/@when
return 
<result>
{$a/@xml:id}
{$a/tei:teiHeader//tei:titleStmt/tei:title}
    {$a/tei:teiHeader//tei:titleStmt/tei:author/tei:name//tei:sic}
</result>';

$xsl_file = "xslt/browse.xsl";
//$xsl_params = array('mode' => "flat", "vol" => $vol);

$maxdisplay = "110"; //show all the issues
$position = "1"; //start here

// run the query 
$xmldb->xquery($query, $position, $maxdisplay);
$xmldb->xslTransform($xsl_file, $xsl_params);
$xmldb->printResult();




include("web/xml/footer.xml");
?> 
   
</div>
   



</body>
</html>
