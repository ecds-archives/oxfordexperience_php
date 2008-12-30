<?xml version="1.0" encoding="ISO-8859-1"?>  

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/REC-html40" 
	xmlns:xql="http://metalab.unc.edu/xql/"
	xmlns:exist="http://exist.sourceforge.net/NS/exist"
	exclude-result-prefixes="exist" version="1.0">


<xsl:param name="xml"/> <!-- value is xml if view source is chosen,
critical intro if intro is chosen -->

<xsl:output method="xml"/>

 <!-- view the xml source of the document -->
<xsl:template match="TEI.2">
  <xsl:element name="a">
    <xsl:attribute name="href">article.php?id=<xsl:value-of select="@id"/>
    Back to document</xsl:attribute>
  </xsl:element>
  <xsl:element name="pre">
    <xsl:apply-templates/>
  </xsl:element>
</xsl:template>



</xsl:stylesheet>
