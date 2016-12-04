<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "ADMIN" && $user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null; 
	$categories = EstabCategory::find_all();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../../includes/styles.php'; ?>
		<link rel="stylesheet" type="text/css" href="../js/jquery-ui.css">
		<style type="text/css">
		</style>		
	</head>
	<body>
		<header>
			<div class="center">		
				<?php include("../../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container center clearfix">
			<div class="panel panel-default clearfix drop-shadow">
				<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-list"></span> Manage Categories</h1></div>
				<div class="panel-body"></div>
			
				<div class="manage" style="float: left; width: 30%;">
					<form>

						<div class="form-group text-center">
							<div class="round-image text-center drop-shadow" style="display:inline-block; text-align:center; width: 130px; height: 130px; overflow: hidden;">
								<img style="height: 150px; margin-left: -10%;" id="output" src="../DISPLAY_PICTURES/defaultCategIcon.png"/>
							</div>
						</div>
						<div class="form-group">
							<label>Icon</label>
							<input id="pic" class="" style="max-width: 100%;" type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/>
						</div>
						<div class="form-group">
							<label>Category Name</label>
							<input class="form-control" id="categName" style="max-width: 100%;" type="text" name="categName"/>
						</div>
						<div class="form-group">
							<label>Description</label>
							<textarea id="categDescription" style="max-width: 100%;" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<input id="featured_category" style="max-width: 100%;" type="checkbox" value="FEATURED"/> <label>Featured</label>
						</div>
						<div class="form-group text-right">
							<input id="optAdd" type="submit" class="btn btn-primary" value="+ Add Category"/>
							<input id="optCancel" type="submit" class="btn btn-warning" value="Cancel"/>
							<input id="optSave" type="submit" class="btn btn-primary" value="Save"/>
						</div>
						<p></p>
					</form>
				</div>
				<table id="categoryContainer" class="data table table-hover drop-shadow"  style="width: 68%;float: left;">
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
						<tr class="text-center">
							<td><?php echo htmlentities($eachCategory->id); ?></td>
							<td><?php echo htmlentities($eachCategory->name); ?></td>
							<td><img class="category-icon" src="<?php echo "../" . htmlentities($eachCategory->display_picture); ?>"></td>
							<td><?php echo htmlentities($eachCategory->description); ?></td>
							<td><a class="optEdit text-primary" href=""><span class="glyphicon glyphicon-pencil"></span><br>Edit</a></td>
							<td><a class="optDelete text-danger" href=""><span class="glyphicon glyphicon-remove"></span><br>Delete</a></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="mLoadingEffect"></div>
		</div>	
		
			<?php include '../../includes/footer.php'; ?>
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
					// $(tableID).attr("border", 1);
					var newTr = "";
					for (var key in jsonObjRoot) {
						if (jsonObjRoot.hasOwnProperty(key)) {
							newTr += "<tr class='text-center'>";
							//console.log(jsonObjRoot[key].id);
							for (var eachField in jsonObjRoot[key]) {
								if (jsonObjRoot[key].hasOwnProperty(eachField)) {
									if (eachField == "display_picture") {
										newTr += '<td><img class="category-icon" src="../' + jsonObjRoot[key][eachField] + "?dummy=" + n + '"/></td>';
									} else 
										newTr += "<td>" + jsonObjRoot[key][eachField] + "</td>";
									//console.log(jsonObjRoot[key][eachField]);
								}
							}
							newTr += '<td class="text-center"><a class="optEdit text-primary" data-internalid="' + jsonObjRoot[key].id + '" href=""><span class="glyphicon glyphicon-pencil"></span><br>Edit</a></td>';
							if (hasOptDelete)
								newTr += '<td class="text-center"><a class="optDelete text-danger" data-internalid="' + jsonObjRoot[key].id + '" href=""><span class="glyphicon glyphicon-remove"></span><br>Delete</a></td>';
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
						tblRows += "<th>#</th><th>Name</th><th>Featured</th>";
						tblRows += '<th>Icon</th><th>Description</th>';
						tblRows += '<th colspan="2">Options</th></tr>';
						tblRows += tableJSON("#categoryContainer", jsonObj.Categories);
						$("#categoryContainer").append("<tbody>" + tblRows + "<tbody>");
						if (jsonObj.createdCateg) {
							$('body').removeClass('mLoading');
							custom_alert_dialog("Successfully created category.");
						} else if (jsonObj.updatedCateg) {
							$('body').removeClass('mLoading');
							custom_alert_dialog("Successfully updated category.");
						}
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
							tblRows += "<th>#</th><th>Name</th><th>Featured</th>";
							tblRows += '<th>Icon</th><th>Description</th>';
							tblRows += '<th colspan="2">Options</th></tr>';
							tblRows += tableJSON("#categoryContainer", jsonObj.Categories);
							$("#categoryContainer").append("<tbody>" + tblRows + "<tbody>");
							if (jsonObj.deletedCateg) {
								$('body').removeClass('mLoading');
								if (jsonObj.deletedCateg == "true") {
									custom_alert_dialog("Successfully deleted");
								} else {
									custom_alert_dialog("Can't delete this category, an Establishment is assigned to it.");
								}
							} 
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

					if (categName == "" || categDescription == "") { 
						custom_alert_dialog("Fill up required fields.");
						return;
					}

					$('body').addClass('mLoading');
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
					
					$('#categName').val("");
					$('#categDescription').val("");
					$("#output").prop({src: "../DISPLAY_PICTURES/defaultCategIcon.png"});
					$("#pic").val("");
				});

				$(document).on('click', '.optDelete', function() {
					console.log($(this).attr("data-internalid"));
					var categoryID = $(this).attr("data-internalid");
					var action_performed = function() {
						//processRequest("backendprocess.php?deleteCateg=true&categoryID=" + categoryID);
						processPOSTRequest("backendprocess.php", "deleteCateg=true&categoryID=" + categoryID);
						$('#dialog').dialog('close');						
						$('body').addClass('mLoading');
					}
					confirm_action("Are you sure you want to delete this category?", action_performed);

					return false;
				});

				$(document).on('click', '.optEdit', function() {
					$(".highlight").removeClass("highlight");
					$(this).parent().parent().addClass("highlight");
				   	var output = document.getElementById('output');
				   	output.src = "";
					$('#optAdd').hide();
					$('#optSave').show();
					$('#optCancel').show();
					var categoryID = $(this).attr("data-internalid");
					$('#optSave').attr("data-internalid", categoryID);
					processRequest("backendprocess.php?editCateg=true&categoryID=" + categoryID);
					return false;
				});

				$('#optCancel').on('click', function(e) {
					$(".highlight").removeClass("highlight");
					e.preventDefault();
					$('#optSave').hide();
					$('#optCancel').hide();	
					$('#optAdd').show();

					$('#categName').val("");
					$('#categDescription').val("");
					$("#output").prop({src: "../DISPLAY_PICTURES/defaultCategIcon.png"});
					$("#pic").val("");
				});

				$('#optSave').on('click', function(e) {
					e.preventDefault();
					var categoryID = $('#optSave').attr("data-internalid");
					var categName = $('#categName').val().trim();
					var categDescription = $('#categDescription').val().trim();
					var featured_category = $('#featured_category').is(":checked") ? "FEATURED" : "NOT FEATURED";
					
					if (categName == "" || categDescription == "") { 
						custom_alert_dialog('Fill all required fields.');						
						return; 
					}

					$('body').addClass("mLoading");
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
					$("#output").prop({src: "../DISPLAY_PICTURES/defaultCategIcon.png"});
					$("#pic").val("");
				});
			</script>
	</body>
</html>