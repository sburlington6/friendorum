<?php
	require ('includes/functions.php');
	header("Content-Type: application/xml");
?>
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title>GettingSocial.tk Changelog</title>
<link>http://www.gettingsocial.tk/</link>
<description>A log of changes for GettingSocial.tk</description>
	
	  <?php 
			$query = "SELECT * FROM changelog ORDER BY date DESC ";
			$result = mysqli_query($db, $query);

			
			while ($row = mysqli_fetch_assoc($result)) 
				{
					echo '<item>';
					echo '<title>Change</title>';
					echo '<link>http://www.gettingsocial.tk/changelog.php</link>';
					echo '<pubDate>'.$row['date'].'</pubDate>';
					echo '<description><![CDATA['.$row['change'].']]></description>';
					echo '</item>';
				}
			require("includes/close.php");
		?>
		</channel>
		</rss>