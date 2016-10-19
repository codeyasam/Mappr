<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "ADMIN" && $user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null; 
	$planDurations = PlanDuration::find_all();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../../includes/styles_admin.php'; ?>
		<link rel="stylesheet" type="text/css" href="../js/jquery-ui.css">
	</head>
	<body>
		<header>
			<div class="center">		
				<?php include("../../includes/admin_nav.php"); ?>
			</div>
		</header>
		<div class="container center clearfix">
			<h1>Plan Duration</h1>
			<table id="planDurationContainer" class="data">
				
			</table>

			<div class="manage" id="formContainer">
				<h2>Manage Plan Duration</h2>
				<p><input id="duration_name" type="text" name="duration_name" placeholder="Duration name"/></p>
				<p><input id="description" type="text" name="description" placeholder="Description"/></p>
				<p><input id="duration_visibility" type="checkbox" name="duration_visibility" value="Visible"/>Visible</p>
				<p><input id="optAdd" type="submit" value="+ADD CATEGORY"/><input id="optSave" type="submit" value="SAVE CHANGES"/><input id="optCancel" type="submit" value="CANCEL"/></p>
			</div>
			<div class="mLoadingEffect"></div>
			<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
			<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
			<script type="text/javascript" src="../js/functions.js"></script>
			<script type="text/javascript">

				processRequest("backendprocess.php?getPlanDurations=true");

				function handleServerResponse() {
					if (objReq.readyState == 4 && objReq.status == 200) {
						console.log(objReq.responseText);
						var jsonObj = JSON.parse(objReq.responseText);
						if (jsonObj.PlanDurations) {
							var tblRows = "<tr>";
							tblRows += "<th>ID</th><th>NAME</th><th>DESCRIPTION</th><th>VISIBILITY</th>";
							tblRows += '<th colspan="2">OPTION</th></tr>';
							tblRows += tableJSON("#planDurationContainer", jsonObj.PlanDurations, false);
							$("#planDurationContainer").append("<tbody>" + tblRows + "<tbody>");						
						} else if (jsonObj.planDurationSelected) {
							$('optSave').attr('data-internalid', jsonObj.id);
							$('#description').val(jsonObj.description);
							$('#duration_name').val(jsonObj.duration_name);	
							if (jsonObj.duration_visibility == "VISIBLE") 
								$('#duration_visibility').prop('checked', true);
							else 
								$('#duration_visibility').prop('checked', false);											
						}

						if (jsonObj.saveChangesPD) {
							$('#formContainer').hide();
							console.log("save changes pd");
							$('body').removeClass("mLoading");
							custom_alert_dialog("Successfully updated");
						}
					}
				}

				$('#formContainer').hide();
				$('#optSave').hide();
				$('#optCancel').hide();	

				$('#optAdd').on("click", function(e) {
					e.preventDefault();
					var description = $('#description').val().trim();
					var duration_name = $('#duration_name').val().trim();
					var duration_visibility = $('#duration_visibility').is(":checked") ? "VISIBLE" : "HIDDEN";
					if (description == "" || duration_name == "" || duration_visibility == "") return;
					console.log("poop");
					//processRequest("backendprocess.php?createPlanDuration=true&description="+description+"&duration_name="+duration_name+"&duration_visibility="+duration_visibility);
					processPOSTRequest("backendprocess.php", "createPlanDuration=true&description="+description+"&duration_name="+duration_name+"&duration_visibility="+duration_visibility);
				});	

				$(document).on('click', '.optDelete', function() {
					console.log($(this).attr("data-internalid"));
					var planDurationID = $(this).attr("data-internalid");
					//processRequest("backendprocess.php?deletePlanDuration=true&planDurationID=" + planDurationID);
					processPOSTRequest("backendprocess.php", "deletePlanDuration=true&planDurationID=" + planDurationID);
					return false;
				});	

				$(document).on('click', '.optEdit', function() {
					$('#formContainer').show();
					$('#duration_name').hide();

					$('#optAdd').hide();
					$('#optSave').show();
					$('#optCancel').show();
					var planDurationID = $(this).attr("data-internalid");
					$('#optSave').attr("data-internalid", planDurationID);
					processRequest("backendprocess.php?editPlanDuration=true&planDurationID=" + planDurationID);
					return false;
				});		

				$('#optCancel').on('click', function(e) {
					e.preventDefault();

					$('#optSave').hide();
					$('#optCancel').hide();	
					$('#optAdd').show();	

					$('#optSave').attr("data-internalid", "");
					$('#description').val("");
					$('#duration_name').val("");

					$('#duration_name').show();		
					$('#formContainer').hide();
				});

				$('#optSave').on('click', function(e) {
					e.preventDefault();
					var planDurationID = $(this).attr('data-internalid');
					var description = $('#description').val().trim();
					var duration_name = $('#duration_name').val().trim();
					var duration_visibility = $('#duration_visibility').is(":checked") ? "VISIBLE" : "HIDDEN";
					if (description == "" || duration_name == "" || duration_visibility == "") {
						custom_alert_dialog("Fill required field.");
						return;	
					}			
					$('#formContainer').hide();
					$('body').addClass("mLoading");
					//processRequest("backendprocess.php?saveChangesPD=true&planDurationID=" + planDurationID + "&description=" + description +"&duration_name="+duration_name+"&duration_visibility="+duration_visibility);
					processPOSTRequest("backendprocess.php", "saveChangesPD=true&planDurationID=" + planDurationID + "&description=" + description +"&duration_name="+duration_name+"&duration_visibility="+duration_visibility);	

					$('#optSave').hide();
					$('#optCancel').hide();	
					//$('#optAdd').show();

					$('#optSave').attr("data-internalid", "");
					$('#description').val("");
					$('#duration_name').val("");
				});										
			</script>	
		</div>			
		<footer class="container center">
			<?php include '../../includes/footer.php'; ?>
		</footer>	
	</body>
</html>