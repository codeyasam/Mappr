<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? redirect_to("index.php") : null; ?>
<?php
	//$image = file_get_contents("https://graph.facebook.com/949719171750373/picture"); // sets $image to the contents of the url
	//file_put_contents('DISPLAY_PICTURES/image.jpg', $image);   
	if (isset($_POST['submit'])) {
		$required_fields = array("first_name","last_name", "email","username", "password", "confPass");
		validate_presence($required_fields);	
		password_comparison($_POST['password'], $_POST['confPass']);
		if (empty($errors)) {
			$user = new User;
			$user->first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : "";
			$user->last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : "";		
			$user->username = isset($_POST['username']) ? trim($_POST['username']) : "";		
			$user->password = isset($_POST['password']) ? md5(trim($_POST['password'])) : "";
			$user->email = isset($_POST['email']) ? trim($_POST['email']) : "";
			$user->contact = isset($_POST['contact']) ? trim($_POST['contact']) : "";
			$user->hometown = isset($_POST['hometown']) ? trim($_POST['hometown']) : "";
			$user->user_type = "OWNER";

			if ($user->create()) {
				$content = isset($_POST['urlContent']) ? trim($_POST['urlContent']) : false;
				if ($content) {
					//$content = file_get_contents($content);
					//file_put_contents("DISPLAY_PICTURES/profile_pic".$user->id, $content);
					//$user->display_picture = "DISPLAY_PICTURES/profile_pic".$user->id;
					$user->display_picture = $content; 	
					//echo "here";
				} else if ($_FILES['img_upload']) {
					echo "<pre>";
						print_r($_FILES['img_upload']);
					echo "</pre>";
					move_uploaded_file($_FILES['img_upload']['tmp_name'], "DISPLAY_PICTURES/profile_pic".$user->id);
					$user->display_picture = "DISPLAY_PICTURES/profile_pic".$user->id;
					//echo "poop";
				}
				$user->update();		
				$session->login($user);
				redirect_to("subscription.php");
			}
 
		}	
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<style type="text/css">
			.regForm {
				width: 15%;
				margin: 0 auto;
			}
		</style>
	</head>
	<body>
		<?php include("../includes/navigation.php"); ?>
		<div class="regForm">
			<form action="registeruser.php" method="POST" enctype="multipart/form-data">
				<p><img id="output" class="circle" height="100px" width="100px" src=""/></p>
				<p><input type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/></p>
				<p><input id="fName" type="text" name="first_name" value="" required="required" placeholder="First name"/></p>
				<p><input id="lName" type="text" name="last_name" value="" required="required" placeholder="Last name"></p>
				<p><input id="userEmail" type="email" name="email" value="" required="" placeholder="Email"></p>
				<a id="facebookLogin" href="#">connect with facebook</a>  
				<p><input id="username" type="text" name="username" value="" required="required" placeholder="Username"/></p>
				<p><input id="password" type="password" name="password" value="" required="required" placeholder="Password"/></p>
				<p><input id="confPass" type="password" name="confPass" value="" required="required" placeholder="Confirm Password"/></p>
				<hr/>OPTIONAL
				<p><input type="text" name="contact" value="" placeholder="contact"/></p>
				<p><input id="hometown" type="text" name="hometown" value="" placeholder="hometown"/></p>
				<p><input id="urlContent" type="hidden" name="urlContent" value=""/></p>
				<p><input type="submit" name="submit" value="REGISTER"></p>
			</form>			
		</div>


		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
		<script type="text/javascript" src="js/myScript.js"></script>
		<script type="text/javascript">
			var loadFile = function(event) {
			   	var output = document.getElementById('output');
			   	output.src = URL.createObjectURL(event.target.files[0]);
			   	$('#urlContent').attr('value', "");
			};		
		    
		    $("#username").on('input', function() {
		        console.log("changing");
		        if (this.value.match(/[^a-zA-Z0-9_]/g)) {
		            this.value = this.value.replace(/[^a-zA-Z0-9_]/g, "");
		        }
		    });

	    
		</script>		
	</body>
</html>