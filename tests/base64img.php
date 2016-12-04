<?php require_once("../includes/initialize.php"); ?>
<?php  
	// if (isset($_POST['image'])) {
	// 	echo '{"success":"' . $_POST['image'] . '"}';
	// 	$decodedImage = base64_decode($_POST['image']);
	// 	file_put_contents("../testImages/testImg.jpg", $decodedImage);
	// }
	// else echo '{"success":"false"}';


	if (isset($_POST['submit'])) {
		$user = new User();
		$user->first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : "";
		$user->last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : "";		
		$user->username = isset($_POST['username']) ? trim($_POST['username']) : "";		
		$user->password = isset($_POST['password']) ? md5(trim($_POST['password'])) : "";
		$user->email = isset($_POST['email']) ? trim($_POST['email']) : "";	
		if (!User::check_username_format($user->username)) { 	
			echo '{"success":"false", "msg":"Invalid username format. Cannot contain speial character other than underscore"}';
		} else if (User::check_existing($user->username, "username", "user already exists")) {
			echo '{"success":"false", "msg":"username already exists"}';
		} else if (User::check_existing($user->email, "email", "Email Address already exists.")) {
			echo '{"success":"false", "msg":"Email Address already exists."}';		
		} else if ($user->create()) {
			$user->verification_key = md5(time() . $user->id);
			if (isset($_POST['image'])) {
				$decodedImage = base64_decode($_POST['image']);
				file_put_contents("../Public/DISPLAY_PICTURES/profile_pic".$user->id, $decodedImage);
				$user->display_picture = MAPPR_PUBLIC_URL . "DISPLAY_PICTURES/profile_pic".$user->id;
			} else {
				$user->display_picture = $_POST['display_picture'];
			}	
			$user->update();
			Mailer::send_verification_code($user);
			MapprActLog::recordActivityLog("Registered to One Coin", $user->id);			
			echo '{"success":"true",' . $user->toJSON() . '}';		
		}
	} else {
		echo '{"success":"false"}';
	}
?>
