<?php require_once 'header.php'; ?>
<form method="post" action="transact-user.php">
<h3>Email Password Reminder</h3>
<p>
	Forgot your password? Just enter your email address, and we’ll email
	your password to you!
</p>
<p>
	Email Address:<br>
	<input type="text" id="email" name="email">
</p>
<p>
<input type="submit" class="submit" name="action" value="Send my reminder!">
</p>
</form>
<?php require_once 'footer.php'; ?>