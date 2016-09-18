<?php require_once("../includes/initialize.php"); ?>
<?php  
	$user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to('login.php');
?>
<?php  
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
		<form action="accountsettings.php" method="POST" enctype="multipart/form-data">
			<p><img id="output" class="circle" height="100px" width="100px" src="<?php echo htmlentities($user->display_picture); ?>"/></p>
			<p><input type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/></p>
			<p>First Name: <input id="fName" type="text" name="first_name" value="<?php echo cym_decode_unicode($user->first_name); ?>" required="required" placeholder="First name"/></p>
			<p>Last Name: <input id="lName" type="text" name="last_name" value="<?php echo cym_decode_unicode($user->last_name); ?>" required="required" placeholder="Last name"></p>
			<p>Email: <?php echo htmlentities($user->email); ?></p>  
			<p>Username: <?php echo htmlentities($user->username); ?></p>
			<hr/>OPTIONAL
			<p><input type="text" name="contact" value="<?php echo htmlentities($user->contact); ?>" placeholder="contact"/></p>
			<p><input id="hometown" type="text" name="hometown" value="<?php echo htmlentities($user->hometown); ?>" placeholder="hometown"/></p>
			<p><input id="submit" type="submit" name="submit" value="EDIT PROFILE"></p>
		</form>

		<div id="changePassDialog" style="display: none;" title="CHANGE PASSWORD">
			<table>
				<tr>
					<td>Old Password: </td>
					<td><input id="oldPass" type="password" name=""/></td>
				</tr>
				<tr style="display: none;">
					<td></td>
					<td id="noticeOld"></td>
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
					<td></td>
					<td id="noticeConf"></td>
				</tr>
			</table>
		</div>
		<input type="submit" id="changePass" value="CHANGE PASSWORD"/>

		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
		<script type="text/javascript" src="js/functions.js"></script>			
		<script type="text/javascript">

			function handleServerResponse() {
				if (objReq.readyState == 4 && objReq.status == 200) {
					console.log(objReq.responseText.trim());
					var jsonObj = JSON.parse(objReq.responseText);

					if (jsonObj.changePass) {
						if (jsonObj.changePass == "true") {
							alert("successfully changed the password.");
							$('#changePassDialog').dialog('close');
						} else {	
							alert("wrong old password");
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
					  	text: "SAVE",
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