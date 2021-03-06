<?php require_once("../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? redirect_to("index.php") : null; ?>
<?php 
	$prompt_to_user = "";
	if (isset($_GET['verificationNeeded'])) {
		$prompt_to_user = "<span class='glyphicon glyphicon-ok-sign'></span> An email was sent to your email address by Coin One. Follow the steps to verify your account.";
	} else if (isset($_GET['verfication'])) {
		$prompt_to_user = "<span class='glyphicon glyphicon-ok-sign'></span> Account Verified. You may now enter your credentials to login.";
	}
	
	if (isset($_POST['submit'])) {
		$emUsername = $_POST['emUsername'];
		$password = $_POST['password'];
		$user = User::isEmUsernameExist($emUsername);
		if (!empty($user->verification_key)) {
			$prompt_to_user = "<span class='glyphicon glyphicon-exclamation-sign'></span> Unverified account. Please check your email for verification process.";
		} else if ($user->account_status == "BLOCKED") {
			$prompt_to_user = "<span class='glyphicon glyphicon-remove-sign'></span> Account is currently blocked, <a href='mailto:coinone777@yahoo.com?Subject=Blocked%20User' target='_top'>contact</a> the super admin";	
			$user = null;			
		} else {
			$user = User::authenticate($emUsername, $password);
			
			if ($user) {
				if ($user->account_status == "ACTIVE") {
					$user->login_attempt = 0;
					$user->update();
					$session->login($user);
					//User::page_redirect($user->id);
					redirect_to("index.php");
				} else {
					$prompt_to_user = "<span class='glyphicon glyphicon-exclamation-sign'></span> Account is currently blocked, contact the super admin.";	
					$user = null;
				}
			} else {
				$prompt_to_user = "<span class='glyphicon glyphicon-remove-sign'></span> Wrong username or password";
				$found_user = new User();			
				if (User::hasExisting($emUsername, "email")) {
	 				$found_users = User::find_all(array('key'=>'email', 'value'=>$emUsername, 'isNumeric'=>false));
				} else if (User::hasExisting($emUsername, "username")) {
					$found_users = User::find_all(array('key'=>'username', 'value'=>$emUsername, 'isNumeric'=>false));
				}
				$found_user = !empty($found_users) ? array_shift($found_users) : false;
	
				if ($found_user && $found_user->user_type == "ADMIN" && $found_user->account_status == "ACTIVE") {
					$found_user->login_attempt += 1;
					if ($found_user->login_attempt >= 3) {
						$found_user->account_status = "BLOCKED";
					}
					$found_user->update();
				}
			}
		}
		
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
	<body style="background: url('images/bg.jpg') no-repeat center center;">
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="container page-wrap" style="background: none;">
			<div class="row homepage">
				<div class="login drop-shadow">
					<div class="text-center login-heading">
						<img src="images/coin_one_logo_large.png" class="pull-center" style="width: 50%; margin: -150px auto 0;">
						<h1 class="heading-label" style="font-size: 4em;">Coin One</h1>
					</div>
					<div class="offset-title">Establishment Locator</div>

					<form action="login.php" method="post">

						<?php if (!empty($prompt_to_user)): ?>
							<div class="alert alert-danger text-center" role="alert">
							  <strong>NOTICE:</strong>&nbsp;&nbsp;<?php echo strtoupper(substr($prompt_to_user, 0, 1)) . substr($prompt_to_user, 1); ?>.
							</div>							
						<?php endif ?>
						<!-- <div class="form-group">
				  			<label><h4><span class="glyphicon glyphicon-bookmark"></span> Login to continue</h4></label>
				  		</div>	 -->
						<div class="form-group">
				  			<label>ID</label>
				  			<input class="form-control" type="text" name="emUsername" value="" placeholder="Email or username"/>
				  		</div>	
						<div class="form-group">
				  			<label>Password</label>
				  			<input class="form-control" type="password" name="password" value="" placeholder="Password"/>
				  		</div>
				  		<div class="row form-group text-right">
				  			<div class="col col-md-7" style="margin: 2px 0 5px 0;">
					  			<a href="registeruser.php" title="Register"><span class="glyphicon glyphicon-tag"></span> Not yet a member?</a>
					  			<br>
					  			<a id="forgotPass" href="">Forgot password?</a>
				  			</div>
				  			<div class="col col-md-5"><input style="width:100%" class="btn btn-primary" type="submit" name="submit" value="Login"/></div>
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

			$('div.alert').on('click',function () {
				$(this).slideUp(500);
			});

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
