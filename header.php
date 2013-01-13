<?php
session_start();
require_once 'config.php';

$title = $admin['titlebar']['value'];

if (isset($pageTitle) and $pageTitle != "") 
{
	$title .= " :: " . $pageTitle;
}

if (isset($_SESSION['user_id'])) 
{
	$userid = $_SESSION['user_id'];
} else 
{
	$userid = null;
}

if (isset($_SESSION['access_lvl'])) 
{
	$access_lvl = $_SESSION['access_lvl'];
} else 
{
	$access_lvl = null;
}

if (isset($_SESSION['name'])) 
{
	$username = $_SESSION['name'];
} else 
{
	$username = null;
}

?>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="forum_styles.css">
	</head>

<body>
	<div class="body">
	<div id="header">

	<form method="get" action="search.php" id="searchbar">
		<input id="searchkeywords" type="text" name="keywords"
<?php
		if (isset($_GET['keywords'])) 
		{
			echo ' value="' . htmlspecialchars($_GET['keywords']) . '" ';
		}
?> >
		<input id="searchbutton" class="submit" type="submit" value="Search">
	</form>

	<h1 id="sitetitle">
		<?php echo $admin['title']['value']; ?></h1>
<div id="login">
<?php
	if (isset($_SESSION['name'])) 
	{
		echo 'Welcome, ' . $_SESSION['name'];
	}
?>

</div>
	<p id="subtitle"><?php echo $admin['description']['value']; ?></p>
</div>
<div id="subheader">
	<div id="navigation">
<?php
	echo ' <a href="index.php">Home</a>';
	if (!isset($_SESSION['user_id'])) 
	{
		echo ' | <a href="login.php">Log In</a>';
		echo ' | <a href="useraccount.php">Register</a>';
	} else 
	{
		echo ' | <a href="transact-user.php?action=Logout">';
		echo "Log out " . $_SESSION['name'] . "</a>";
		if ($_SESSION['access_lvl'] > 2) 
		{
			echo ' | <a href="admin.php">Admin</a>';
		}
		
		echo ' | <a href="useraccount.php">Profile</a>';
	}
?>
</div>
</div>