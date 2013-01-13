<?php
require_once "../conn.php";
$adminemail = "admin@yoursite.com";
$adminname = "Admin";
$adminpass = "admin";

/******* Access Levels Table *****************************************/
$sql = <<<EOS
CREATE TABLE IF NOT EXISTS forum_access_levels (
access_lvl tinyint(4) NOT NULL auto_increment,
access_name varchar(50) NOT NULL default '',
PRIMARY KEY (access_lvl)
)
EOS;
$result = mysql_query($sql);

switch(mysql_errno()) 
{
	case 1050:
		break;
	case 0:
		$sql = 	"INSERT IGNORE INTO forum_access_levels " .
				"VALUES (1,'User')";

		$result = mysql_query($sql)
			or die(mysql_error());

		$sql = 	"INSERT IGNORE INTO forum_access_levels " .
				"VALUES (2,'Moderator')";

		$result = mysql_query($sql)
			or die(mysql_error());
		
		$sql = 	"INSERT IGNORE INTO forum_access_levels " .
				"VALUES (3,'Administrator')";
		
		$result = mysql_query($sql)
			or die(mysql_error());
		
		break;
	default:
		die(mysql_error());
break;
}

$a_tables[] = "forum_access_levels";

/******* Admin Table *************************************************/
$sql = <<<EOS
CREATE TABLE IF NOT EXISTS forum_admin (
id int(11) NOT NULL auto_increment,
title varchar(100) NOT NULL default '',
value varchar(255) NOT NULL default '',
constant varchar(100) NOT NULL default '',
PRIMARY KEY (id)
)
EOS;
$result = mysql_query($sql);
switch(mysql_errno()) 
{
	case 1050:
		break;
		
	case 0:
		$sql = 	"INSERT INTO forum_admin " .
				"VALUES (NULL, 'Board Title', " .
					"'Comic Book Appreciation Forums', 'title')";

		$result = mysql_query($sql)
			or die(mysql_error());

		$sql = 	"INSERT INTO forum_admin " .
				"VALUES (NULL, 'Board Description', " .
					"'The place to discuss your favorite " .
					"comic books, movies, and more!', 'description')";

		$result = mysql_query($sql)
			or die(mysql_error());

		$sql = 	"INSERT INTO forum_admin " .
				"VALUES (NULL,'Admin Email', '$adminemail', 'admin_email')";
		
		$result = mysql_query($sql)
			or die(mysql_error());

		$sql = 	"INSERT INTO forum_admin " .
				"VALUES (NULL, 'Copyright', ".
					"'&copy;2003 CBA Inc. All rights reserved.', 'copyright')";
	
		$result = mysql_query($sql)
			or die(mysql_error());

		$sql = 	"INSERT INTO forum_admin " .
				"VALUES (NULL, 'Board Titlebar', 'CBA Forums', 'titlebar')";
		
		$result = mysql_query($sql)
			or die(mysql_error());

		$sql = 	"INSERT INTO forum_admin " .
				"VALUES (NULL, 'Pagination Limit', '10', 'pageLimit')";

		$result = mysql_query($sql)
			or die(mysql_error());
		
		$sql = 	"INSERT INTO forum_admin " .
				"VALUES (NULL, 'Pagination Range', '7', 'pageRange')";
		
		$result = mysql_query($sql)
			or die(mysql_error());

		break;

	default:
		die(mysql_error());
	break;
}
$a_tables[] = "forum_admin";

/******* BBcode Table ************************************************/
$sql = <<<EOS
CREATE TABLE IF NOT EXISTS forum_bbcode (
id int(11) NOT NULL auto_increment,
template varchar(255) NOT NULL default '',
replacement varchar(255) NOT NULL default '',
PRIMARY KEY (id)
)
EOS;

$result = mysql_query($sql)
	or die(mysql_error());

$a_tables[] = "forum_bbcode";

/******* Forum Table *************************************************/
$sql = <<<EOS
CREATE TABLE IF NOT EXISTS forum_forum (
id int(11) NOT NULL auto_increment,
forum_name varchar(100) NOT NULL default '',
forum_desc varchar(255) NOT NULL default '',
forum_moderator int(11) NOT NULL default '0',
PRIMARY KEY (id)
)
EOS;

$result = mysql_query($sql);

