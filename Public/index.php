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
	<body style="background: url('images/banner_fade.jpg') no-repeat center top;">
		<header class="center">
			<?php include("../includes/navigation.php"); ?>
		</header>

		<div class="container">
			<header style="height: inherit;padding: 0 0 100px 150px; margin-top: -10px;" >
				<img style="display: inline-block; margin-top: -100px; width: 200px; " src="images/coin_one_logo_large.png">
				<div class="text-uppercase" style="display: inline-block; margin-top: 100px;">
					<h2 style="font-family: 'Arial Narrow'; letter-spacing: 5px;">Business Locator</h2>
					<h1 class="heading-label" style="font-size: 5.5em; padding: 0;">Coin One</h1>
					<?php if ($session->is_logged_in()) { ?>
						<a href="subscription.php"><input type="button" name="signup" style="font-size: 1.1em; letter-spacing: 1px; padding: 10px;" value="Purchase a plan" class="heading-label btn btn-primary drop-shadow" /></a>
					<?php } else { ?>
					<a href="registeruser.php"><input type="button" name="signup" style="font-size: 1.1em; letter-spacing: 1px; padding: 10px;" value="Register your business" class="heading-label btn btn-primary drop-shadow" /></a>
					<a href="login.php"><input type="button" name="signup" style="font-size: 1.1em; letter-spacing: 1px; padding: 10px;" value="Log in to your account" class="heading-label btn btn-success drop-shadow" /></a>
					<?php } ?>
				</div>
			</header>
			<div style="background-color: #fff;">
				<div class="pull-center plans-container">
					<div class="plans-display drop-shadow">
						<h1 class="plan-title text-center"><span class="heading-label">Weekly</span>&nbsp;Plans</h1>
						<br>
						<p class="plan-description">A more flexible plan for small scale business. Recommended for starters.</p>
						<p class="plan-starting-price">Starting at <span class="price heading-label heading-yellow" style="">&yen;&nbsp;3,000 </span></p>
						<?php if ($session->is_logged_in()) { ?>
						<a href="subscriptionplans.php?type=2"><input type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Choose From Weekly Plans"></a>						
						<?php } else { ?>
						<a href="registeruser.php"><input type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Sign Up NOW to avail this plan."></a>
						<?php } ?>
					</div>
					<div class="plans-display larger drop-shadow">
						<h1 class="plan-title text-center"><span class="heading-label">Monthly</span>&nbsp;Plans</h1>
						<br>
						<p class="plan-description">The most common subscription plan. Usually for small to medium type of businesses.</p>
						<p class="plan-starting-price">Starting at <span class="price heading-label heading-yellow" style="font-size: 1.1em;">&yen;&nbsp;10,000 </span></p>
						
						<?php if ($session->is_logged_in()) { ?>
						<a href="subscriptionplans.php?type=3"><input type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Choose From Monthly Plans"></a>						
						<?php } else { ?>
						<a href="registeruser.php"><input type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Sign Up NOW to avail this plan."></a>
						<?php } ?>
					</div>
					<div class="plans-display drop-shadow">
						<h1 class="plan-title text-center"><span class="heading-label">Annual</span>&nbsp;Plans</h1>
						<br>
						<p class="plan-description">Let's you worry less for payments. Fix it annually for hassle free subscriptions. Great for large scale establishments.</p>
						<p class="plan-starting-price">Starting at <span class="price heading-label heading-yellow" style="">&yen;&nbsp;100,000</span></p>

						<?php if ($session->is_logged_in()) { ?>
						<a href="subscriptionplans.php?type=4"><input type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Choose From Annual Plans"></a>						
						<?php } else { ?>
						<a href="registeruser.php"><input type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Sign Up NOW to avail this plan."></a>
						<?php } ?>
					</div>
				</div>
				<div style="padding: 50px 20px;">
					<h1 class="heading-label heading-yellow text-center" style="font-size: 4em;">The Best Features at the Best Price!</h1>
					<div>
						<img src="images/map_with_logo.png" style="padding: 40px; display: inline-block;">
						<?php if ($session->is_logged_in()) { ?>
						<div class="photo-details" style="padding: 20px; display: inline-block; max-width: 650px;">
							<h2 style="padding: 5px;" class="heading-label heading-yellow">Purchase a plan now!</h2>
							<h5 style="padding: 5px;" >Choose subscription plans suitable for your business.</h5>
							<a href="subscription.php"><input style="letter-spacing: 2px; font-size: 1.5em" type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Purchase a plan"></a>
						</div>
						<?php } else { ?>
						<div class="photo-details" style="padding: 20px; display: inline-block; max-width: 650px;">
							<h2 style="padding: 5px;" class="heading-label heading-yellow">Start by signing up with COIN ONE today!</h2>
							<h5 style="padding: 5px;" >Signing up lets you choose subscription plans suitable for your business.</h5>
							<a href="registeruser.php"><input style="letter-spacing: 2px; font-size: 1.5em" type="button" name="signup-now" class="btn btn-primary heading-label drop-shadow" value="Sign up now"></a>
						</div>
						<?php } ?>
					</div>
					<hr>
					<div class="text-right">
						<div class="photo-details" style="padding: 20px; display: inline-block; max-width: 650px;">
							<h2 style="padding: 5px;" class="heading-label heading-yellow">Using our mobile application, you can be located.</h2>
							<h5 style="padding: 5px;" >Download our mobile application on our website. It will be available soon on Google Playstore.</h5>
							<a href="download.php"><input style="letter-spacing: 2px; font-size: 1.5em" type="button" name="signup-now" class="btn btn-warning heading-label drop-shadow" value="Download our mobile application"></a>
						</div>
						<img src="images/android_with_logo.png" style="padding: 30px; display: inline-block;">
					</div>
					<hr>
					<div class="text-left">
						<img src="images/android_preview.png" style="width:350px; display: inline-block;">
						<div class="photo-details" style="padding: 20px; display: inline-block; max-width: 650px;">
							<h2 style="padding: 5px;" class="heading-label heading-yellow">Fast and efficient way for your business to be located.</h2>
							<h5 style="padding: 5px;" >Coin One offers a lot of options for searching establishments. You can search by establishment categories, names, or even scan a QR Code offered by a specific business.</h5>
						</div>
					</div>
					<hr>
					<h1 class="heading-label heading-yellow text-center" style="font-size: 4em;">Who're subscribed to Coin One?</h1>
					<h3 class="heading-label text-center">Establishments that trusted us</h3>
					<div>
						<ul class="estab-sample">
							<li><img src="images/shakeys.jpg"></li>
							<li><img src="images/mcdo.jpg"></li>
							<li><img src="images/solaire.jpg"></li>
							<li><img src="images/robinsons.jpg"></li>
						</ul>
					</div>
					<br>
					<br>
					<div style="background: url('images/testi.png') no-repeat center center; width: 100%; height: 212px;"></div>
					<br>
					<hr>
					<br>
					<h3 class="heading-label text-center">Subscribe now and let others see your business. 
					<br>
					<br>
					<a href="<?php echo $session->is_logged_in() ? 'subscription.php' : 'registeruser.php';?>"><input style="letter-spacing: 2px; font-size: 1em" type="button" name="signup-now" class="btn btn-warning heading-label drop-shadow" value="Start Here"></h3></a>
					<br>
					<br>
				</div>
			</div>
		</div>
		<?php include '../includes/footer.php'; ?>
	</body>
</html>
