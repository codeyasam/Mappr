<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? redirect_to("index.php") : null; ?>
<?php 
	$prompt_to_user = "";
	if (isset($_POST['submit'])) {
		$emUsername = $_POST['emUsername'];
		$password = $_POST['password'];
		$user = User::authenticate($emUsername, $password);
		
		if ($user) {
			$session->login($user);
			User::page_redirect($user->id);
		}
		$prompt_to_user = "wrong username or password";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<?php include("../includes/navigation.php"); ?>
		<form action="login.php" method="POST">
			<p><input type="text" name="emUsername" value="" placeholder="Email/Username"/></p>
			<p><input type="password" name="password" value="" placeholder="Password"/></p>
			<p><?php echo $prompt_to_user; ?></p>
			<p><input type="submit" name="submit" value="LOGIN"/></p>
		</form>
	</body>
</html>