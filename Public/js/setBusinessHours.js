$('#setBusinessHours').click(function(e) {
	e.preventDefault();
	console.log("nalipat naman na");
	var branch_id = markers[selectedIndex].id;
	//processRequest("backendprocess.php?getBranchHours=true&branch_id=" + branch_id);
	//setupBranchHourInputs(branch_id);
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
			processPOSTRequest("backendprocess.php", "setBusinessHours=true&jsonHours=" + json_hours_string);
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
	
	if ((period == "pm" || period == "PM") && parseInt(str_time[0]) != 12) {
		str_time[0] = parseInt(str_time[0]) + 12;
	} else if ((period == "am" || period == "AM") && parseInt(str_time[0]) == 12) {
		str_time[0] = parseInt(str_time[0]) - 12;
	}

	if (str_time[0] == 0) str_time[0] += "0"; 

	return str_time.join(":") + ":00";
}

function time_txt_to_12hour(str_time) {
	str_time = str_time.split(":");
	period = parseInt(str_time[0]) > 11 ? "PM" : "AM";

	if (parseInt(str_time[0]) > 12) {
		str_time[0] = parseInt(str_time[0]) - 12;
	} else if (str_time[0] == "00") {
		str_time[0] = parseInt(str_time[0]) + 12;
	}

	return str_time[0] + ':' + str_time[1] + period;
}

function getTimeSelection(branchHour) {
	var timeSelection = "";
	if (branchHour.opening_hour == branchHour.closing_hour) {
		timeSelection = "CLOSED";
	} else if (branchHour.opening_hour == "00:00:00" && branchHour.closing_hour == "23:59:00") {
		timeSelection = "24HOURS";
	} else {
		timeSelection = "MANUALTIME";
	}
	return timeSelection;
}

var branchHourArray = [];
var days = ["mon", "tue", "wed", "thu", "fri", "sat", "sun"];

function setupBranchHourInputs(branch_id, jsonBranchHours=false) { 
	console.log(selectedIndex + " in setupBranchHourInputs");
	var branchHourInputs = "";
	for (var i = 0; i < days.length; i++) {
		var branchHour = {branch_id : branch_id, day_no : '', opening_hour : '', closing_hour : ''};
		branchHour.day_no = i;
		branchHour.opening_hour = !jsonBranchHours ? time_txt_to_24hour("08:00AM") : jsonBranchHours[i].opening_hour;
		branchHour.closing_hour = !jsonBranchHours ? time_txt_to_24hour("08:00PM") : jsonBranchHours[i].closing_hour;
		branchHourArray[i] = branchHour;		

		var timeSelection = getTimeSelection(branchHour);

		branchHourInputs += '<div id="eachBranchHourContainer' + i + '"><div style="width: 10%; float: left;" >' + days[i] + ': </div><span>';
		branchHourInputs += '<input type="radio" class="setTimeManual" name="timeSelection' + i + '" checked="checked" data-internalid="' + i + '" />';

		branchHourInputs += '<input type="text" size="10" id="defaultEntryOpen' + i + '" class="defaultEntryOpen" data-internalid='
		branchHourInputs += '"' + i + '"' + 'value="' + time_txt_to_12hour(branchHour.opening_hour) + '"';
		branchHourInputs += timeSelection == "CLOSED" || timeSelection == "24HOURS" ? ' disabled="disabled" /></span>' : '/></span>';
		
		branchHourInputs += ' to <span>';

		branchHourInputs += '<input type="text" size="10" id="defaultEntryClose' + i + '" class="defaultEntryClose" data-internalid=';
		branchHourInputs += '"' + i + '"' + 'value="' + time_txt_to_12hour(branchHour.closing_hour) + '"';
		branchHourInputs += timeSelection == "CLOSED" || timeSelection == "24HOURS" ? ' disabled="disabled" /></span>' : '/></span>';

		branchHourInputs += '<input type="radio" class="setTimeClosed" name="timeSelection' + i + '" value="closed" data-internalid="' + i + '"';
		branchHourInputs += timeSelection == "CLOSED" ? ' checked="checked" /> closed' : ' /> closed';

		branchHourInputs += '<input type="radio" class="setTime24Hours" name="timeSelection' + i + '" data-internalid="' + i + '"';
		branchHourInputs += timeSelection == "24HOURS" ? ' checked="checked" /> 24 Hours'  : ' /> 24 Hours';
		branchHourInputs += "</div>";
	}

	$('#hoursContainer').html("");
	$('#hoursContainer').append(branchHourInputs);
	$('.defaultEntryOpen').timeEntry();
	$('.defaultEntryClose').timeEntry();
}

$(document).on('change', '.defaultEntryOpen', function() {
	var internalID = $(this).attr('data-internalid');
	branchHourArray[internalID].opening_hour = time_txt_to_24hour($(this).val());
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
	$('#defaultEntryClose' + internalID).val('11:59PM');				
	$('#defaultEntryOpen' + internalID).prop('disabled', true);
	$('#defaultEntryClose' + internalID).prop('disabled', true);

	branchHourArray[internalID].opening_hour = time_txt_to_24hour("12:00AM");
	branchHourArray[internalID].closing_hour = time_txt_to_24hour("11:59PM");

});		

