<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" indent="yes"/>
	<xsl:template match="/*">
	
	<html>
		<head>
			<title>My webpage</title>
		</head>
		<body>
			<h1 style="background-color:#446600; color:#FFFFFF; 
			font-size: 20pt; text-align: center; letter-spacing: 1.0em"><xsl:value-of 
			select="name(.)"></xsl:value-of></h1>
			<table align="center" border="2">
			<thead>
			<tr>
			<xsl:apply-templates select="*[1]/@*"
			mode="th"/>
			<xsl:apply-templates select="*[1]/*" 
			mode="th"/>
			</tr>
			</thead>
			<tbody>
			<xsl:apply-templates select="*"/>
			</tbody>
			</table>
		</body>
	</html>

	</xsl:template>
		<xsl:template match="/*/*[1]/@*" mode="th">
			<th>
				<xsl:value-of select="concat(name(), '(a)')"/>
			</th>
		</xsl:template>
		<xsl:template match="/*/*/*" mode="th">
			<th>
				<xsl:value-of select="concat(name(), '(c)')"/>
			</th>
		</xsl:template>
		<xsl:template match="/*/*">
			<tr>
				<xsl:apply-templates select="@*"/>
				<xsl:apply-templates select="*"/>
			</tr>
		</xsl:template>
		<xsl:template match="/*/*/*">
			<td>
				<xsl:value-of select="."/>
			</td>
		</xsl:template>
		<xsl:template match="/*/*/@*">
			<td>
				<xsl:value-of select="."/>
			</td>
		</xsl:template>
</xsl:stylesheet>