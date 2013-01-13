<?php
require_once 'header.php';
?>
<script type="text/javascript">
<!--
function delBBCode(id) 
{
	window.location = "transact-admin.php?action=deleteBBCode&b=" + id;
}

function delForum(id) 
{
	window.location = "transact-affirm.php?action=deleteForum&f=" + id;
}
//-->
</script>

<?php
	$sql = 	"SELECT access_lvl, access_name FROM forum_access_levels " .
			"ORDER by access_lvl DESC";
	
	$result = mysql_query($sql)
		or die(mysql_error());
	
	while ($row = mysql_fetch_array($result)) 
	{
		$a_users[$row['access_lvl']] = $row['access_name'];
	}

	$menuoption = "boardadmin"; // default
	if (isset($_GET['option'])) $menuoption = $_GET['option'];
	
	$menuItems = array(
		"boardadmin" => "Board Admin",
		"edituser" => "Users",
		"forums" => "Forums",
		"bbcode" => "BBcode"
	);

	echo "<p class=\"menu\"> | ";
	foreach ($menuItems as $key => $value) 
	{
		if ($menuoption != $key) 
		{
			echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?option=$key\">";
		}
		echo " $value ";
		
		if ($menuoption != $key) echo "</a>";
			echo " | ";
	}
	
	echo "</p>";

	switch ($menuoption) 
	{
		case 'boardadmin':

?>
			<h3>Board Administration</h3>
			<form id="adminForm" method="post" action="transact-admin.php">
				<table cellspacing="0" class="forumtable">
				<tr>
					<th>Title</th>
					<th>Value</th>
					<th>Parameter</th>
				</tr>
<?php
				foreach ($admin as $k => $v) 
				{
					echo 	"<tr><td>". $v['title'] . "</td><td>" .
							"<input type=\"text\" name=\"". $k . "\" " .
							"value=\"" . $v['value'] . "\" size=\"60\">" .
							"</td><td>$k</td></tr>\n";
				}
?>
				</table>
				<p class="buttonBar">
					<input class="submit" type="submit" name="action" id="Update" value="Update">
				</p>
			</form>
<?php
			break;

		case 'edituser':
?>
			<h3>User Administration</h3>
				<div id="users">
					<form name="myform" action="transact-admin.php" method="post">
						Please select a user to admin:<br>
						<select id="userlist" name="userlist[]">
					<?php
							foreach ($a_users as $key => $value) 
							{
								echo "<optgroup label=\"". $value . "\">\n";
								userOptionList($key);
								echo "\n</optgroup>\n";
							}
					?>
						</select>
							<input class="submit" type="submit" name="action" value="Modify User">
					</form>
				</div>
<?php
			break;

		case 'forums':
?>
			<h2>Forum Administration</h2>
			<table class="forumtable" cellspacing="0">
			<tr><th class="forum">Forum</th><th>&nbsp;</th><th>&nbsp;</th></tr>
<?php

				$sql = 	"SELECT * FROM forum_forum";
				
				$result = mysql_query($sql)
					or die(mysql_error());			

				while ($row = mysql_fetch_array($result)) 
				{
					echo 	"<tr><td><span class=\"forumname\">" . $row['forum_name'] .
							"</span><br><span class=\"forumdesc\">" .$row['forum_desc'].
							"</span></td><td>" . "<a href=\"editforum.php?forum=" .
							$row['id'] . "\">Edit</a></td><td>" .
							"<a href=\"#\" onclick=\"delForum(". $row['id'] .
							");\">" . "Delete</a></td></tr>";
				}
?>
			</table>
			<p class="buttonBar">
			<a href="editforum.php" class="buttonlink">New Forum</a>
			</p>
<?php
			break;

		case 'bbcode':
?>
		<h3>BBcode Administration</h3>
		<form id="bbcodeForm" method="post" action="transact-admin.php">
		<table cellspacing="0" class="forumtable">
			<tr>
				<th class="template">Template</th>
				<th class="replacement">Replacement</th>
				<th class="action">Action</th>
			</tr>
<?php
		if (isset($bbcode)) 
		{
			foreach ($bbcode as $k => $v) 
			{
				echo 	"<tr class=\"row1\"><td>" .
						"<input class=\"mono\" type=\"text\" " .
						"name=\"bbcode_t" . $k . "\" " .
						"value=\"" . $v['template'] . "\" size=\"32\">" .
						"</td><td>" .
						"<input class=\"mono\" type=\"text\" " .
						"name=\"bbcode_r". $k . "\" " .
						"value=\"" . $v['replacement'] . "\" size=\"32\">" .
						"</td><td><input type=\"button\" class=\"submit\" " .
						"name=\"action\" id=\"DelBBCode\" value=\"Delete\" " .
						"onclick=\"delBBCode(".$k.");\">" .
						"</td></tr>\n";
			}
		}
?>
			<tr class="row2">
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr class="row2">
				<td>
					<input class="mono" type="text" name="bbcode-tnew" size="32">
				</td>
				<td>
					<input class="mono" type="text" name="bbcode-rnew" size="32">
				</td>
				<td>
					<input type="submit" class="submit" name="action" id="AddBBCode" value="Add New">
				</td>
			</tr>
		</table>
		<p class="buttonBar">
		<input class="submit" type="submit" name="action" id="Update" value="Update BBCodes">
		</p>
		</form>

		<?php
		break;
}
?>
</script>
<?php require_once 'footer.php'; ?>