<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : false; ?>
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
		<div class="banner"></div>
		<div class="container center clearfix">
			<?php include("subscriptiondurations.php"); ?>
		</div>
		<?php include '../includes/footer.php'; ?>
	</body>
</html>