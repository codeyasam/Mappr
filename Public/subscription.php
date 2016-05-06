<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : false; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>asdfs</title>
	</head>
	<body>
		<?php include("../includes/navigation.php") ?>
		<?php include("subscriptiondurations.php"); ?>
	</body>
</html>