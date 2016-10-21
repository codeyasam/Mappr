<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php isset($_GET['id']) ? null : redirect_to("index.php"); ?>
<?php  

	$currentSubsPlanEstab = SubsPlanEstab::find_by_id($_GET['id']);
	$sbscrbdID = $currentSubsPlanEstab->subs_plan_id;
	$estabID = $currentSubsPlanEstab->estab_id;
	$user_subscriptions = SubsPlan::get_owner_subscriptions($user->id);
	$subscriptionIDs = array_map(function($obj) { return $obj->id;}, $user_subscriptions);
	in_array($sbscrbdID, $subscriptionIDs) ? null : redirect_to("index.php");

	// $condition['key'] = "estab_id";
	// $condition['value'] = $database->escape_value($_GET['id']);
	// $condition['isNumeric'] = true;
	$noOfBranches = count(EstabBranch::find_all(array('key'=>'estab_id', 'value'=>$estabID, 'isNumeric'=>true)));
	$currentEstab = Establishment::find_by_id($estabID);
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="js/jquery_timeentry/jquery.timeentry.css"/>
		<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>		
		<?php include '../includes/styles.php'; ?>
	</head>
	<body>
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>

		</header>
		<div class="center clearfix">
			<div class="row">		
				<div class="manage col col-sm-3" style="margin-top: 0; margin-left: 15px; padding: 15px; margin-right: -15px;">
					<div class="text-center">
						<div id="display_picture" class="round-image text-center drop-shadow" style="display:inline-block; text-align:center; width: 125px; height: 125px; overflow: hidden;">
							<img style="height: 130px; margin-left: 0;" id="output" src="<?php echo htmlentities($currentEstab->display_picture); ?>"/>
						</div>
					</div>

					<div class="panel panel-info">
						
						<div class="panel-heading"><h1 class="heading-label text-center"><?php echo htmlentities($currentEstab->name); ?></h1></div>
						<div class="panel-body" style="overflow-y: auto; max-height: 450px; margin-top: 20px;">					
							<form action="manageBranch.php?id=<?php echo urlencode($estabID); ?>" method="POST">
								<div class="form-group">
									<input class="form-control" type="text" id="autocomplete">
								</div>
								<div class="form-group">
									<select id="branchesDropdown" class="form-control" style="display: none;">
										<option value="-1" hidden><i class="glyphicon glyphicon-plus">a</i>Select a branch</option>
									</select>
								</div>
								<div class="form-group pull-right">
									<button title="Drag Tool" class="btn btn-info" id="dragBranchBtn" type="button"><span class="glyphicon glyphicon-move"></span></button>
									<button title="Add Tool" class="btn btn-primary" id="addBranchBtn" type="button" disabled="true"><span class="glyphicon glyphicon-plus"></span></button>
									<button title="Delete Tool" class="btn btn-danger" id="delBranchBtn" type="button"><span class="glyphicon glyphicon-minus"></span></button>
								</div>
								<!-- HIDDEN -->
								<input id="estabID" type="hidden" name="estabID" value="<?php echo urlencode($estabID); ?>"/>
								<input id="sbscrbdID" type="hidden" value="<?php echo htmlentities($sbscrbdID); ?>"/>
								<!-- /HIDDEN -->
								<div class="form-group" id="infos" style="display:none;">
									<div class="form-group" title="Print this image to your products." id="qrCodeContainer">							
									</div>
									<div class="form-group">
										<a id="downloadQrCode" href="" download>Download QR Code</a>
									</div>
									<div class="coordinates form-group">
										<label>Coordinates:</label> [ <span id="lngPOS">Lng: </span>&nbsp;&nbsp;
										<span id="latPOS">Lat: </span> ]
									</div>
									<hr>
									<div class="form-group">
										<label>Branch Address</label>
										<input class="form-control" id="branchAddr" type="text"/>
									</div>
									<div class="form-group clearfix">
										<input class="pull-right btn btn-primary" id="optEditSave" type="submit" value="Edit"/>
									</div>
									<hr>
									<div class="form-group">
										<label>Branch Details or Description</label>
										<input class="form-control" id="branchDescription" type="text"/>
									</div>
									<div class="form-group clearfix">
										<input class="pull-right btn btn-primary" id="bdOptEditSave" type="submit" value="Edit" />
									</div>
									<hr>
									<div class="form-group">
										<label>Contact Number</label>
										<input class="form-control" id="branchContact" type="text"/>
									</div>
									<div class="form-group clearfix">
										<input class="pull-right btn btn-primary" id="bcOptEditSave" type="submit" value="Edit" />
									</div>			
									<hr>			
									<div class="form-group">
										<label>Business Hours</label>
										<ul id="branchHours">
											
										</ul>
									</div>
									<div id="hoursContainer" style="width: 700px; display: none;">								
									</div>
									<input type="submit" class="btn btn-primary" id="setBusinessHours" value="Set Business Hours"/>
									<hr>
									<div class="form-group">
										<label>Photo Gallery</label>
										<div id="galleryContainer">
										</div>
									</div>
									
								</div>
								<p id="emptyBranchesPrompt" style="display: none;">You do not have branches yet. Select the +, then find your location then click the map.</p>
							</form>
						</div>
					</div>

				</div><div class="col col-sm-9"><!-- 
					
					 --><script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDDpPDWu9z820FMYyOVsAphuy0ryz4kt2o&libraries=places&sensor=false"></script><!-- 
					
					 --><div id="map" class="main-window"></div>

				</div>
			</div>				
		</div>
	<?php include '../includes/footer.php'; ?>

	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="js/jquery_timeentry/jquery.plugin.js"></script> 
	<script type="text/javascript" src="js/jquery_timeentry/jquery.timeentry.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>

	<script type="text/javascript">
		$('#branchAddr').prop('disabled', true);
		$('#branchDescription').prop('disabled', true);
		$('#branchContact').prop('disabled', true);
		var estabID = document.getElementById('estabID').value;
		var sbscrbdID = document.getElementById('sbscrbdID').value;
		var selectedIndex = false;
		processRequest("backendprocess.php?retrieveBranches=true&estabID="+estabID);	
	
		var action_performed = function() {
			console.log("here here here poop");
			$('#dialog').dialog('close');
		}


		// confirm_action("poooop", action_performed);
		

		/*IMPORTANT INFO ABOUT JAPAN
			lat = 35.782171; 
			lng = 138.014649;
		*/

		/*OUR TESTING LOCATION
			lat = 14.857403;
			lng = 120.827130;
		*/

		function initIcon(img_url, mWidth, mHeight) {
			var mIcon = {
				scaledSize: new google.maps.Size(mWidth, mHeight),
			    origin: new google.maps.Point(0,0), // origin
			    anchor: new google.maps.Point(10, 20), // anchor
			    url : img_url				
			}
			return mIcon;
		}

		var selectedIcon = initIcon("images/icon_selected_marker.png", 25, 25);;
		var defaultIcon = initIcon("images/icon_unselected_marker.png", 25, 25);

		//MAP CONFIGURATION
		var mapOptions = {
		    //center: new google.maps.LatLng(37.7831,-122.4039),
				streetViewControl: false,
		    center: new google.maps.LatLng(14.857403, 120.827130),
		    zoom: 7,
		    mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		var noPoi = [
			{
				featureType: "poi",
				stylers: [
				  { visibility: "off" }
				]   
			}
		];	
				
		var map = new google.maps.Map(document.getElementById('map'), mapOptions);
		map.setOptions({styles: noPoi});
		var markerOptions = {
			map: map,
			draggable: true,
			animation: google.maps.Animation.DROP,
			icon: defaultIcon
		};	
			//Autocomplete
		var acOptions = {
			types: ['establishment']
		};
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'),acOptions);
		autocomplete.bindTo('bounds',map);
		var infoWindow = new google.maps.InfoWindow();	
			//zooom
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			infoWindow.close();
			var place = autocomplete.getPlace();
			if (place.geometry.viewport) {
		 		map.fitBounds(place.geometry.viewport);
			} else {
				map.setCenter(place.geometry.location);
		    	map.setZoom(15);
			}

			infoWindow.setContent('<div><strong>' + place.name + '</strong><br>');		
		});			
		//End of Configuration

		//Required for functionality
		// var actionSignifier = ["add", "del"];
		var actionObj = [];
		var markers = [];
		var toAdd = false;
		var toDelete = false;
		var onlyDrag = false;
		var onlySelect = false;
		/*
		for (var i = 0; i < actionSignifier.length; i++) {
			var centerControlDiv = document.createElement('div');
			var centerControl = CenterControl(centerControlDiv, map, actionSignifier[i]);				
			actionObj.push(centerControl);

			centerControlDiv.index = 1;
			map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
		}

		//console.log(actionObj);
		actionObj[0].addEventListener('click', function(e) {
			console.log("print lang");
			toDelete = false;
		});

		actionObj[1].addEventListener('click', function() {
			console.log("delete latLng");
			toDelete = true;
		});			
		//end
		*/

		function handleServerResponse() {
			if (objReq.readyState == 4 && objReq.status == 200) {
				console.log(selectedIndex + " selected index to.");
				console.log(objReq.responseText);
				var jsonObj = JSON.parse(objReq.responseText);

				if (jsonObj.newBranch) {
					markerOptions.position = new google.maps.LatLng(jsonObj.lat, jsonObj.lng);
					var marker = setMarkerValues(markerOptions, jsonObj);
					eventCallBack(marker);
					selectedIndex = markers.indexOf(marker);
					setUIInfos(marker);
					console.log(marker.id);
					setDownloadableQR(marker.id, "QRCodeBranchID" + marker.id);	
					manageDivInfos(jsonObj.hasBranches);
					$('#branchesDropdown').show();
					var option = '<option selected value="' + marker.id + '">' + marker.address + '</option>';
					$('#branchesDropdown').append(option);											
				} else if (jsonObj.deleteBranch) {
					selectedIndex = false;
					populateBranchesDropdown();
					manageDivInfos(jsonObj.hasBranches);							
				} else if (jsonObj.limitReached) {
					//alert('Plotted maximum number of branches');
					custom_alert_dialog('Plotted maximum number of branches');
				}

				if (jsonObj.updateBranch) {
					markers[selectedIndex].address = jsonObj.address;
					//console.log("dito naaaaa:" + jsonObj.address);
					setUIInfos(markers[selectedIndex]);
					setDownloadableQR(markers[selectedIndex].id, "QRCodeBranchID" + markers[selectedIndex].id);
					populateBranchesDropdown();
					$('#branchesDropdown').val(markers[selectedIndex].id);
				} else if (jsonObj.Branches) {
					if(jsonObj.hasBranches <= 0) {
						manageDivInfos(jsonObj.hasBranches);
						return; 
					}
					for (var key in jsonObj.Branches) {
						if (jsonObj.Branches.hasOwnProperty(key)) {
							markerOptions.position = new google.maps.LatLng(jsonObj.Branches[key].lat, jsonObj.Branches[key].lng);
							var marker = setMarkerValues(markerOptions, jsonObj.Branches[key]);
							eventCallBack(marker);
						}
					}
					populateBranchesDropdown();
					manageDivInfos(jsonObj.hasBranches);
				} else if (jsonObj.updatedAddr) {
					markers[selectedIndex].address = jsonObj.updatedAddr;
					populateBranchesDropdown();
					$('#branchesDropdown').val(markers[selectedIndex].id);						
				} else if (jsonObj.updatedDescription) {
					markers[selectedIndex].description = jsonObj.updatedDescription;
				} else if (jsonObj.updatedContact) {
					markers[selectedIndex].contact = jsonObj.updatedContact;
				} else if (jsonObj.updatedBranchHours) {
					console.log(jsonObj.updatedBranchHours);
					manageBranchHours(jsonObj.updatedBranchHours, true);
				}

				if (jsonObj.Gallery) {
					setupGallery(jsonObj);
				} else if (jsonObj.photoAddedID) {
					setupGallery(jsonObj);
				}

				if (jsonObj.branchSelected) {
					//console.log("branch is now selected: " + selectedIndex);
					var hasBranchHours = jsonObj.hasBranchHours > 0 ? true : false;
					manageDivInfos(jsonObj.hasBranches);	
					manageBranchHours(jsonObj.BranchHours, hasBranchHours);		
				}
			}							
		}

		function manageDivInfos(hasBranches) {
			if (hasBranches > 0) {
				//populateBranchesDropdown();
				if (selectedIndex !== false) $('#infos').show();
				else $('#infos').hide();	
				$('#emptyBranchesPrompt').hide();
			} else {
				$('#infos').hide();
				$('#emptyBranchesPrompt').show();
				$('#branchesDropdown').hide();
			}
		}

		function manageBranchHours(jsonBranchHours, hasBranchHours) {
			$('#branchHours').html("");
			var branch_id = markers[selectedIndex].id;
			if (!hasBranchHours) {
				$('#setBusinessHours').val("Set Business Hours");
				setupBranchHourInputs(branch_id);
				return;
			}
			setupBranchHourInputs(branch_id, jsonBranchHours);
			var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
			var outputBranchHours = "";
			for (var i = 0; i < days.length; i++) {
				console.log(jsonBranchHours[i]);
				var daySched = getBrancHourDaySched(jsonBranchHours[i].opening_hour, 
								jsonBranchHours[i].closing_hour);

				outputBranchHours += '<li><i>' + days[i] + ': </i>&nbsp;&nbsp;&nbsp;';
				outputBranchHours += daySched;
				outputBranchHours += '</li>';
			}
			$('#setBusinessHours').val("Edit Business Hours");
			$('#branchHours').append(outputBranchHours);
		}

		function getBrancHourDaySched(opening_hour, closing_hour) {
			var daySched = "";
			if (opening_hour == closing_hour) {
				daySched = "closed";
			} else if (opening_hour == "00:00:00" && closing_hour == "23:59:00") {
				daySched = "Open 24 hours";
			} else {
				daySched  = time_txt_to_12hour(opening_hour) + " to ";
				daySched += time_txt_to_12hour(closing_hour);
			}

			return daySched; 
		}

		$('#branchesDropdown').on('change', function() {
			var currentMarker = getMarkerById(this.value);
			selectMarker(currentMarker, markers);	
			var latlngPOS = currentMarker.getPosition();

			map.setCenter(latlngPOS);
			map.setZoom(15);
			// smoothZoom(map, 15, map.getZoom()); 
		});



		function getMarkerById(branchId) {
			for (var i = 0; i < markers.length; i++) {
				if (markers[i].id == branchId) return markers[i];
			}
			return false;
		}

		function populateBranchesDropdown() {
			$('#branchesDropdown')
			    .find('option')
			    .remove()
			    .end()
			    .append('<option selected hidden>Select a branch</option>')
			    .val('whatever');	
			    		
			for (var i = 0; i < markers.length; i++) {
				console.log(markers[i].address);
				var option = '<option value="' + markers[i].id + '">' + markers[i].address + '</option>';
				$('#branchesDropdown').append(option);	
			}
			$('#branchesDropdown').show();
		}

		$(document).on('click', '.optPhoto', function() {
			console.log("optPhoto");
			var galleryID = $(this).attr("data-internalid");
			var branchID = markers[selectedIndex].id;
			if ($(this).is(":checked")) {
				//console.log("addPHOTO");
				//processRequest("backendprocess.php?addPhoto=true&branchID="+branchID+"&galleryID="+galleryID+"&estabID="+estabID);
				processPOSTRequest("backendprocess.php", 
					"addPhoto=true&branchID="+branchID+"&galleryID="+galleryID+
					"&estabID="+estabID);
			} else {
				//console.log("deletePHOTO");
				var galleryID = $(this).attr('data-branchGalleryID');
				//processRequest("backendprocess.php?removePhoto=true&branchID="+branchID+"&galleryID="+galleryID);
				processPOSTRequest("backendprocess.php", "removePhoto=true&branchID="+branchID+"&galleryID="+galleryID);
			}
		});

		function setupGallery(jsonObj) {
			$('#galleryContainer').html("");
			var photoContainer = "";
			for (var key in jsonObj.Gallery) {
				if (jsonObj.Gallery.hasOwnProperty(key)) {
					//console.log(key);
					photoContainer += '<div class="thumbnail" style="text-align:left;">';
					if (jsonObj.BranchID) {
						photoContainer += '<input data-internalid="' + jsonObj.Gallery[key].id + '"';
						photoContainer += ' class="optPhoto" type="checkbox" style="position:absolute;z-index: 10;"';	
						if (jsonObj.BranchGallery) {
							jsonObj.BranchGallery.filter(function(item) {
								if (item.gallery_id == jsonObj.Gallery[key].id) {
									photoContainer += 'data-branchGalleryID="' + item.id + '" ';
									photoContainer += 'checked';
								}
							}); 
						}
						photoContainer += '/>';
					}
					photoContainer += '<img src="' + jsonObj.Gallery[key].gallery_pic + '"/>';
					photoContainer += '</div>';
				}
			}
			$('#galleryContainer').append(photoContainer);				
		}

		function setMarkerValues(markerOptions, jsonObject) {
			var marker = new google.maps.Marker(markerOptions);
			marker.setMap(map);
			marker.id = jsonObject.id;
			marker.address = jsonObject.address;
			marker.description = jsonObject.description;
			marker.contact = jsonObject.contact_number;
			markers.push(marker);
			return marker;
		}

		function eventCallBack(marker) {
            (function (marker) {
                google.maps.event.addListener(marker, "click", function () {
                    if (toDelete == true) {
	                    var action_performed = function() {
	                    	deleteMarker(marker, markers);
	                    	$('#dialog').dialog('close');	
	                    };
	                    confirm_action("Are you sure you want to delete this?", action_performed);	                    	
                    } else {
       //              	if (toAdd == true) {
							// var option = '<option value="' + marker.id + '">' + marker.address + '</option>';
							// $('#branchesDropdown').append(option);	
       //              		console.log("to add is true");
       //              	}
       //              	console.log("toAdd: " + toAdd);
                    	$('#branchesDropdown').val(marker.id);
                    	selectMarker(marker, markers);
                    }
                		    
                });		

                google.maps.event.addListener(marker, "drag", function(e) {
                	setUIInfos(marker);
                });		
                
                google.maps.event.addListener(marker, "dblclick", function(e) {
					map.setZoom(15);
					map.setCenter(marker.getPosition());
                });			            	

				google.maps.event.addListener(marker, 'dragend', function(e) {
					selectedIndex = markers.indexOf(marker);
					getReverseGeocodingData(e, "update");
					console.log("inpudate");
					//setUIInfos(marker);
				});							            	
            })(marker);					
		}

		function deleteMarker(marker, markers) {				
			var branchID = marker.id;
			//processRequest("backendprocess.php?deleteBranch=true&branchID="+branchID);
			processPOSTRequest("backendprocess.php", "deleteBranch=true&branchID="+branchID);
			var index = markers.indexOf(marker);	
			marker.setMap(null);
			marker = null;
			markers.splice(index, 1);
			 				
		}

		function selectMarker(marker, markers) {
			console.log("a marker is selected");
			setUIInfos(marker);
		    $('#branchAddr').attr("data-internalid", marker.id);
			selectedIndex = markers.indexOf(marker);
			processRequest("backendprocess.php?branchSelected=true&estabID="+estabID
				+"&branchID="+marker.id);
			setDownloadableQR(marker.id, "QRCodeBranchID" + marker.id);	
			changeMarkerIcon(marker, markers);
			// map.setZoom(15);
			// map.setCenter(marker.getPosition());		
		}

		function changeMarkerIcon(marker, markers) {
			for (var i = 0; i < markers.length; i++) {
				markers[i].setIcon(defaultIcon);
			}
			marker.setIcon(selectedIcon);
		}

		function setDownloadableQR(contents, filename) {
			console.log(contents + filename);
			contents = contents.toString();
			$('#qrCodeContainer').html("");
			$('#qrCodeContainer').qrcode({width: 125, height: 125, text:contents});
			var qrContainer = document.getElementById("qrCodeContainer").firstChild;
			$('#downloadQrCode').attr("href", qrContainer.toDataURL());	
			$('#downloadQrCode').attr("download", filename);				
		} 

		function setUIInfos(marker) {
			var latlngPOS = marker.getPosition().toString();
			latlngPOS = latlngPOS.substring(1, latlngPOS.length - 1).split(",");
			//console.log(latlngPOS);
			$('#latPOS').text("Lat - " + Number(latlngPOS[0]).toFixed(6));
			$('#lngPOS').text("Lng - " + Number(latlngPOS[1]).toFixed(6));
			$('#branchAddr').val(marker.address);
			$('#branchDescription').val(marker.description);
			$('#branchContact').val(marker.contact);
		}

		$('#addBranchBtn').on('click', function() {
			unSelectAllActionBtn();
			toAdd = true;
			toDelete = false;
			onlyDrag = false;
			onlySelect = false;
			$(this).prop({disabled: true});
		});

		$('#delBranchBtn').on('click', function() {
			unSelectAllActionBtn();
			toDelete = true;
			toAdd = false;
			$(this).prop({disabled: true});
		});

		$('#dragBranchBtn').on('click', function() {
			unSelectAllActionBtn();
			toDelete = false;
			onlyDrag = true;
			toAdd = false;
			$(this).prop({disabled: true});
		});

		function unSelectAllActionBtn() {
			$('#addBranchBtn').prop({disabled: false});
			$('#delBranchBtn').prop({disabled: false});
			$('#dragBranchBtn').prop({disabled: false});
		}
		/*
		function CenterControl(controlDiv, map, actionPerform) {
		  	// Set CSS for the control border.
		  	var controlUI = document.createElement('div');
		  	controlUI.style.backgroundColor = '#fff';
		  	controlUI.style.border = '2px solid #fff';
		  	controlUI.style.borderRadius = '3px';
		  	controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
			controlUI.style.cursor = 'pointer';
			controlUI.style.marginBottom = '22px';
		  	controlUI.style.textAlign = 'center';
		  	controlUI.title = 'Click to recenter the map';
		  	controlDiv.appendChild(controlUI);

		  	// Set CSS for the control interior.
		  	var controlText = document.createElement('div');
		  	controlText.style.color = 'rgb(25,25,25)';
		  	controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
		  	controlText.style.fontSize = '16px';
		  	controlText.style.lineHeight = '38px';
		  	controlText.style.paddingLeft = '5px';
		  	controlText.style.paddingRight = '5px';
		  	controlText.innerHTML = actionPerform;
		  	controlUI.appendChild(controlText);

		  	// Setup the click event listeners: simply set the map to Chicago.
		  	return controlUI;

		}
		*/

		function getReverseGeocodingData(e, operation) {

		    var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
		    // This is making the Geocode request
		    var geocoder = new google.maps.Geocoder();
		    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
		        if (status !== google.maps.GeocoderStatus.OK) {
		            //alert(status);
		        	custom_alert_dialog('Something went wrong. Check your internet connection and then refresh');
		        }
		        // This is checking to see if the Geoeode Status is OK before proceeding
		        if (status == google.maps.GeocoderStatus.OK) {
		            var address = (results[0].formatted_address);
		            var estabID = document.getElementById('estabID').value;

		            if (operation == "update") {
		            	//processRequest("backendprocess.php?updateBranch=true&addr="+address+"&lat="+e.latLng.lat()+"&lng="+e.latLng.lng()+"&estabID="+estabID+"&branchID="+markers[selectedIndex].id);
		            	processPOSTRequest("backendprocess.php", "updateBranch=true&addr="+address+
		            		"&lat="+e.latLng.lat()+"&lng="+e.latLng.lng()+"&estabID="+estabID+
		            		"&branchID="+markers[selectedIndex].id);
		            } else if (operation == "create") {
		            	//processRequest("backendprocess.php?createBranch=true&addr="+address+"&lat="+e.latLng.lat()+"&lng="+e.latLng.lng()+"&estabID="+estabID+"&sbscrbdID="+sbscrbdID);
		            	console.log("na click dito");			            				
		            	processPOSTRequest("backendprocess.php", 
		            		"createBranch=true&addr="+address+"&lat="+e.latLng.lat()+
		            		"&lng="+e.latLng.lng()+"&estabID="+estabID+"&sbscrbdID="+sbscrbdID);           			            
		            }

		        }
		    });

		}	
		
		//add marker / create branch 
		google.maps.event.addListener(map,'click',function(e){
			console.log("map na click hindi marker");			

			if (toDelete == false && onlyDrag == false && onlySelect == false) {
				getReverseGeocodingData(e, "create");
			} 
		});

		$('#optEditSave').on("click", function(e) {
			e.preventDefault();
			//console.log($(this).val());
			if ($(this).val() == "Edit") {
				$('#branchAddr').prop('disabled', false);
			}  else {
				$('#branchAddr').prop('disabled', true);
				//processRequest("backendprocess.php?saveBranchAddr=true&branchID=" 
				//	+ $('#branchAddr').attr("data-internalid") + "&address=" 
				//	+ $('#branchAddr').val());
				processPOSTRequest("backendprocess.php", "saveBranchAddr=true&branchID="
					+ $('#branchAddr').attr("data-internalid") + "&address="
					+ $('#branchAddr').val());
			}

			$(this).val($(this).val() == "Edit" ? "Save" : "Edit");
		});

		$('#bdOptEditSave').on("click", function(e) {
			e.preventDefault();
			if ($(this).val() == "Edit") {
				$('#branchDescription').prop('disabled', false);
			}  else {
				$('#branchDescription').prop('disabled', true);
				processPOSTRequest("backendprocess.php", "saveBranchDescription=true&branchID="
					+ $('#branchAddr').attr("data-internalid") + "&description="
					+ $('#branchDescription').val());
			}

			$(this).val($(this).val() == "Edit" ? "Save" : "Edit");
		});

		$('#bcOptEditSave').on("click", function(e) {
			e.preventDefault();
			if ($(this).val() == "Edit") {
				$('#branchContact').prop('disabled', false);
			}  else {
				$('#branchContact').prop('disabled', true);
				processPOSTRequest("backendprocess.php", "saveBranchContact=true&branchID="
					+ $('#branchAddr').attr("data-internalid") + "&contact="
					+ $('#branchContact').val());
			}

			$(this).val($(this).val() == "Edit" ? "Save" : "Edit");
		});				
	
	</script>
	<script type="text/javascript" src="js/setBusinessHours.js"></script>
	</body>
</html>