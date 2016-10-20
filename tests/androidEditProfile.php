<?php require_once("../includes/initialize.php"); ?>
<?php  
	if (isset($_POST['submit'])) {
		$user = User::find_by_id($_POST['userId']);
		$user->first_name = trim($_POST['firstName']);
		$user->last_name = trim($_POST['lastName']);

		if (isset($_POST['image'])) {
			$decodedImage = base64_decode($_POST['image']);
			file_put_contents("../Public/DISPLAY_PICTURES/profile_pic".$user->id, $decodedImage);
			$user->display_picture = MAPPR_PUBLIC_URL . "DISPLAY_PICTURES/profile_pic".$user->id;
		} else {
			$user->display_picture = $_POST['display_picture'];
		}
		$user->update();
		echo '{"success":"true"}';
	} else {
		echo '{"success":"false"}';
	}

	// echo '{"success":"false", "userId": "' . $_POST['userId'] . '"}';

?>