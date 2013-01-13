<?php
require_once 'conn.php';
require_once 'functions.php';

$sql = 'SELECT * FROM forum_admin';

$result = mysql_query($sql)
	or die(mysql_error());

while ($row = mysql_fetch_array($result)) 
{
	$admin[$row['constant']]['title'] = $row['title'];
	$admin[$row['constant']]['value'] = $row['value'];
}

$sql = 'SELECT * FROM forum_bbcode';

$result = mysql_query($sql)
	or die(mysql_error());

while ($row = mysql_fetch_array($result)) 
{
	$bbcode[$row['id']]['template'] = $row['template'];
	$bbcode[$row['id']]['replacement'] = $row['replacement'];
}

// define constants here:
define("NEWPOST", "<span class=\"newpost\">&raquo;</span>");
define("POSTLINK", "<span class=\"postlink\">&diams;</span>");

?>