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
	<body style="background: url('images/bg.jpg') no-repeat bottom center;">
		<header class="center">
			<?php include("../includes/navigation.php"); ?>
		</header>
		<div style="background: #fff;" class="container page-wrap">
			<div class="row homepage">
			<?php if($session->is_logged_in()) { ?>
				
			<?php } else { ?>
					
					<div class="col col-md-12">
						<h1>Let others find your business.</h1>
						<p><a href="registeruser.php">Register</a> now to know more.</p>
						<p>Already have an account? Login <a href="login.php">here</a>.</p>
					</div>

					<div class="col col-md-12">
						<div class="row col-3">

							<div class="col col-md-4">
								<h2>Great Exposure</h2>
								<p class="text-justify">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
								tempor incididunt ut labore et dolore magna aliqua.
								</p>
							</div>

							<div class="col col-md-4">
								<h2>Affordable Subscriptions</h2>
								<p class="text-justify">
								Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip 
								consequat.
								</p>
							</div>

							<div class="col col-md-4">
								<h2>Efficient</h2>
								<p class="text-justify">
								Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
								</p>
							</div>

						</div>
					</div>
					<div class="col col-md-12">
						<div class="row"></div>
					</div>
			<?php } ?>
			</div>
			<?php // include '../includes/carousel.php'; ?>
		</div>
		<?php include '../includes/footer.php'; ?>
	</body>
</html>