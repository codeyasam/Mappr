<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "ADMIN" ? redirect_to("../index.php") : null; 
	$planDurations = PlanDuration::find_all();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../../includes/styles_admin.php'; ?>
	</head>
	<body>
		<header>
			<div class="center">		
				<?php include("../../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container center clearfix">
			<div class="panel panel-warning clearfix">
				<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-time"></span> Manage Plan Duration</h1></div>
				<div class="panel-body">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</div>
				<div class="manage" id="formContainer" style="float: left; width: 30%">
					<!-- <div class="form-group">
						<label>Duration Name</label>
					</div> -->
					<div class="form-group">
						<input id="duration_name" type="text" class="form-control" name="duration_name" disable />
						<label>Description</label>
						<input id="description" type="text" class="form-control" name="description" />
					</div>
					<div class="form-group">
						<input id="duration_visibility" type="checkbox" name="duration_visibility" value="Visible"/> <label>Visible</label>
					</div>
					<div class="form-group">
						<input id="optCancel" type="submit" class="btn btn-warning" value="Cancel"/>
						<input id="optSave" type="submit" class="btn btn-primary" value="Save"/>
					</div>
				</div>

				<table id="planDurationContainer" class="data table table-hover" style="float: left; width: 99.5%">				
				</table>
			</div>
			

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
							tblRows += "<th>#</th><th>Name</th><th>Description</th><th>Visibility</th>";
							tblRows += '<th colspan="2">Option</th></tr>';
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
					$("#planDurationContainer").css({width: "99.5%"});
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
					$("#planDurationContainer").css({width: "69.5%"});
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
					$("#planDurationContainer").css({width: "99.5%"});
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
					if (description == "" || duration_name == "" || duration_visibility == "") return;				
					//processRequest("backendprocess.php?saveChangesPD=true&planDurationID=" + planDurationID + "&description=" + description +"&duration_name="+duration_name+"&duration_visibility="+duration_visibility);
					processPOSTRequest("backendprocess.php", "saveChangesPD=true&planDurationID=" + planDurationID + "&description=" + description +"&duration_name="+duration_name+"&duration_visibility="+duration_visibility);	

					$('#optSave').hide();
					$('#optCancel').hide();	
					$('#optAdd').show();
					$("#planDurationContainer").css({width: "99.5%"});

					$('#optSave').attr("data-internalid", "");
					$('#description').val("");
					$('#duration_name').val("");
				});										
			</script>	
		</div>			
		<?php include '../../includes/footer.php'; ?>
	</body>
</html>