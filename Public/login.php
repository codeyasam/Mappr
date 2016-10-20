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
	<body style="background: url('images/bg.jpg') no-repeat center center;">
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="container page-wrap" style="background: none;">
			<div class="row homepage">
				<div class="login drop-shadow">
					<div class="text-center" style="position: absolute; top: -270px; left: 0; background: none;"><img src="images/coin_one_logo.png" style="width: 50%;"></div>
					<div class="text-center login-heading">
						<h1 style="font-size: 4em;">Coin One</h1>
					</div>
					<div class="offset-title">Establishment Locator</div>
					<form action="login.php" method="post">
						<div class="form-group alert-danger" role="alert">
							<b><?php echo $prompt_to_user; ?></b>
						</div>
						<div class="form-group">
				  			<label><h4><span class="glyphicon glyphicon-bookmark"></span> Login to continue</h4></label>
				  		</div>	
						<div class="form-group">
				  			<label>ID</label>
				  			<input class="form-control" type="text" name="emUsername" value="" placeholder="Email or username"/>
				  		</div>	
						<div class="form-group">
				  			<label>Password</label>
				  			<input class="form-control" type="password" name="password" value="" placeholder="Password"/>
				  		</div>
				  		<div class="row form-group text-right">
				  			<div class="col col-md-7" style="margin-top:5px;"><a href="registeruser.php"><span class="glyphicon glyphicon-tag"></span> Not yet a member?</a></div>
				  			<div class="col col-md-5"><input class="form-control btn btn-primary" type="submit" name="submit" value="Login"/></div>
				  		</div>
					</form>
				</div>
			</div>
		</div>
		<?php include '../includes/footer.php'; ?>
	</body>
</html>