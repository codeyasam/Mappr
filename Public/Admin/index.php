<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "ADMIN" ? redirect_to("../index.php") : null; 
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../../includes/styles_admin.php'; ?>
	</head>
	<body style="background: url('../images/bg.jpg') no-repeat bottom center;">
		<header>
			<div class="center">		
				<?php include("../../includes/navigation.php"); ?>
			</div>
		</header>
		<div style="background: #fff;" class="container page-wrap">
		</div>
		<?php include '../../includes/footer.php'; ?>
	</body>
</html>