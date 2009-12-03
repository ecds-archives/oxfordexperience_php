<?php

include_once("config.php");
include_once("lib/xmlDbConnection.class.php");
include("common_functions.php");

html_head("Overview", true);

include("web/xml/browse-head.xml");

print '<div class="content">';

print '<h2>About the Oxford Experience</h2>';

include("web/xml/about.xml");

include("web/xml/srstory.xml");

include("web/xml/footer.xml");

print "</div>";

include("web/xml/google-trackoxex.xml");
?>
</body>
</html>