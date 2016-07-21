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
	<body>
		<header>
			<div class="center">		
				<?php include("../../includes/admin_nav.php"); ?>
			</div>
		</header>
		<footer class="container center">
			<?php include '../../includes/footer.php'; ?>
		</footer>
	</body>
</html>