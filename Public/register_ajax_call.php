<?php require_once("../includes/initialize.php"); ?>
<?php  
	$output = "{";
	if (isset($_GET['hasExisting'])) {
		$result = isset($_GET['hasUsername']) ? User::check_existing($_GET['hasUsername'], "username", "has existing username") : User::check_existing($_GET['hasEmail'], "email", "has existing email address");
		$output .=  isset($_GET['hasUsername']) ? '"hasUsername":' : '"hasEmail":';
		$output .= $result ? '"true"' : '"false"';
	} 	

	$output .= "}";
	echo $output;
?>