<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="utf-8" omit-xml-declaration="yes" />
	<xsl:template match="/">
	<div id="reviewContent" style="height:400px; overflow-y:scroll;">
				<xsl:for-each select="reviews/review">
					<table class="review">
						<tr class="odd">
							<th class="title">Username</th>
							<td class="reviewtext">
								<xsl:value-of select="username" />
							</td>
						</tr>
						<tr>
							<th class="title">Comment</th>
							<td class="reviewtext">
								<xsl:value-of select="comment" />
							</td>
						</tr>
						<tr class="odd">
							<th class="title">Rating</th>
							<td class="reviewtext">
								<xsl:value-of select="rating" />
							</td>
						</tr>
					</table>
				</xsl:for-each>
				</div>
	</xsl:template>
</xsl:stylesheet>