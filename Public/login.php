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
		<?php include '../includes/styles.php'; ?>
	</head>
	<body>
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="container center" style="background:url('images/map.jpg'); height: 400px;">
			<div class="login">
				<h1>Login</h1>
				<br>
				<form action="login.php" method="POST">
					<table>
						<tr>
							<td>ID:</td>
							<td><input type="text" name="emUsername" value="" placeholder="Email/Username"/></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type="password" name="password" value="" placeholder="Password"/></td>
						</tr>
						<tr>
							<td colspan="100%"><?php echo $prompt_to_user; ?></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="submit" value="LOGIN"/></td>
						</tr>
					</table>
				</form>
			</div>
			<section class="cyan featured" style="margin-top: 50px;">
				<h1>Mappr</h1>
				<p>The leading establishment navigator for all. Available in Android and iOS.</p>
			</section>
			<footer>
				<?php include '../includes/footer.php'; ?>
			</footer>
		</div>
	</body>
</html>