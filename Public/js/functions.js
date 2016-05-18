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

function tableJSON(tableID, jsonObjRoot) {
	$(tableID).html("");
	$(tableID).attr("border", 1);
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
			newTr += '<td><a class="optEdit" data-internalid="' + jsonObjRoot[key].id + '" href="">EDIT</a></td>';
			newTr += '<td><a class="optDelete" data-internalid="' + jsonObjRoot[key].id + '" href="">DELETE</a></td>';
			newTr += "</tr>";
		}
	}
	return newTr;
}