switch(mysql_errno()) 
{
	case 1050:
		break;
	
	case 0:
		$sql = 	"INSERT INTO forum_forum VALUES (NULL, 'New Forum', " .
				"'This is the initial forum created when installing the " .
				"database. Change the name and the description after " .
				"installation.', 1)";

		$result = mysql_query($sql)
			or die(mysql_error());
		
		break;

	default:
		die(mysql_error());
break;
}
$a_tables[] = "forum_forum";

/******* Post Count Table ********************************************/
$sql = <<<EOS
CREATE TABLE IF NOT EXISTS forum_postcount (
user_id int(11) NOT NULL default '0',
count int(9) NOT NULL default '0',
PRIMARY KEY (user_id)
)
EOS;

$result = mysql_query($sql);
switch(mysql_errno()) {
	case 1050:
		break;

	case 0:
		$sql = "INSERT INTO forum_postcount VALUES (1,1)";
	
		$result = mysql_query($sql)
			or die(mysql_error());
	
		break;
	
	default:
	
		die(mysql_error());
	
	break;
}
$a_tables[] = "forum_postcount";

/******* Posts Table *************************************************/
$sql = <<<EOS
CREATE TABLE IF NOT EXISTS forum_posts (
id int(11) NOT NULL auto_increment,
topic_id int(11) NOT NULL default '0',
forum_id int(11) NOT NULL default '0',
author_id int(11) NOT NULL default '0',
update_id int(11) NOT NULL default '0',
date_posted datetime NOT NULL default '0000-00-00 00:00:00',
date_updated datetime NOT NULL default '0000-00-00 00:00:00',
subject varchar(255) NOT NULL default '',
body mediumtext NOT NULL,
PRIMARY KEY (id),
KEY IdxArticle (forum_id,topic_id,author_id,date_posted),
FULLTEXT KEY IdxText (subject,body)
) engine=MyISAM;

EOS;
$result = mysql_query($sql);
switch(mysql_errno()) 
{
	case 1050:
		break;
	
	case 0:
		$sql = 	"INSERT INTO forum_posts VALUES (NULL, 0, 1, 1, 0, '" .
				date("Y-m-d H:i:s", time())."', 0, 'Welcome', 'Welcome " .
				"to your new Bulletin Board System. Do not forget to " .
				"change your admin password after installation. " .
				"Have fun!')";

		$result = mysql_query($sql)
			or die(mysql_error());

		break;

	default:
		die(mysql_error());
		break;

}
$a_tables[] = "forum_posts";

/******* Users Table *************************************************/
$sql = <<<EOS
CREATE TABLE forum_users (
id int(11) NOT NULL auto_increment,
email varchar(255) NOT NULL default '',
passwd varchar(50) NOT NULL default '',
name varchar(100) NOT NULL default '',
access_lvl tinyint(4) NOT NULL default '1',
signature varchar(255) NOT NULL default '',
date_joined datetime NOT NULL default '0000-00-00 00:00:00',
last_login datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY (id),
UNIQUE KEY uniq_email (email)
)
EOS;
$result = mysql_query($sql);
switch(mysql_errno()) {
	case 1050:
		break;
	
	case 0:
		$datetime = date("Y-m-d H:i:s",time());
		
		$sql = 	"INSERT IGNORE INTO forum_users VALUES (NULL, " .
				"'$adminemail', '$adminpass', '$adminname', 3, '', " .
				"'$datetime', 0)";
		
		$result = mysql_query($sql)
			or die(mysql_error());
		
		break;
	default:
		die(mysql_error());
	break;
}
$a_tables[] = "forum_users";

/******* Display Results *********************************************/
echo "<html><head><title>Forum Tables Created</title>";
echo "<link rel=\"stylesheet\" type=\"text/css\" ";
echo "href=\"forum_styles.css\">";
echo "</head><body>";
echo "<div class=\"bodysmall\">";
echo "<h1>Comic Book Appreciation Forums</h1>";
echo "<h3>Forum Tables created:</h3>\n<ul>";

foreach ($a_tables as $table) 
{
	$table = str_replace("forum_","",$table);
	$table = str_replace("_", " ",$table);
	$table = ucWords($table);
	echo "<li>$table</li>\n";
}

echo "</ul>\n<h3>Here is your initial login information:</h3>\n";
echo "<ul><li><strong>login</strong>: " . $adminemail . "</li>\n";
echo "<li><strong>password</strong>: " . $adminpass . "</li></ul>\n";
echo "<h3><a href=\"login.php?e=" . $adminemail . "\">Log In</a> ";
echo "to the site now.</h3></div>";
echo "</body></html>";
?>
