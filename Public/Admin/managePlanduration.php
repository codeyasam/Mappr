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
	</head>
	<body>
		<?php include("../../includes/admin_nav.php"); ?>
		<table id="planDurationContainer" border="1">
			
		</table>

		<div>
			<p><input id="description" type=descriptionme="description" placeholder="Description"/></p>
			<p><input id="noOfDays" type="number" name="noOfDays" placeholder="no of days" min="1"/></p>
			<p><input id="optAdd" type="submit" value="+ADD CATEGORY"/><input id="optSave" type="submit" value="SAVE CHANGES"/><input id="optCancel" type="submit" value="CANCEL"/></p>
		</div>
		<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/functions.js"></script>
		<script type="text/javascript">

			processRequest("backendprocess.php?getPlanDurations=true");

			function handleServerResponse() {
				if (objReq.readyState == 4 && objReq.status == 200) {
					//console.log(objReq.responseText);
					var jsonObj = JSON.parse(objReq.responseText);
					if (jsonObj.PlanDurations) {
						var tblRows = "<tr>";
						tblRows += "<th>ID</th><th>DESCRIPTION</th><th>NO OF DAYS</th>";
						tblRows += '<th colspan="2">OPTION</th></tr>';
						tblRows += tableJSON("#planDurationContainer", jsonObj.PlanDurations);
						$("#planDurationContainer").append("<tbody>" + tblRows + "<tbody>");						
					} else if (jsonObj.planDurationSelected) {
						$('#description').val(jsonObj.description);
						$('#noOfDays').val(jsonObj.days_no);						
					}
				}
			}

			$('#optSave').hide();
			$('#optCancel').hide();	

			$('#optAdd').on("click", function(e) {
				e.preventDefault();
				var description = $('#description').val().trim();
				var noOfDays = $('#noOfDays').val().trim();
				if (description == "" || noOfDays == "") return;
				console.log("poop");
				processRequest("backendprocess.php?createPlanDuration=true&description="+description+"&noOfDays="+noOfDays);
			});	

			$(document).on('click', '.optDelete', function() {
				console.log($(this).attr("data-internalid"));
				var planDurationID = $(this).attr("data-internalid");
				processRequest("backendprocess.php?deletePlanDuration=true&planDurationID=" + planDurationID);
				return false;
			});	

			$(document).on('click', '.optEdit', function() {
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
				$('#noOfDays').val("");		
			});

			$('#optSave').on('click', function(e) {
				e.preventDefault();
				var planDurationID = $('#optSave').attr("data-internalid");
				var description = $('#description').val().trim();
				var noOfDays = $('#noOfDays').val().trim();
				if (description == "" || noOfDays == "") return;				
				processRequest("backendprocess.php?saveChangesPD=true&planDurationID=" + planDurationID + "&description=" + description + "&noOfDays=" + noOfDays);
				$('#optSave').hide();
				$('#optCancel').hide();	
				$('#optAdd').show();

				$('#optSave').attr("data-internalid", "");
				$('#description').val("");
				$('#noOfDays').val("");
			});										
		</script>		
	</body>
</html>