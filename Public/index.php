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
		<header class="center">
			<?php include("../includes/navigation.php"); ?>
		</header>
		<?php if($session->is_logged_in()) { ?>
			<div class="banner"></div>
			<div style="background: #fff;" class="container page-wrap">
				<div class="row">
					<div class="col col-sm-12 text-center">
						<h1 style="font-size: 10em; margin-top: 20px;" class="glyphicon glyphicon-map-marker"></h1>
						<h1 class="heading-label">Coin One</h1>
						<h3 style="width: 100%; background: #333; color: #fff; padding: 20px;"><span class="glyphicon glyphicon-pushpin"></span> 3 Easy Steps</h3>
					</div>
				</div>
				<div class="row text-center">
					<div class="col col-sm-4" style="padding: 15px;">
						
						<h1 style="font-size: 5em;"><span class="glyphicon glyphicon-shopping-cart"></span> </h1>
						<h1 class="heading-label">Step 1</h1>
						<p></p>
					</div>
					<div class="col col-sm-4" style="padding: 15px;">
						
						<h1 style="font-size: 5em;"><span class="glyphicon glyphicon-info-sign"></span> </h1>
						<h1 class="heading-label">Step 2</h1>
						<p></p>
					</div>
					<div class="col col-sm-4" style="padding: 15px;">
						
						<h1 style="font-size: 5em;"><span class="glyphicon glyphicon-map-marker"></span> </h1>
						<h1 class="heading-label">Step 3</h1>
						<p></p>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div style="background: url('images/banner_bg.png') no-repeat center center; height: 500px; width: 100%;"></div>
			<div style="background: #fff; padding: 0;" class="container page-wrap">
				<div class="row">
					<div class="col col-sm-12 text-center">
						<h1 style="font-size: 10em;" class="glyphicon glyphicon-map-marker"></h1>
						<h1>Coin One</h1>
						<p style="padding: 50px 200px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
				</div>
				<hr style="width:95%;">
				<div style="height: 300px; overflow: hidden; position: relative;">
					<img src="images/bg.jpg" style="width: 100%; bottom: 0; position: absolute;">
					<div class="pull-center" style="background: rgba(100,3,3,.5); color: #fff; height: 100px; width: 100%; position: absolute; top: 50%; padding: 10px 50px;">
						<blockquote style="font-size: 2em; font-style: italic; border: 0;" class="text-center">
							"The application was great, it raised my sales up to 150%"
							<br>
							<span class="pull-right">- Aljon Cruz</span>
						</blockquote>
					</div>
					<div style="opacity: .3;"><img src="images/quotes_2.png" style="position: absolute; left: 50px; top: 75px;"></div>
				</div>
				<hr style="width:95%;">
				<div class="row">
					<div class="col col-sm-4">
						<div style="padding: 50px;" class="text-center">
							<h1 style="font-size: 5em; color: #a20000;" class="glyphicon glyphicon-screenshot"></h1>
							<h1>Accurate</h1>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="col col-sm-4">
						<div style="padding: 50px;" class="text-center">
							<h1 style="font-size: 5em; color: #61adff;" class="glyphicon glyphicon-thumbs-up"></h1>
							<h1>Efficient</h1>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="col col-sm-4">
						<div style="padding: 50px;" class="text-center">
							<h1 style="font-size: 5em; color: #d8bc2e;" class="glyphicon glyphicon-yen"></h1>
							<h1>Affordable</h1>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<hr>
				</div>
			</div>
		<?php } ?>
		<?php include '../includes/footer.php'; ?>
	</body>
</html>