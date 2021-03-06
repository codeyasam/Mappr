<?php require_once("../includes/initialize.php"); ?>
<?php  
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to('login.php');
?>
<?php  
	$prompt_to_user = "";
	if (isset($_POST['submit'])) {
		$user->first_name = trim($_POST['first_name']);
		$user->last_name = trim($_POST['last_name']);		
		$user->contact = trim($_POST['contact']);
		$user->hometown = trim($_POST['hometown']);
		
		if (file_exists($_FILES['img_upload']['tmp_name']) && is_uploaded_file($_FILES['img_upload']['tmp_name'])) {
			move_uploaded_file($_FILES['img_upload']['tmp_name'], "DISPLAY_PICTURES/profile_pic".$user->id);
			$user->display_picture = MAPPR_PUBLIC_URL . "DISPLAY_PICTURES/profile_pic".$user->id;			
		}
		$user->update();	

		MapprActLog::recordActivityLog("Edited Profile", $user->id);
		$prompt_to_user = "<span class='glyphicon glyphicon-ok-sign'></span> Changes been made";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title> 
		<?php include '../includes/styles.php'; ?>
		<link rel="stylesheet" type="text/css" href="js/jquery_timeentry/jquery.timeentry.css"/>
		<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>		
	</head>
	<body>
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container center">
			<div class="panel panel-default drop-shadow">
				<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-pencil"></span> Edit Profile</h1></div>
				<div class="solo-form panel-body pull-center">
					<form action="accountsettings.php" method="POST" enctype="multipart/form-data">
						<?php if (!empty($prompt_to_user)): ?>
							<div class="alert alert-danger text-center" role="alert">
							  <strong>NOTICE:</strong>&nbsp;&nbsp;<?php echo strtoupper(substr($prompt_to_user, 0, 1)) . substr($prompt_to_user, 1); ?>.
							</div>							
						<?php endif ?>

						<table style="width:100%;max-width: 700px;">
							<tr>
								<td class="text-center" colspan="100%">
									<div class="round-image text-center drop-shadow" style="display:inline-block; text-align:center; width: 125px; height: 125px; overflow: hidden;">
										<img id="output" style="height: 150px; margin-left: -10%;" src="<?php echo htmlentities($user->display_picture); ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<label>Display Photo</label>
									<input type="file" class="" name="img_upload" accept="image/*" onchange="loadFile(event)"/>
								</td>
							</tr>
							<tr><td colspan="100%"><hr></td></tr>
							<tr>
								<td colspan="100%">
									<h3 style="font-variant: small-caps;"><b><span class="glyphicon glyphicon-log-in"></span> Account Details</b></h3>
								</td>
							</tr>
							<tr>
								<td colspan="100%">
									<label>E-mail Address:</label> <?php echo htmlentities($user->email); ?>
									<br>
									<label>Username:</label> <?php echo cym_decode_unicode($user->username); ?>
								</td>
							</tr>
							<tr><td colspan="100%"><hr></td></tr>
							<tr>
								<td colspan="100%">
									<h3 style="font-variant: small-caps;"><b><span class="glyphicon glyphicon-user"></span> Personal Information</b></h3>
								</td>
							</tr>
							<tr>
								<td>
									<input id="fName" placeholder="First Name" class="form-control" type="text" name="first_name" value="<?php echo cym_decode_unicode($user->first_name); ?>" required="required"/>
								</td>
								<td>
									<input id="lName" placeholder="Last Name" class="form-control" type="text" name="last_name" value="<?php echo cym_decode_unicode($user->last_name); ?>" required="required">
								</td>
							</tr>
							<tr><td colspan="100%"><hr></td></tr>
							<tr>
								<td colspan="100%">
									<h3 style="font-variant: small-caps;"><b><span class="glyphicon glyphicon-equalizer"></span> Optional</b></h3>
								</td>
							</tr>
							<tr>
								<td>
									<input type="text" placeholder="Contact No." class="form-control" name="contact" value="<?php echo cym_decode_unicode($user->contact); ?>"/>
								</td>
								<td>
									<input id="hometown" placeholder="Hometown" class="form-control" type="text" name="hometown" value="<?php echo cym_decode_unicode($user->hometown); ?>"/>
								</td>
							</tr>

							<tr>
								<td>
									<input class="btn btn-primary" style="display: inline-block; width: 100%;" id="submit" type="submit" name="submit" value="Save Changes">
								</td>
								<td>
									<input class="btn btn-info" style="display: inline-block; width: 100%;" type="submit" id="changePass" value="Change Password"/>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<div id="changePassDialog" style="display: none;" title="CHANGE PASSWORD">
				<table>
					<tr>
						<td>Old Password: </td>
						<td><input id="oldPass" type="password" name=""/></td>
					</tr>
					<tr style="display: none;">
						<td colspan="100%" id="noticeOld"></td>
					</tr>
					<tr>
						<td>New Password: </td>
						<td><input id="newPass" type="password" name=""/></td>
					</tr>
					<tr>
						<td>Confirm Password: </td>
						<td><input id="confPass" type="password" name=""/></td>	
					</tr>
					<tr>
						<td colspan="100%" id="noticeConf"></td>
					</tr>
				</table>
			</div>
		</div>

		
		<?php include '../includes/footer.php'; ?>


		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
		<script type="text/javascript" src="js/functions.js"></script>			
		<script type="text/javascript">

			var loadFile = function(event) {
			   	var output = document.getElementById('output');
			   	output.src = URL.createObjectURL(event.target.files[0]);
			   	$('#urlContent').attr('value', "");
			};		

			function handleServerResponse() {
				if (objReq.readyState == 4 && objReq.status == 200) {
					console.log(objReq.responseText.trim());
					var jsonObj = JSON.parse(objReq.responseText);

					if (jsonObj.changePass) {
						if (jsonObj.changePass == "true") {
							//alert("successfully changed the password.");
							custom_alert_dialog("Successfully Changed the password");
							$('#changePassDialog').dialog('close');
						} else {	
							//alert("Invalid old password!");
							custom_alert_dialog("Invalid old password");
						}
					}					
				}
			}

			function setupChangePassDialog(action_performed) {
				$('#changePassDialog').dialog({
					autoOpen: false,
					width: 400,
					modal: true,
					buttons : [{
						text: "Cancel",
					    click : function() {
					    	$(this).dialog("close");
					    },  
					  }, {
					  	text: "Save",
					  	"id": "changePassBtn",
					  	click: action_performed,
					  }],
					  close: function() {
					  	$(this).dialog('close');
					  }
				});				
			}

			$('#changePass').on('click', function() {
				console.log("clicked");

				var action_performed = function() {
					changePassword();
				};

				setupChangePassDialog(action_performed);
				$('#changePassDialog').dialog('open');
				return false;
			});

			function changePassword() {
				var oldPass = $('#oldPass').val();
				var newPass = $('#newPass').val();
				var confPass = $('#confPass').val();

				if (oldPass == "" || newPass == "" || confPass == "") {
					alert("fill all required fields");
					return;
				} else if (newPass != confPass) {
					alert("passwords dont match");
					return;
				} 					

				processPOSTRequest("changePass.php", "changePass=true&oldPass=" + oldPass + "&newPass=" + newPass);
				
			}

			$('#newPass').on('blur', function() {
				password_comparison();
			});

			$('#confPass').on('blur', function() {
				password_comparison();
			});

		    function password_comparison() {
		    	if ($('#confPass').val() != "" && $('#newPass').val() != "") {
		    		var password = $('#newPass').val();
		    		var confPass = $('#confPass').val();
		    		if (password != confPass) {
		    			console.log("passwords dont match");
		    			$('#noticeConf').text("passwords don't match");
		    			return false;
		    		}
		    		$('#noticeConf').text("");
		    		return true;
		    	}
		    	return null;
		    }


		</script>
	</body>
</html>
