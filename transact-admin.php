<?php
session_start();
require_once 'conn.php';
require_once 'http.php';

if (isset($_REQUEST['action'])) 
{
	switch ($_REQUEST['action']) 
	{
		case 'Add Forum':
			if (isset($_POST['forumname'])
				and $_POST['forumname'] != ""
				and isset($_POST['forumdesc'])
				and $_POST['forumdesc'] != "") 
			{
				$sql = 	"INSERT IGNORE INTO forum_forum " .
						"VALUES (NULL, '" .
							htmlspecialchars($_POST['forumname'], ENT_QUOTES) .
							"', '" .
							htmlspecialchars($_POST['forumdesc'], ENT_QUOTES) .
							"', " . $_POST['forummod'][0] . ")";
				
				mysql_query($sql)
					or die(mysql_error());
			}
			redirect('admin.php?option=forums');
			break;

		case 'Edit Forum':
			if 	(isset($_POST['forumname'])
				and $_POST['forumname'] != ""
				and isset($_POST['forumdesc'])
				and $_POST['forumdesc'] != "") 
			{
				$sql = 	"UPDATE forum_forum " .
						"SET forum_name = '" . $_POST['forumname'] .
						"', forum_desc = '" . $_POST['forumdesc'] .
						"', forum_moderator = " . $_POST['forummod'][0] .
						" WHERE id = " . $_POST['forum_id'];
				
				mysql_query($sql)
					or die(mysql_error());
			}
			redirect('admin.php?option=forums');
			break;

		case 'Modify User':
			redirect("useraccount.php?user=" . $_POST['userlist'][0]);
			break;

		case 'Update':
			foreach ($_POST as $key => $value) 
			{
				if ($key != 'action') 
				{
					$sql = 	"UPDATE forum_admin SET value='$value' " .
							"WHERE constant = '$key'";
					mysql_query($sql)
						or die(mysql_error());
				}
			}
			redirect('admin.php');
			break;

		case 'deleteForum':
			$sql = "DELETE FROM forum_forum WHERE id=" . $_GET['f'];
			
			mysql_query($sql)
				or die(mysql_error());
			
			$sql = "DELETE FROM forum_posts WHERE forum_id=" . $_GET['f'];
			
			mysql_query($sql)
				or die(mysql_error());
			
			redirect('admin.php?option=forums');
			break;

		case 'Add New':
			$sql = 	"INSERT INTO forum_bbcode " .
					"VALUES (NULL,'" .
						htmlentities($_POST['bbcode-tnew'],ENT_QUOTES) . "','" .
						htmlentities($_POST['bbcode-rnew'],ENT_QUOTES) . "')";
			
			mysql_query($sql)
				or die(mysql_error() . "<br>" . $sql);
			
			redirect('admin.php?option=bbcode');
			break;

		case 'deleteBBCode':
			if (isset($_GET['b'])) 
			{
				$bbcodeid = $_GET['b'];
				$sql = "DELETE FROM forum_bbcode WHERE id=" . $bbcodeid;
				
				mysql_query($sql)
					or die(mysql_error());
			}
			redirect('admin.php?option=bbcode');
			break;

		case 'Update BBCodes':
			foreach($_POST as $key => $value) 
			{
				if (substr($key,0,7) == 'bbcode_') 
				{
					$bbid = str_replace("bbcode_", "", $key);
					if (substr($bbid,0,1) == 't') 
					{
						$col = "template";
					} else 
					{
						$col = "replacement";
					}
					
					$id = substr($bbid,1);
					$sql = 	"UPDATE forum_bbcode SET $col='" .
							htmlentities($value,ENT_QUOTES) . "' " .
							"WHERE id=$id";
					
					mysql_query($sql)
						or die(mysql_error());
				}
			}
			redirect('admin.php?option=bbcode');
			break;

		default:
			redirect('index.php');
	}
} else 
{
	redirect('index.php');
}
?>