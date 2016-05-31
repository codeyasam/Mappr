<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "ADMIN" ? redirect_to("../index.php") : null; 
	$categories = EstabCategory::find_all();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<style type="text/css">
			#output {
				border: none;
			}

			.thumbnail {
				width: 200px;
				height: 200px;
				overflow: hidden;
			    display: inline-block;
				margin: 10px;
			}


			.thumbnail>img {
				height: 200px;
			}
		</style>		
	</head>
	<body>
		<?php include("../../includes/admin_nav.php");  ?>
		<table id="categoryContainer" border="1">
			<tbody>
				<tr>
					<th>ID</th>
					<th>NAME</th>
					<th>FEATURED</th>
					<th>ICON PATH</th>
					<th>DESCRIPTION</th>
					<th colspan="2">OPTIONS</th>
				</tr>
			<?php foreach($categories as $key => $eachCategory): ?>
				<tr>
					<td><?php echo htmlentities($eachCategory->id); ?></td>
					<td><?php echo htmlentities($eachCategory->name); ?></td>
					<td><img height="100px" width="100px" src="<?php echo "../" . htmlentities($eachCategory->display_picture); ?>"></td>
					<td><?php echo htmlentities($eachCategory->description); ?></td>
					<td><a class="optEdit" href="">EDIT</a></td>
					<td><a class="optDelete" href="">DELETE</a></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<div>
			<form>
				<p><img id="output" height="100px" width="100px" src="../DISPLAY_PICTURES/defaultCategIcon.png"/></p>
				<p><input id="pic" type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/></p>
				<p><input id="categName" type="text" name="categName" placeholder="Name"/></p>
				<p><textarea id="categDescription" placeholder="Description"></textarea></p>
				<p><input id="featured_category" type="checkbox" value="FEATURED"/>Featured</p>
				<p><input id="optAdd" type="submit" value="+ADD CATEGORY"/><input id="optSave" type="submit" value="SAVE CHANGES"/><input id="optCancel" type="submit" value="CANCEL"/></p>
			</form>
		</div>

		<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/functions.js"></script>	
		<script type="text/javascript">
			// var objReq = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
			// function processRequest(suppliedURL) {
			// 	if (objReq) {
			// 		objReq.open("GET", suppliedURL, true);
			// 		objReq.onreadystatechange = handleServerResponse;
			// 		objReq.send(null);
			// 	} else {
			// 		setTimeout("processRequest()", 1000);
			// 	}
			// }

			function tableJSON(tableID, jsonObjRoot, hasOptDelete=true) {
				var d = new Date();
				var n = d.getTime();

				$(tableID).html("");
				$(tableID).attr("border", 1);
				var newTr = "";
				for (var key in jsonObjRoot) {
					if (jsonObjRoot.hasOwnProperty(key)) {
						newTr += "<tr>";
						//console.log(jsonObjRoot[key].id);
						for (var eachField in jsonObjRoot[key]) {
							if (jsonObjRoot[key].hasOwnProperty(eachField)) {
								if (eachField == "display_picture") {
									newTr += '<td><img height="100px" width="100px" src="../' + jsonObjRoot[key][eachField] + "?dummy=" + n + '"/></td>';
								} else 
									newTr += "<td>" + jsonObjRoot[key][eachField] + "</td>";
								//console.log(jsonObjRoot[key][eachField]);
							}
						}
						newTr += '<td><a class="optEdit" data-internalid="' + jsonObjRoot[key].id + '" href="">EDIT</a></td>';
						if (hasOptDelete)
							newTr += '<td><a class="optDelete" data-internalid="' + jsonObjRoot[key].id + '" href="">DELETE</a></td>';
						newTr += "</tr>";
					}
				}
				return newTr;
			}



			var loadFile = function(event) {
			   	var output = document.getElementById('output');
			   	output.src = URL.createObjectURL(event.target.files[0]);
			   	$('#urlContent').attr('value', "");
			};				

			processRequest("backendprocess.php?getCategories=true");

			function handleSuccessResponse(response) {
				var d = new Date();
				var n = d.getTime();

				console.log(response);
				var jsonObj = JSON.parse(response);
				if (jsonObj.Categories) {
					var tblRows = "<tr>";
					tblRows += "<th>ID</th><th>NAME</th><th>FEATURED</th>";
					tblRows += '<th>ICON</th><th>DESCRIPTION</th>';
					tblRows += '<th colspan="2">OPTION</th></tr>';
					tblRows += tableJSON("#categoryContainer", jsonObj.Categories);
					$("#categoryContainer").append("<tbody>" + tblRows + "<tbody>");
				} else if (jsonObj.categorySelected) {
					$('#categName').val(jsonObj.name);
					$('#categDescription').val(jsonObj.description);
					$('#output').attr('src', '../' + jsonObj.display_picture + "?dummy=" + n);
					if (jsonObj.featured_category == "FEATURED") 
						$('#featured_category').prop('checked', true);
					else 
						$('#featured_category').prop('checked', false);						
				}
			}

			function handleServerResponse() {
				var d = new Date();
				var n = d.getTime();

				if (objReq.readyState == 4 && objReq.status == 200) {
					console.log(objReq.responseText);
					var jsonObj = JSON.parse(objReq.responseText);
					if (jsonObj.Categories) {
						var tblRows = "<tr>";
						tblRows += "<th>ID</th><th>NAME</th><th>FEATURED</th>";
						tblRows += '<th>ICON</th><th>DESCRIPTION</th>';
						tblRows += '<th colspan="2">OPTION</th></tr>';
						tblRows += tableJSON("#categoryContainer", jsonObj.Categories);
						$("#categoryContainer").append("<tbody>" + tblRows + "<tbody>");
					} else if (jsonObj.categorySelected) {
						$('#categName').val(jsonObj.name);
						$('#categDescription').val(jsonObj.description);
						$('#output').attr('src', '../' + jsonObj.display_picture + "?dummy=" + n);
						if (jsonObj.featured_category == "FEATURED") 
							$('#featured_category').prop('checked', true);
						else 
							$('#featured_category').prop('checked', false);						
					}
				}
			}			

			// function tableJSON(tableID, jsonObjRoot) {
			// 	$(tableID).html("");
			// 	$(tableID).attr("border", 1);
			// 	var newTr = "";
			// 	for (var key in jsonObjRoot) {
			// 		if (jsonObjRoot.hasOwnProperty(key)) {
			// 			newTr += "<tr>";
			// 			//console.log(jsonObjRoot[key].id);
			// 			for (var eachField in jsonObjRoot[key]) {
			// 				if (jsonObjRoot[key].hasOwnProperty(eachField)) {
			// 					newTr += "<td>" + jsonObjRoot[key][eachField] + "</td>";
			// 					//console.log(jsonObjRoot[key][eachField]);
			// 				}
			// 			}
			// 			newTr += '<td><a class="optEdit" data-internalid="' + jsonObjRoot[key].id + '" href="">EDIT</a></td>';
			// 			newTr += '<td><a class="optDelete" data-internalid="' + jsonObjRoot[key].id + '" href="">DELETE</a></td>';
			// 			newTr += "</tr>";
			// 		}
			// 	}
			// 	return newTr;
			// }

			$('#optSave').hide();
			$('#optCancel').hide();

			$('#optAdd').on("click", function(e) {
				e.preventDefault(); 
				var categName = $('#categName').val().trim();
				var categDescription = $('#categDescription').val().trim();
				var featured_category = $('#featured_category').is(":checked") ? "FEATURED" : "NOT FEATURED";

				if (categName == "" || categDescription == "") return;
				console.log("poop");
				//processRequest("backendprocess.php?createCateg=true&categName="+categName+"&categDescription="+categDescription);
				// processPOSTRequest("backendprocess.php", "createCateg=true&categName="+categName+"&categDescription="+categDescription+"&featured_category="+featured_category);

				//Restructure processing of request
				var categIcon = document.getElementById('pic').files[0];
				var formData = new FormData();
				formData.append('createCateg', 'true');
				formData.append('categIcon', categIcon);
				formData.append('categName', categName);
				formData.append('categDescription', categDescription);
				formData.append('featured_category', featured_category);

				$.ajax({
					url: 'backendprocess.php',
					type: 'POST',
					data: formData,
					success: function(response) {
						handleSuccessResponse(response);
					},
					cache: false,
					contentType: false,
					processData: false					
				});
			});

			$(document).on('click', '.optDelete', function() {
				console.log($(this).attr("data-internalid"));
				var categoryID = $(this).attr("data-internalid");
				//processRequest("backendprocess.php?deleteCateg=true&categoryID=" + categoryID);
				processPOSTRequest("backendprocess.php", "deleteCateg=true&categoryID=" + categoryID);
				return false;
			});

			$(document).on('click', '.optEdit', function() {
				$('#optAdd').hide();
				$('#optSave').show();
				$('#optCancel').show();
				var categoryID = $(this).attr("data-internalid");
				$('#optSave').attr("data-internalid", categoryID);
				processRequest("backendprocess.php?editCateg=true&categoryID=" + categoryID);
				return false;
			});

			$('#optCancel').on('click', function(e) {
				e.preventDefault();
				$('#optSave').hide();
				$('#optCancel').hide();	
				$('#optAdd').show();			
			});

			$('#optSave').on('click', function(e) {
				e.preventDefault();
				var categoryID = $('#optSave').attr("data-internalid");
				var categName = $('#categName').val().trim();
				var categDescription = $('#categDescription').val().trim();
				var featured_category = $('#featured_category').is(":checked") ? "FEATURED" : "NOT FEATURED";
				
				if (categName == "" || categDescription == "") return;				
				//processRequest("backendprocess.php?saveChanges=true&categoryID=" + categoryID + "&categName=" + categName + "&categDescription=" + categDescription);
				// processPOSTRequest("backendprocess.php", "saveChanges=true&categoryID=" + categoryID + "&categName=" + categName + "&categDescription=" + categDescription+"&featured_category="+featured_category);
				
				//Restructured
				var categIcon = document.getElementById('pic').files[0];
				var formData = new FormData();
				formData.append('saveChanges', 'true');
				formData.append('categoryID', categoryID);
				formData.append('categIcon', categIcon);
				formData.append('categName', categName);
				formData.append('categDescription', categDescription);
				formData.append('featured_category', featured_category);

				$.ajax({
					url: 'backendprocess.php',
					type: 'POST',
					data: formData,
					success: function(response) {
						handleSuccessResponse(response);
					},
					cache: false,
					contentType: false,
					processData: false					
				});				

				$('#optSave').hide();
				$('#optCancel').hide();	
				$('#optAdd').show();

				$('#optSave').attr("data-internalid", "");
				$('#categName').val("");
				$('#categDescription').val("");
			});
		</script>
	</body>
</html>