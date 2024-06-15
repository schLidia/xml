<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:template match="/">
        <html>
            <head>
                <title>Lista hyperlink-uri</title>
                <style>
                    h1 {font-family: Arial, Univers, sans-serif; font-size: 36pt}
                </style>
            </head>
            <body>
                <xsl:apply-templates select="list" />
            </body>
        </html>
    </xsl:template>

    <xsl:template match="list">
        <ul>
            <xsl:apply-templates />
        </ul>
    </xsl:template>

    <xsl:template match="list/listitem">
        <li>
            <xsl:apply-templates />
        </li>
    </xsl:template>

    <xsl:template match="hyperlink">
        <a href="{url}" target="{target}">
            <xsl:value-of select="name"/>
        </a>
    </xsl:template>
</xsl:stylesheet>
