<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "ADMIN" ? redirect_to("../index.php") : null; 
	$plans = Plan::find_all();
	$planDurations = PlanDuration::find_all();
	//$planDurations = array("daily", "monthly", "yearly", "weekly");
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<?php include("../../includes/admin_nav.php"); ?>
		<table id="planContainer" border="1">
			
		</table>
		<div>
			<p>Interval: <select id="planDuration" name="planDuration">
			<?php foreach($planDurations as $key => $eachDuration): ?>
				<option value="<?php echo $eachDuration->id; ?>"><?php echo $eachDuration->description; ?></option>
			<?php endforeach; ?>	
			</select></p>
			<p id="customPlan">
				<input id="intervalCount" type="number" min="1"/>
				<select id="customPlanDuration">
					<?php $not_included = array('year', 'other'); ?>
					<?php foreach($planDurations as $key => $eachDuration): ?>
						<?php if (!in_array($eachDuration->duration_name, $not_included)) { ?>
						<option value="<?php echo $eachDuration->id; ?>"><?php echo $eachDuration->duration_name; ?></option>
						<?php } ?>
					<?php endforeach; ?>			
				</select>
			</p>
			<p><input id="plan_name" type="text" name="plan_name" placeholder="Plan Name"/></p>
			<p><input id="estab_no" type="number" name="estab_no" placeholder="No of Establishment"/></p>
			<p><input id="branch_no" type="number" name="branch_no" placeholder="No of Branches"/></p>
			<p><input id="cost" type="number" name="cost" placeholder="cost"/></p>
			<p><input id="visibility" type="checkbox" name="visibility" value="Visible"/>Visible</p>
			<p><input id="optAdd" type="submit" value="+ADD PLAN"/><input id="optSave" type="submit" value="SAVE CHANGES"/><input id="optCancel" type="submit" value="CANCEL"/></p>			
		</div>

		<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/functions.js"></script>			
		<script type="text/javascript">

			processRequest("backendprocess.php?getPlans=true");

			$('#customPlan').hide();
			$('#planDuration').change(function() {
				$('#customPlan').hide();
				//console.log("plan duration changes" + $('#planDuration option:selected').text());
				if ($('#planDuration option:selected').text() == "custom") {
					$('#customPlan').show();
					//console.log("custom plan");
				}
			});

			function handleServerResponse() {
				if (objReq.readyState == 4 && objReq.status == 200) {
					console.log(objReq.responseText);	
					var jsonObj = JSON.parse(objReq.responseText);
					if (jsonObj.Plans) {
						var tblRows = "<tr>";
						tblRows += "<th>ID</th><th>NAME</th><th>INTERVAL</th><th>NO OF ESTABLISHMENT</th><th>NO OF BRANCHES</th><th>COST</th><th>VISIBILITY</th>";
						tblRows += '<th colspan="2">OPTION</th></tr>';
						tblRows += tableJSON("#planContainer", jsonObj.Plans);
						$("#planContainer").append("<tbody>" + tblRows + "<tbody>");
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
					if ($('#intervalCount').val().trim() == "") return;
					else customDuration = $('#customPlanDuration option:selected').text();
				} 

				if (durationID == "" || estab_no == "" || branch_no == "" || cost == "" || plan_name == "") return;
			    //console.log("poop");
				//processRequest("backendprocess.php?createPlan=true&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name);
				processPOSTRequest("backendprocess.php", "createPlan=true&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name
					+"&interval_count="+interval_count+"&interval="+customDuration);
			});	

			$(document).on('click', '.optDelete', function() {
				console.log($(this).attr("data-internalid"));
				var planID = $(this).attr("data-internalid");
				//processRequest("backendprocess.php?deletePlan=true&planID=" + planID);
				processPOSTRequest("backendprocess.php", "deletePlan=true&planID=" + planID);
				return false;
			});	

			$(document).on('click', '.optEdit', function() {
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
				if (durationID == "" || estab_no == "" || branch_no == "" || cost == "" || plan_name == "") return;				
				//processRequest("backendprocess.php?saveChangesPL=true"+"&planID="+planID+"&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name);
				processPOSTRequest("backendprocess.php", "saveChangesPL=true"+"&planID="+planID+"&durationID="+durationID+"&estab_no="+estab_no+"&branch_no="+branch_no+"&cost="+cost+"&visibility="+visibility+"&plan_name="+plan_name);

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