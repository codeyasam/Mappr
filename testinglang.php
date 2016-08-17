<?php  
    require_once("includes/initialize.php");
	// //anonymous function php
	// // $get_addresses = function($obj) {
	// // 	return $obj->address;
	// // };
	
	// // // $arrObj = EstabBranch::find_all();
	// // // $myArr = array_map(function($obj) {return $obj->address;}, $arrObj);
	// // // print_r($myArr);
	// // // echo join("<>", $myArr);

	// // function testlang() {
	// // 	$arrObj = EstabBranch::find_all();
	// // 	$myArr = array_map(function($obj) {return $obj->address;}, $arrObj);
	// // 	print_r($myArr);
	// // 	echo join("<>", $myArr);		
	// // }

	// // testlang();

	// //echo SubsPlanEstab::get_total_branch_plotted(3);
	// $objArr = EstabBranch::find_all();
	// // echo "<pre>";
	// // 	print_r(createJSONEntity("Branches", $objArr));
	// // echo "</pre>";
	// echo "{" . createJSONEntity("Branches", $objArr) . "}";
	// $subject = "<h2>yeah</h2>";
	// $result = preg_replace('%([+\"\'<>/]+)%', '\\\\$1', $subject);
	// echo $result;
    //var_dump(User::check_username_format("asfasチトシハ"));
    // var_dump(User::check_existing("codeyasam", "username", "has existing username"));
    // var_dump(User::check_existing("codeyasam", "email", "has existing username")); 
    // var_dump($errors);   


    // $branchHours = new BranchHours();
    // $branchHours->branch_id = 1;
    // $branchHours->day_no = 3;
    // $branchHours->opening_hour = time_txt_to_24hour("1:50:00", "am");
    // $branchHours->closing_hour = time_txt_to_24hour("8:00:00", "pm");
    // $branchHours->create();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<!-- to be added -->
		<link rel="stylesheet" type="text/css" href="Public/js/jquery_timeentry/jquery.timeentry.css"/>
		<!-- end -->
		<link rel="stylesheet" type="text/css" href="Public/js/jquery-ui.css"/>
	</head>
	<body>

		<div id="hoursContainerBACK" style="width: 700px">
			
		</div>

		<div id="hoursContainer" style="width: 700px; display: none;">
			
		</div>		

		<input type="submit" value="CANCEL"/>
		<input id="hourSave" type="submit" value="SAVE"/>

		<input type="submit" id="setBusinessHours" value="SET BUSINESS HOURS"/>

		<script type="text/javascript" src="Public/js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="Public/js/jquery-ui.min.js"></script>
		<!-- to be added -->
		<script type="text/javascript" src="Public/js/jquery_timeentry/jquery.plugin.js"></script> 
		<script type="text/javascript" src="Public/js/jquery_timeentry/jquery.timeentry.js"></script>	
		<!-- end -->
		<script type="text/javascript" src="Public/js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="Public/js/functions.js"></script>
		<script type="text/javascript">

			$('#setBusinessHours').click(function() {
				$("#hoursContainer").dialog("open");
			});

			$("#hoursContainer").dialog({
				width: 650,
				autoOpen: false,
				modal: true,
				buttons : {
				    "Cancel" : function() {
				      $(this).dialog("close");
				    },"SAVE" : function() {
						var json_hours_string = JSON.stringify(branchHourArray);
						console.log(json_hours_string);
						processPOSTRequest("testprocess.php", "test=true&jsonHours=" + json_hours_string);
						$(this).dialog("close");
				    }
				  }
			});	

						

			function myTimeEntry(inputID, defaultTime) {
				$(inputID).timeEntry();
				$(inputID).val(defaultTime);
			}

			function time_txt_to_24hour(str_time) {
				period = str_time.substring(5, 7);
				str_time = str_time.substring(0, 5);
				str_time = str_time.split(":");
				
				if (period == "pm" || period == "PM") {
					str_time[0] = parseInt(str_time[0]) + 12;
				}

				return str_time.join(":");
			}

			var branch_id = 1;
			var branchHourArray = [];
			
			var days = ["mon", "tue", "wed", "thu", "fri", "sat", "sun"];

			var branchHourInputs = "";
			for (var i = 0; i < days.length; i++) {
				branchHourInputs += '<div><div style="width: 10%; float: left;" >' + days[i] + ': </div><span>';
				branchHourInputs += '<input type="radio" class="setTimeManual" name="timeSelection' + i + '" checked="checked" data-internalid="' + i + '" />';

				branchHourInputs += '<input type="text" size="10" id="defaultEntryOpen' + i + '" class="defaultEntryOpen" data-internalid='
				branchHourInputs += '"' + i + '"' + '/></span>';
				
				branchHourInputs += ' to <span>';

				branchHourInputs += '<input type="text" size="10" id="defaultEntryClose' + i + '" class="defaultEntryClose" data-internalid=';
				branchHourInputs += '"' + i + '"' + '/></span>';

				branchHourInputs += '<input type="radio" class="setTimeClosed" name="timeSelection' + i + '" value="closed" data-internalid="' + i + '"/> closed';

				branchHourInputs += '<input type="radio" class="setTime24Hours" name="timeSelection' + i + '" data-internalid="' + i + '" /> 24 Hours';
				branchHourInputs += "</div>";
				var branchHour = {branch_id : branch_id, day_no : '', opening_hour : '', closing_hour : ''};

				branchHour.day_no = i;
				branchHour.opening_hour = time_txt_to_24hour("08:00AM");
				branchHour.closing_hour = time_txt_to_24hour("08:00PM");
				branchHourArray[i] = branchHour;
			}

			$('#hoursContainer').append(branchHourInputs);
			myTimeEntry(".defaultEntryOpen", "08:00AM");
			myTimeEntry(".defaultEntryClose", "08:00PM");

			$(document).on('change', '.defaultEntryOpen', function() {
				var internalID = $(this).attr('data-internalid');
				console.log(internalID);

				branchHourArray[internalID].opening_hour = time_txt_to_24hour($(this).val());
				console.log(branchHourArray[internalID]);
			});

			$(document).on('change', '.defaultEntryClose', function() {
				var internalID = $(this).attr('data-internalid');
				branchHourArray[internalID].closing_hour = time_txt_to_24hour($(this).val());
			});
			
			$(document).on('click', '.setTimeManual', function() {
				var internalID = $(this).attr('data-internalid');

				$('#defaultEntryOpen' + internalID).prop('disabled', false);
				$('#defaultEntryClose' + internalID).prop('disabled', false);

				var opening_hour = $('#defaultEntryOpen' + internalID).val();
				var closing_hour = $('#defaultEntryClose' + internalID).val();
				branchHourArray[internalID].opening_hour = time_txt_to_24hour(opening_hour);
				branchHourArray[internalID].closing_hour = time_txt_to_24hour(closing_hour);
			});

			$(document).on('click', '.setTimeClosed', function() {
				var internalID = $(this).attr('data-internalid');
				console.log(internalID);

				$('#defaultEntryOpen' + internalID).prop('disabled', true);
				$('#defaultEntryClose' + internalID).prop('disabled', true);
				branchHourArray[internalID].opening_hour = "00:00:00";
				branchHourArray[internalID].closing_hour = "00:00:00";
			});

			$(document).on('click', '.setTime24Hours', function() {
				var internalID = $(this).attr('data-internalid');
				console.log(internalID);

				$('#defaultEntryOpen' + internalID).val('12:00AM');
				$('#defaultEntryClose' + internalID).val('12:00AM');				
				$('#defaultEntryOpen' + internalID).prop('disabled', true);
				$('#defaultEntryClose' + internalID).prop('disabled', true);

				branchHourArray[internalID].opening_hour = time_txt_to_24hour("12:00AM");
				branchHourArray[internalID].closing_hour = time_txt_to_24hour("12:00PM");

			});		

			function handleServerResponse() {
				if (objReq.readyState == 4 && objReq.status == 200) {
					console.log(objReq.responseText);
					var jsonObj = JSON.parse(objReq.responseText);

				}
			}

			$(document).on('click', '#hourSave', function() {
				var json_hours_string = JSON.stringify(branchHourArray);
				console.log(json_hours_string);
				processPOSTRequest("testprocess.php", "test=true&jsonHours=" + json_hours_string);
			});


			console.log(branchHourArray);
		</script>
	</body>
</html>