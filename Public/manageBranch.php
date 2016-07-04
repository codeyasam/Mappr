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
		<style type="text/css">
			#map {
			  height: 500px;
			  margin: 0;
			  width: 75%;
			}

			#autocomplete {
			  width: 75%;
			  height: 25px;
			}			
			
			.thumbnail {
				width: 80px;
				height: 80px;
				overflow: hidden;
			    display: inline-block;
				margin: 10px;
			}


			.thumbnail>img {
				height: 100px;
			}

			.actionBtnContainer img {
				height: 30px;
				width: 30px;
			}

		</style>	
				<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>		
	</head>
	<body>
		<?php include("../includes/navigation.php"); ?>
		<form action="manageBranch.php?id=<?php echo urlencode($estabID); ?>" method="POST" style="float:left; width: 19%;">
			<div class="actionBtnContainer">
				<button id="addBranchBtn" type="button"><img src="images/plus.jpg"/></button>
				<button id="delBranchBtn" type="button"><img src="images/minus.jpg"/></button>
				<button id="dragBranchBtn" type="button"><img src="images/drag.jpg"/></button>
				<button id="selectBranchBtn" type="button"><img src="images/select.jpg"/></button>
			</div>
			<p style="clear: both;"></p>
			<input id="estabID" type="hidden" name="estabID" value="<?php echo urlencode($estabID); ?>"/>
			<input id="sbscrbdID" type="hidden" value="<?php echo htmlentities($sbscrbdID); ?>"/>
			<div id="infos">
				<p><?php echo htmlentities($currentEstab->name); ?></p>
				<p id="latPOS">lat: </p>
				<p id="lngPOS">lng: </p>
				<p><input id="branchAddr" type="text"/>
				<input id="optEditSave" type="submit" value="EDIT"/></p>	

				<div id="galleryContainer">

				</div>	
				<div id="qrCodeContainer">
					
				</div>
				<a id="downloadQrCode" href="" download>DOWNLOAD</a>
			</div>
		</form>

	
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDDpPDWu9z820FMYyOVsAphuy0ryz4kt2o&libraries=places&sensor=false"></script>

		<input type="text" id="autocomplete">
		<div id="map"></div>

		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
		<script type="text/javascript">
			$('#branchAddr').prop('disabled', true);
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

			//MAP CONFIGURATION
			var mapOptions = {
			    //center: new google.maps.LatLng(37.7831,-122.4039),
			    center: new google.maps.LatLng(14.857403, 120.827130),
			    zoom: 7,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById('map'), mapOptions);
			var markerOptions = {
				map: map,
				draggable: true,
				animation: google.maps.Animation.DROP
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
			    	map.setZoom(17);
				}

				infoWindow.setContent('<div><strong>' + place.name + '</strong><br>');		
			});			
			//End of Configuration

			//Required for functionality
			var actionSignifier = ["add", "del"];
			var actionObj = [];
			var markers = [];
			var toDelete = false;
			var onlyDrag = false;
			var onlySelect = false;
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
					} else if (jsonObj.deleteBranch) {
						selectedIndex = false;

					} else if (jsonObj.limitReached) {
						alert('Plotted maximum number of branches');
					}

					if (jsonObj.updateBranch) {
						markers[selectedIndex].address = jsonObj.address;
						//console.log("dito naaaaa:" + jsonObj.address);
						setUIInfos(markers[selectedIndex]);
						setDownloadableQR(markers[selectedIndex].id, "QRCodeBranchID" + markers[selectedIndex].id);
					} else if (jsonObj.Branches) {
						for (var key in jsonObj.Branches) {
							if (jsonObj.Branches.hasOwnProperty(key)) {
								markerOptions.position = new google.maps.LatLng(jsonObj.Branches[key].lat, jsonObj.Branches[key].lng);
								var marker = setMarkerValues(markerOptions, jsonObj.Branches[key]);
								eventCallBack(marker);
							}
						}
					} else if (jsonObj.updatedAddr) {
						markers[selectedIndex].address = jsonObj.updatedAddr;
					} 

					if (jsonObj.Gallery) {
						setupGallery(jsonObj);
					} else if (jsonObj.photoAddedID) {
						setupGallery(jsonObj);
					}

					//retrieving branches
				}							
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
							photoContainer += ' class="optPhoto" type="checkbox" style="position:absolute;"';	
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
	                    	selectMarker(marker, markers);
	                    }
                    		    
	                });		

	                google.maps.event.addListener(marker, "drag", function(e) {
	                	setUIInfos(marker);
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
				setUIInfos(marker);
			    $('#branchAddr').attr("data-internalid", marker.id);
				selectedIndex = markers.indexOf(marker);
				processRequest("backendprocess.php?branchSelected=true&estabID="+estabID
					+"&branchID="+marker.id);
				setDownloadableQR(marker.id, "QRCodeBranchID" + marker.id);				
			}

			function setDownloadableQR(contents, filename) {
				console.log(contents + filename);
				contents = contents.toString();
				$('#qrCodeContainer').html("");
				$('#qrCodeContainer').qrcode({width: 150, height: 150, text:contents});
				var qrContainer = document.getElementById("qrCodeContainer").firstChild;
				$('#downloadQrCode').attr("href", qrContainer.toDataURL());	
				$('#downloadQrCode').attr("download", filename);				
			} 

			function setUIInfos(marker) {
				var latlngPOS = marker.getPosition().toString();
				latlngPOS = latlngPOS.substring(1, latlngPOS.length - 1).split(",");
				//console.log(latlngPOS);
				$('#latPOS').text("LAT: " + Number(latlngPOS[0]).toFixed(6));
				$('#lngPOS').text("LNG: " + Number(latlngPOS[1]).toFixed(6));
				$('#branchAddr').val(marker.address);
			}

			$('#addBranchBtn').on('click', function() {
				unSelectAllActionBtn();
				$(this).css("filter", "invert(100%)");
				toDelete = false;
				onlyDrag = false;
				onlySelect = false;
			});

			$('#delBranchBtn').on('click', function() {
				unSelectAllActionBtn();
				$(this).css("filter", "invert(100%)");
				toDelete = true;
			});

			$('#dragBranchBtn').on('click', function() {
				unSelectAllActionBtn();
				$(this).css("filter", "invert(100%)");
				toDelete = false;
				onlyDrag = true;
			});

			$('#selectBranchBtn').on('click', function() {
				unSelectAllActionBtn();
				$(this).css("filter", "invert(100%)");
				onlySelect = true;
			});

			function unSelectAllActionBtn() {
				$('#addBranchBtn').css("filter", "invert(0%)");
				$('#delBranchBtn').css("filter", "invert(0%)");
				$('#dragBranchBtn').css("filter", "invert(0%)");
				$('#selectBranchBtn').css("filter", "invert(0%)");
			}

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

			function getReverseGeocodingData(e, operation) {

			    var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
			    // This is making the Geocode request
			    var geocoder = new google.maps.Geocoder();
			    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
			        if (status !== google.maps.GeocoderStatus.OK) {
			            alert(status);
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
				if ($(this).val() == "EDIT") {
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

				$(this).val($(this).val() == "EDIT" ? "SAVE" : "EDIT");
			});								
		</script>
	</body>
</html>