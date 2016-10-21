var objReq = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
function processRequest(suppliedURL) {
	if (objReq) {
		objReq.open("GET", suppliedURL, true);
		objReq.onreadystatechange = handleServerResponse;
		objReq.send(null);
	} else {
		setTimeout("processRequest()", 1000);
	}
}

function processPOSTRequest(suppliedURL, sendData) {
	if (objReq) {
		objReq.open("POST", suppliedURL, true);
		objReq.onreadystatechange = handleServerResponse;
		objReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		objReq.send(sendData);
	} else {
		setTimeout("processPOSTRequest()", 1000);	
	}
}

function tableJSON(tableID, jsonObjRoot, hasOptDelete=true) {
	$(tableID).html("");
	// $(tableID).attr("border", 1);
	var newTr = "";
	for (var key in jsonObjRoot) {
		if (jsonObjRoot.hasOwnProperty(key)) {
			newTr += "<tr>";
			//console.log(jsonObjRoot[key].id);
			for (var eachField in jsonObjRoot[key]) {
				if (jsonObjRoot[key].hasOwnProperty(eachField)) {
					newTr += "<td>" + jsonObjRoot[key][eachField] + "</td>";
					//console.log(jsonObjRoot[key][eachField]);
				}
			}
			newTr += '<td class="text-center"><a class="optEdit" data-internalid="' + jsonObjRoot[key].id + '" href=""><span class="glyphicon glyphicon-pencil"></span><br>Edit</a></td>';
			if (hasOptDelete)
				newTr += '<td class="text-center"><a class="optDelete text-danger" data-internalid="' + jsonObjRoot[key].id + '" href=""><span class="glyphicon glyphicon-remove"></span><br>Delete</a></td>';
			newTr += "</tr>";
		}
	}
	return newTr;
}

function confirm_action(msg, action_performed) {
	if ($('#dialog').length != 1) {
		$('body').append(create_confirm_dialog());
	}

	$('#dialog > p').text(msg);

	$("#dialog").dialog({
		autoOpen: false,
		modal: true,
		buttons : {
		    "Confirm" : action_performed,
		    "Cancel" : function() {
		      $(this).dialog("close");
		    }
		  }
	});	

	$("#dialog").dialog("open"); 
}

function create_confirm_dialog() {
	var confirm_div = document.createElement("div");
	confirm_div.setAttribute("id", "dialog");
	confirm_div.setAttribute("title", "Confirmation Required");
	confirm_div.style.display = 'none';
	var confirm_p = document.createElement("p");
	confirm_div.appendChild(confirm_p);
	return confirm_div;
}

function create_confirm_dialog(myId="dialog", myTitle="Confirmation Required") {
	var confirm_div = document.createElement("div");
	confirm_div.setAttribute("id", myId);
	confirm_div.setAttribute("title", myTitle);
	confirm_div.style.display = 'none';
	var confirm_p = document.createElement("p");
	confirm_div.appendChild(confirm_p);
	return confirm_div;
}

function custom_alert_dialog(msg) {
	if ($('#customAlert').length != 1) {
		$('body').append(create_confirm_dialog("customAlert", "NOTICE"));
	}

	$('#customAlert > p').text(msg);

	$('#customAlert').dialog({
		autoOpen: false,
		modal: true,
		buttons : {
			"OK" : function() {
				$(this).dialog('close');
			}
		}
	});

	$('#customAlert').dialog('open');
	//console.log("did this");
}

function forTestingOnly() {
	console.log("called");
}

console.log("functions.js loaded now");
