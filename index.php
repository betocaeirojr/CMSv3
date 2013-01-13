<?php
require_once 'conn.php';
require_once 'functions.php';
require_once 'header.php';
$sql = <<<EOS
SELECT f.id as id, f.forum_name as forum,
f.forum_desc as description,
count(p.forum_id) as threads, u.name as moderador
FROM forum_forum f
LEFT JOIN forum_posts p
ON f.id = p.forum_id
AND p.topic_id=0
LEFT JOIN forum_users u
ON f.forum_moderator = u.id
GROUP BY f.id
EOS;

$result = mysql_query($sql)
	or die(mysql_error());
if (mysql_num_rows($result) == 0) 
{
	echo " <br>\n";
	echo " There are currently no forums to view.\n";
} else 
{
	echo "<table class=\"forumtable\" cellspacing=\"0\" ";
	echo "cellspacing=\"0\"><tr>";
	echo "<th class=\"forum\">Forum</th>";
	echo "<th class=\"threadcount\">Threads</th>";
	echo "<th class=\"moderator\">Moderator</th>";
	echo "</tr>";
	$rowclass = "";

	while ($row = mysql_fetch_array($result)) 
	{
		$rowclass = ($rowclass == "row1" ? "row2" : "row1");
		echo "<tr class=\"$rowclass\">";
		echo "<td class=\"firstcolumn\"><a href=\"viewforum.php?f=" . $row['id'] . "\">";
		echo $row['forum'] . "</a><br>";
		echo "<span class=\"forumdesc\">" . $row['description'];
		echo "</span></td>";
		echo "<td class=\"center\">" . $row['threads'] . "</td>";
		echo "<td class=\"center\">" . $row['moderador'] . "</td>";
		echo "</tr>\n";
	}
	echo "</table>";
}
require_once 'footer.php';
?>