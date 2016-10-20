<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? redirect_to("index.php") : null; ?>
<?php 
	$prompt_to_user = "";
	if (isset($_POST['submit'])) {
		$emUsername = $_POST['emUsername'];
		$password = $_POST['password'];
		$user = User::authenticate($emUsername, $password);
		
		if ($user) {
			$session->login($user);
			User::page_redirect($user->id);
		}
		$prompt_to_user = "wrong username or password";
	}
?>

<?php  
	if (isset($_POST['emailOkBtn'])) {
		$email = trim($_POST['email']);
		if (User::hasExisting($email, "email")) {
			$session->message("codeSent");
			$_SESSION['email'] = $email;
			$result_array = User::find_all(array('key'=>'email', 'value'=>$email, 'isNumeric'=>false));
			$found_user = array_shift($result_array);
			$found_user->reset_code = User::getRandomResetCode();
			$found_user->update();
			Mailer::send_reset_code($found_user);
		} else {
			$session->message("notExist");
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../includes/styles.php'; ?>
		<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>		
	</head>
	<body style="background: url('images/bg.jpg') no-repeat bottom center;">
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="container page-wrap" style="background: none;">
			<div class="row homepage">
				<div class="login">
					<div class="text-center" style="position: absolute; top: -250px; left: 0; background: none;"><img src="images/coin_one_logo.png" style="width: 50%;"></div>
					<div class="text-center" style="font-family: Impact; width: 100%; position: absolute; top: -110px; left: 0; background: none;"><h1>Coin One</h1></div>
					<div class="offset-title"><span class="glyphicon glyphicon-log-in"></span> Login to continue:</div>
					<form action="login.php" method="post">
						<div class="form-group alert-danger" role="alert">
							<b><?php echo $prompt_to_user; ?></b>
						</div>
						<div class="form-group">
				  			<label>ID:</label>
				  			<input class="form-control" type="text" name="emUsername" value="" placeholder="Email/Username"/>
				  		</div>	
						<div class="form-group">
				  			<label>Password:</label>
				  			<input class="form-control" type="password" name="password" value="" placeholder="Password"/>
				  			<p><a id="forgotPass" href="">fortgot password</a></p>
				  		</div>
				  		<div class="row form-group">
				  			<div class="col col-md-7"></div>
				  			<div class="col col-md-5"><input class="form-control btn btn-primary" type="submit" name="submit" value="Login"/></div>
				  		</div>
					</form>
				</div>
			</div>
		</div>
		<div id="dialogEmail" style="display: none;" title="Enter your email">
			<p>We'll send a reset code to your email address</p>
			<form action="login.php" method="POST">
				<p><input id="email" type="email" name="email" placeholder="email address" required="required"></p>
				<input id="emailOkBtn" type="submit" name="emailOkBtn" value="SEND">
				<input id="emailCancel" type="submit" name="" value="CANCEL">	
			</form>
		</div>

		<div id="dialogChangePass" style="display: none;" title="Reset Password">
			<p>Reset Code Sent! Check your email then change your password.</p>	
			<p><input id="resetCodeTxt" type="text" name="resetCodeTxt" placeholder="enter reset code"></p>
			<p><input id="newPassword" type="password" name="" placeholder="new password" /></p>
			<p><input id="confPass" type="password" name="" placeholder="confirmPassword"></p>
			<input id="resetPass" type="submit" name="" value="RESET PASSWORD" />
			<input id="cancelReset" type="submit" name="" value="CANCEL" />
		</div>

		<div class="mLoadingEffect"></div>
		<input id="fpStatus" type="hidden" name="" value="<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ""; ?>"/>
		<input id="storedEmail" type="hidden" name="" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ""; ?>">
		<?php include '../includes/footer.php'; ?>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript">
			$('#dialogEmail').dialog({
				autoOpen: false,
				modal: true
			});	

			$('#dialogChangePass').dialog({
				autoOpen: false,
				modal: true
			});

			$('#emailCancel').on('click', function() {
				$('#dialogEmail').dialog('close');
			});

			$('#emailOkBtn').on('click', function() {
				//$('body').addClass('mLoading');
			});

			$('#forgotPass').on('click', function() {
				$('#email').val("");
				$('#dialogEmail').dialog('open');
				return false;
			});

			$('#cancelReset').on('click', function() {
				$('#dialogChangePass').dialog('close');
			});

			if ($('#fpStatus').val() == "codeSent") {
				$('#dialogChangePass').dialog('open');
			} else if ($('#fpStatus').val() == "notExist") {
				custom_alert_dialog("Email address doensn't exist");
			}

			$('#resetPass').on('click', function() {
				var resetCode = $('#resetCodeTxt').val();
				var newPassword = $('#newPassword').val();
				var confPass = $('#confPass').val();
				var email = $('#storedEmail').val();

				if (resetCode == "" || newPassword == "" || confPass == "") {
					custom_alert_dialog("Fill all fields.");
					return;
				} else if (newPassword != confPass) {
					custom_alert_dialog("Passwords dont match");
					return;
				}
				$('body').addClass('mLoading');
				processPOSTRequest("forgotPassword.php", "resetPass=true&" + "email=" + email + "&reset_code=" + resetCode + "&newPassword=" + newPassword);
			});

			function handleServerResponse() {
				if (objReq.readyState == 4 && objReq.status == 200) {
					console.log(objReq.responseText);
					var jsonObj = JSON.parse(objReq.responseText);
					if (jsonObj.forgotPass) {
						$('body').removeClass('mLoading');
						if (jsonObj.forgotPass == "true") {
							$('#dialogChangePass').dialog('close');
							custom_alert_dialog("You've changed your password successfully");
						} else {
							custom_alert_dialog('Wrong reset code. Please check your email again.');
						}
					}
				}
			}
 		</script>		
	</body>
</html>