<?php 
require_once 'header.php'; 
?>

<form name="theForm" method="post" action="transact-user.php">
<h3>Member Login</h3>
<p>
	Email Address:<br>
	<input type="text" name="email" maxlength="255" value="<?php if (isset($_GET['e'])) { echo $_GET['e']; } ?>">
</p>
<p>
	Password:<br>
	<input type="password" name="passwd" maxlength="50">
</p>
<p>
	<input type="submit" class="submit" name="action" value="Login">
</p>
<p>
	Not a member yet? <a href="useraccount.php">Create a new account!</a>
</p>
<p>
	<a href="forgotpass.php">Forgot your password?</a>
</p>
</form>

<?php 
require_once 'footer.php'; 
?>