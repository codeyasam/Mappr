<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "ADMIN" && $user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null; 
	$plans = Plan::find_all();
	$planDurations = PlanDuration::find_all();
	//$planDurations = array("daily", "monthly", "yearly", "weekly");
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
				<?php include("../../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container center clearfix">
			<div class="panel panel-warning clearfix drop-shadow">
				<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-list-alt"></span> Manage Plans</h1></div>
				<div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>


				<div class="manage" style="float: left; width: 25%;">
					<form>
						<div class="form-group">
							<label>Interval</label>
							<select id="planDuration" class="form-control" name="planDuration">
							<?php foreach($planDurations as $key => $eachDuration): ?>
								<option value="<?php echo $eachDuration->id; ?>"><?php echo strtoupper(substr($eachDuration->description, 0,1)) . substr($eachDuration->description, 1); ?></option>
							<?php endforeach; ?>	
							</select>					
						</div>
						<div class="form-group" id="customPlan">
							<input id="intervalCount" type="number" min="1" value="1" />
							<select id="customPlanDuration">
								<?php $not_included = array('year', 'other'); ?>
								<?php foreach($planDurations as $key => $eachDuration): ?>
									<?php if (!in_array($eachDuration->duration_name, $not_included)) { ?>
									<option value="<?php echo $eachDuration->id; ?>"><?php echo $eachDuration->duration_name; ?></option>
									<?php } ?>
								<?php endforeach; ?>			
							</select>
						</div>
						<div class="form-group">
							<label>Plan Name</label>
							<input class="form-control" id="plan_name" type="text" name="plan_name" />
						</div>
						<div class="form-group">
							<label>No. of Establishments</label>
							<input id="estab_no" class="form-control" type="number" min="1" value="1" name="estab_no" />
						</div>
						<div class="form-group">
							<label>No. of Branches Per Establishment</label>
							<input id="branch_no" class="form-control" type="number" min="1" value="1" name="branch_no" />
						</div>
						<div class="form-group">
							<label>Cost</label>
							<input id="cost" type="number" min="1" value="1" name="cost" class="form-control" />
						</div>
						<div class="form-group">
							<input id="visibility" type="checkbox" name="visibility" value="Visible"/> <label>Visible</label>
						</div>
						<div class="form-group">
							<input id="optAdd" class="btn btn-primary" type="submit" value="+ Add Plan"/>
							<input id="optCancel" class="btn btn-warning" type="submit" value="Cancel"/>
							<input id="optSave" class="btn btn-primary" type="submit" value="Save"/>
						</div>
					</form>
				</div>
				<table id="planContainer" class="data table table-hover drop-shadow" style="float:left; width: 73%;">
				</table>
			</div>
		</div>
		<div class="mLoadingEffect"></div>
		<?php include '../../includes/footer.php'; ?>
			<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
			<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
			<script type="text/javascript" src="../js/functions.js"></script>			
			<script type="text/javascript">
				processRequest("backendprocess.php?getPlans=true");
				
				$('#customPlan').hide();
				$('#planDuration').change(function() {
					$('#customPlan').hide();
					//console.log("plan duration changes" + $('#planDuration option:selected').text());
					if ($('#planDuration option:selected').val() == 5) {
						$('#customPlan').show();
						//console.log("custom plan");
					}
				});

				function handleServerResponse() {
					if (objReq.readyState == 4 && objReq.status == 200) {
						console.log(objReq.responseText);	
						var jsonObj = JSON.parse(objReq.responseText);
						
						if (jsonObj.createdPlan) {
							$('#estab_no').val('');
							$('#branch_no').val('');
							$('#cost').val('');
							$('#intervalCount').val('');
							$('#plan_name').val('');		
							custom_alert_dialog("Successfully created a plan");
							$('body').removeClass('mLoading');
							console.log("created a plan");
						}

						if (jsonObj.Plans) {
							var tblRows = "<tr>";
							tblRows += "<th>#</th><th>Name</th><th>Interval</th><th>No. of Establishment</th><th>No. of Branches</th><th>Cost</th><th>Visibility</th>";
							tblRows += '<th colspan="2">Options</th></tr>';
							tblRows += tableJSON("#planContainer", jsonObj.Plans);
							$("#planContainer").append("<tbody>" + tblRows + "<tbody>");
							if (jsonObj.planUpdated) {
								$('body').removeClass('mLoading');
								custom_alert_dialog("Successfully updated plan.");
							}
						} else if (jsonObj.planSelected) {
							$('#planDuration').val(jsonObj.plan_interval);
							$('#estab_no').val(jsonObj.estab_no);
							$('#branch_no').val(jsonObj.branch_no);
							$('#cost').val(jsonObj.cost);
							$('#plan_name').val(jsonObj.plan_name);
							if (jsonObj.visibility == "VISIBLE") 
								$('#visibility').prop('checked', true);
							else 
								$('#visibility').prop('checked', false);

							if ($('#planDuration option:selected').text() == "custom") {
								$('#customPlan').show();
								$('#customPlanDuration').val(jsonObj.custom_interval);
								$('#intervalCount').val(jsonObj.interval_count);
								//console.log("custom plan");
							} else {
								$('#customPlan').hide();
							}							
						} 

						if (jsonObj.hasPlanDeleteError) {
							$('body').removeClass("mLoading");
							if (jsonObj.hasPlanDeleteError == "true") {
								custom_alert_dialog("Can't delete this plan, a customer is currently subscribed to this plan.");
							} else {
								custom_alert_dialog("Successfully deleted plan.");
							}

						} else if (jsonObj.createError) {
							$('body').removeClass('mLoading');
							custom_alert_dialog("Cannot add a new plan. Check you internet connection.");
						}

					}				
				}

				$('#optSave').hide();
				$('#optCancel').hide();	

				$('#optAdd').on("click", function(e) {
					e.preventDefault();
					var durationID = $('#planDuration').val();
					var plan_name = $('#plan_name').val();
					var estab_no = $('#estab_no').val().trim();
					var branch_no = $('#branch_no').val().trim();
					var cost = $('#cost').val().trim();
					var visibility = $('#visibility').is(":checked") ? "VISIBLE" : "HIDDEN";
					var interval_count = $('#intervalCount').val();	
					var customDuration = "";			
					// console.log(durationID);
					// console.log(visibility);
					if ($('#planDuration option:selected').text() == "custom") {
						//console.log("yeah yeah");
						if ($('#intervalCount').val().trim() == "") {  
							custom_alert_dialog("Fill all required fields");
							return; 
						}
						else customDuration = $('#customPlanDuration option:selected').text();
					} 

					if (durationID == "" || estab_no == "" || branch_no == "" || cost == "" || plan_name == "") { 
						custom_alert_dialog("Fill all required fields");
						return; 
					}
					$('body').addClass('mLoading');
				    //console.log("poop");
					//processRequest("backendprocess.php?createPlan=true&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name);
					processPOSTRequest("backendprocess.php", "createPlan=true&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name
						+"&interval_count="+interval_count+"&interval="+customDuration);
				});	

				$(document).on('click', '.optDelete', function() {
					console.log($(this).attr("data-internalid"));
					var planID = $(this).attr("data-internalid");
					//processRequest("backendprocess.php?deletePlan=true&planID=" + planID);
					var action_performed = function() {
						processPOSTRequest("backendprocess.php", "deletePlan=true&planID=" + planID);	
						$('#dialog').dialog('close');
						$('body').addClass('mLoading');
					}

					confirm_action("Are you sure to delete this subscription?", action_performed);
					//processPOSTRequest("backendprocess.php", "deletePlan=true&planID=" + planID);
					return false;
				});	

				$(document).on('click', '.optEdit', function() {
					//Hides uneditable fields
					//$('#interval').hide();
					// $('#estab_no').hide();
					// $('#branch_no').hide();
					// $('#cost').hide();
					//end of hiding fields

					//Disable fields
					$('#estab_no').prop('disabled', true);
					$('#branch_no').prop('disabled', true);
					$('#cost').prop('disabled', true);
					$('#planDuration').prop('disabled', true);
					$('#customPlanDuration').prop('disabled', true);
					$('#intervalCount').prop('disabled', true);
					//disable fields

					$('#optAdd').hide();
					$('#optSave').show();
					$('#optCancel').show();
					var planID = $(this).attr("data-internalid");
					$('#optSave').attr("data-internalid", planID);
					processRequest("backendprocess.php?editPlan=true&planID=" + planID);
					return false;
				});	

				$('#optCancel').on('click', function(e) {
					e.preventDefault();
					$('#optSave').hide();
					$('#optCancel').hide();	
					$('#optAdd').show();	

					$('#optSave').attr("data-internalid", "");
					$('#estab_no').val("");
					$('#branch_no').val("");
					$('#cost').val("");
					$('#visibility').prop('checked', false);	
					$('#intervalCount').val("");
					$('#plan_name').val("");
					//show the fields
					// $('#interval').show();
					// $('#estab_no').show();
					// $('#branch_no').show();
					// $('#cost').show();	

					//enable fields
					$('#estab_no').prop('disabled', false);
					$('#branch_no').prop('disabled', false);
					$('#cost').prop('disabled', false);
					$('#planDuration').prop('disabled', false);			
					$('#customPlanDuration').prop('disabled', false);
					$('#intervalCount').prop('disabled', false);				
				});

				$('#optSave').on('click', function(e) {
					e.preventDefault();
					var planID = $('#optSave').attr("data-internalid");
					var durationID = $('#planDuration').val();
					var estab_no = $('#estab_no').val().trim();
					var branch_no = $('#branch_no').val().trim();
					var cost = $('#cost').val().trim();
					var plan_name = $('#plan_name').val().trim();
					var visibility = $('#visibility').is(":checked") ? "VISIBLE" : "HIDDEN";
					// console.log(durationID);
					// console.log(visibility);
					if (durationID == "" || estab_no == "" || branch_no == "" || cost == "" || plan_name == "") { 
						custom_alert_dialog("Fill all required fields");
						return; 
					}				
					$('body').addClass('mLoading');
					//processRequest("backendprocess.php?saveChangesPL=true"+"&planID="+planID+"&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name);
					processPOSTRequest("backendprocess.php", "saveChangesPL=true"+"&planID="+planID+"&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name);

					$('#planDuration').prop('disabled', false);
					$('#customPlanDuration').prop('disabled', false);
					$('#intervalCount').prop('disabled', false);
					$('#intervalCount').val("");
					$('#plan_name').val("");

					$('#optSave').hide();
					$('#optCancel').hide();	
					$('#optAdd').show();

					$('#optSave').attr("data-internalid", "");
					$('#estab_no').val("");
					$('#branch_no').val("");
					$('#cost').val("");
					$('#visibility').prop('checked', false);
				});									
			</script>
	</body>
</html>