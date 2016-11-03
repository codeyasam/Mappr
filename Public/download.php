<?php require_once("../includes/initialize.php"); ?>
<?php  
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : false;
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title> 
		<?php include '../includes/styles.php'; ?>
	</head>
	<body style="background: url('images/banner_fade.png') no-repeat center top;">
		<header class="center">
			<?php include("../includes/navigation.php"); ?>
		</header>

		<div class="container">
			<header class="text-right" style="height: inherit;padding: 40px 150px 70px 0; margin-top: -40px;" >
				<div style="display: inline-block; margin-top: 100px;">
					<h5 style="padding: 0 10px;">Download the latest version of our mobile application.</h5>
					<h1 class="heading-label" style="font-size: 3.5em; padding: 0 10px;"><span class="heading-yellow">Download </span>Coin One</h1>
					<input type="button" name="signup" style="margin: 20px 0 0 0;font-size: 1.1em; letter-spacing: 1px; padding: 10px;" value="Download our mobile app" class="heading-label btn btn-warning drop-shadow" />
				</div>
			</header>
			<div style="background-color: #fff;" class="clearfix">
				<div style="position: absolute; margin-top: -180px; margin-left: 100px; border-radius: 50%; z-index: -1;  width: 310px; height: 310px; background: #fff;">
				</div>
				<img style="margin: -145px -70px 50px 35px;" src="images/android_with_logo.png">
				<h2 class="heading-label pull-right" style="margin: -15px 150px 50px 50px;">Soon on <img style="width: 200px;" src="images/playstore.png"></h2>
				<div class="photo-details text-right pull-right" style="margin: -100px 100px 100px 100px; display: inline-block;">
				<?php if ($session->is_logged_in()) { ?>
					<h2 style="padding: 5px;" class="heading-label heading-yellow">Purchase a plan today with COIN ONE!</h2>
					<h5 style="padding: 5px;" >Choose subscription plans suitable for your business.</h5>
					
					<a href="subscription.php"><input style="letter-spacing: 2px; font-size: 1.5em" type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Purchase a subscription" /></a>				
				<?php } else { ?>
					<h2 style="padding: 5px;" class="heading-label heading-yellow">Start by signing up with COIN ONE today!</h2>
					<h5 style="padding: 5px;" >Signing up lets you choose subscription plans suitable for your business.</h5>
					
					<a href="registeruser.php"><input style="letter-spacing: 2px; font-size: 1.5em" type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Sign up now"></a>
					<a href="login.php">Or just log in if you already have an account.</a>
				
				<?php } ?>
				</div>
			</div>
		</div>
		<?php include '../includes/footer.php'; ?>
	</body>
</html>