<?php
require_once 'conn.php';
require_once 'functions.php';
require_once 'http.php';
require_once 'header.php';
?>
<script type="text/javascript">
<!--
	function deletePost(id,redir) 
	{
		if (id > 0) 
		{
			window.location = 	"transact-post.php?action=delete&post=" +
								id + "&r=" + redir;
		} else 
		{
			history.back();
		}
	}

	function deleteForum(id) 
	{
		if (id > 0) 
		{
			window.location = "transact-admin.php?action=deleteForum&f=" + id;
		} else 
		{
			history.back();
		}
	}
//-->
</script>

<?php
	switch (strtoupper($_REQUEST['action'])) 
	{
		case "DELETEPOST":
			$sql = "SELECT * FROM forum_posts WHERE id=" . $_REQUEST['id'];
			
			$result = mysql_query($sql);
			
			$row = mysql_fetch_array($result);
			
			if ($row['topic_id'] > 0) 
			{
				$msg = 	"Are you sure you wish to delete the post<br>" .
						"<em>" . $row['subject'] . "</em>?";
				$redir = htmlspecialchars("viewtopic.php?t=" . $row['topic_id']);
			} else 
			{
				$msg = 	"If you delete this post, all replies will be deleted " .
						"as well. Are you sure you wish to delete the entire " .
						"thread<br><em>" . $row['subject'] . "</em>?";
				$redir = htmlspecialchars("viewforum.php?f=" . $row['forum_id']);
			}
			
			echo "<div id=\"requestConfirmWarn\">";
			echo "<h2>DELETE POST?</h2>\n";
			echo "<p>" . $msg . "</p>";
			echo "<p><input class=\"confirm\" type=\"button\" ";
			echo "value=\"Delete\" onclick=\"deletePost(" . $row['id'] . ",'" . $redir . "');\">";
			echo "<input class=\"confirm\" type=\"button\" value=\"Cancel\" ";
			echo "onclick=\"history.back()\"></p>";
			echo "</div>";
			
			break;

		case "DELETEFORUM":
			$sql = "SELECT * FROM forum_forum WHERE id=" . $_REQUEST['f'];
			
			$result = mysql_query($sql);
			
			$row = mysql_fetch_array($result);
			
			$msg = 	"If you delete this forum, all topics and replies will " .
					"be deleted as well. Are you sure you wish to delete " .
					"the entire forum<br><em>" . $row['forum_name'] . "</em>?";
		
			echo "<div id=\"requestConfirmWarn\">";
			echo "<h2>DELETE FORUM?</h2>\n";
			echo "<p>" . $msg . "</p>";
			echo "<p><input class=\"confirm\" type=\"button\" ";
			echo "value=\"Delete\" ";
			echo "onclick=\"deleteForum(" . $_REQUEST['f'] . ");\">";
			echo "<input class=\"confirm\" type=\"button\" value=\"Cancel\" ";
			echo "onclick=\"history.back()\"></p>";
			echo "</div>";
	}
		require_once 'footer.php';
?>


