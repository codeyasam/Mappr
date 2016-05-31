<?php  
	if (isset($_POST['testlang'])) {
		echo "poop";
		print_r($_FILES['file']);	
		$path = $_FILES['file']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		echo $ext;	
	}

?>