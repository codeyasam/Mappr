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
	<body>
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="container center">
			<div class="featured" style="padding-top:0;background: url('images/map.jpg') top left; width: 1000px; height: 410px;">
				<div class="featured-message">
					<img src="images/pin.png" style="width:100px;float:left; margin-top: 20px; margin-left: 40px; padding: 10px;">
					<h1>Promote your business</h1>
					<p>Customers will be able locate your business with just a tap.</p>
				</div>
			</div>
			<section class="cyan featured">
				<h1>Let everybody know your business.</h1>
				<p style="text-align: center;font-size: 1.9em; margin-bottom:0px;">People are searching for your products and services let them locate you in real time.
				<br>
				<br>
				<img src="images/phone.png"> <img src="images/clock.png">&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/check.png"></p>
			</section>
			<section class="featured"  style="background:url('images/banner.png'); height: 317px;">
				<div class="featured-message">
					<h1>THE BEST WAY</h1>
					<p>To let your business grow.</p>
				</div>
			</section>
			<footer>
				<?php include '../includes/footer.php'; ?>
			</footer>
		</div>
	</body>
</html>