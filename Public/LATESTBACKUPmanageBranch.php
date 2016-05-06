<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php isset($_GET['id']) ? null : redirect_to("index.php"); ?>
<?php  
	$condition['key'] = "estab_id";
	$condition['value'] = $database->escape_value($_GET['id']);
	$condition['isNumeric'] = true;
	$noOfBranches = count(EstabBranch::find_all($condition));

	if (isset($_POST['submit'])) {

	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<style type="text/css">
			#map {
			  height: 500px;
			  margin: 0;
			  width: 80%;
			}

			#autocomplete {
			  width: 80%;
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
		</style>		
	</head>
	<body>
		<?php include("../includes/navigation.php"); ?>
		<form action="manageBranch.php?id=<?php echo urlencode($_GET['id']); ?>" method="POST" style="float:left; width: 19%;">
			<p>Lorem Ipsum FORM for Gallery?</p>
			<input id="estabID" type="hidden" name="estabID" value="<?php echo urlencode($_GET['id']); ?>"/>
			<div id="infos">
				<p id="latPOS">lat: </p>
				<p id="lngPOS">lng: </p>
				<p><input id="branchAddr" type="text"/>
				<input id="optEditSave" type="submit" value="EDIT"/></p>	

				<div id="galleryContainer">

				</div>			
			</div>
		</form>
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDDpPDWu9z820FMYyOVsAphuy0ryz4kt2o&libraries=places&sensor=false"></script>

		<input type="text" id="autocomplete">
		<div id="map"></div>	


		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript">
			$('#branchAddr').prop('disabled', true);
			// var testing = JSON.parse('{"emman":[{"yasa":"name"},{"yeah":"heay"}]}');
			// for (var key in testing.emman) {
			// 	if (testing.emman.hasOwnProperty(key)) {
			// 		console.log(testing.emman[key].yasa);
			// 	}
			// }

			var estabID = document.getElementById('estabID').value;
			var objReq = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
			var selectedIndex = false;
			processRequest("backendprocess.php?retrieveBranches=true&estabID="+estabID)
			//processRequest("backendprocess.php?getGallery=true&estabID="+estabID);

			function processRequest(suppliedURL) {
				if (objReq) {
					objReq.open("GET", suppliedURL, true);
					objReq.onreadystatechange = handleServerResponse;
					objReq.send(null);
				} else {
					setTimeout("processRequest()", 1000);
				}
			}

			function handleServerResponse() {
				if (objReq.readyState == 4 && objReq.status == 200) {
					console.log(selectedIndex + " selected index to.");
					console.log(objReq.responseText);
					var jsonObj = JSON.parse(objReq.responseText);
					if (jsonObj.setBranchID) {
						markers[selectedIndex].id = jsonObj.id;
						markers[selectedIndex].address = jsonObj.address;
						console.log(jsonObj.address);
						$('#branchAddr').val(jsonObj.address);
						setUIInfos(markers[selectedIndex]);
						//var latlngPOS = markers[selectedIndex].getPosition().toString();
						//console.log(latlngPOS);
						//$('#latPOS').text("lat: " + latlngPOS);
					} else if (jsonObj.Branches) {
						for (var key in jsonObj.Branches) {
							if (jsonObj.Branches.hasOwnProperty(key)) {
								
								var markerOptions = {
									map: map,
									draggable: true,
									animation: google.maps.Animation.DROP,
								    position: new google.maps.LatLng(jsonObj.Branches[key].lat, jsonObj.Branches[key].lng)
								};	

								var marker = new google.maps.Marker(markerOptions);	
								marker.setMap(map);			  	
								marker.id = jsonObj.Branches[key].id;
								marker.address = jsonObj.Branches[key].address;
								markers.push(marker);	

					            (function (marker) {
					                google.maps.event.addListener(marker, "click", function () {
					                    //Wrap the content inside an HTML DIV in order to set height and width of InfoWindow.
					                    //console.log("dito naaaa");
					                    //console.log(marker.getPosition().toString());
					                    //console.log(marker.branchID);
					                    deleteMarker(marker, markers);				                    
					                });		

					                google.maps.event.addListener(marker, "drag", function(e) {
					                	//console.log(marker.getPosition().toString());
					                	setUIInfos(marker);
					                });			            	

									google.maps.event.addListener(marker, 'dragend', function(e) {
										var index = markers.indexOf(marker);
										console.log(marker.id);
										getReverseGeocodingData(e, marker, "update");
										console.log("inpudate");
										setUIInfos(marker);
									    // marker.position = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
									    // markers.push(marker);
									});							            	
					            })(marker);														
							}
						}
					} else if (jsonObj.updatedAddr) {
						markers[selectedIndex].address = jsonObj.updatedAddr;
					} 

					if (jsonObj.Gallery) {
						$('#galleryContainer').html("");
						var photoContainer = "";
						for (var key in jsonObj.Gallery) {
							if (jsonObj.Gallery.hasOwnProperty(key)) {
								photoContainer += '<div class="thumbnail" style="text-align:left;">';
								if (jsonObj.BranchID)
									photoContainer += '<input type="checkbox" style="position:absolute;"/>';
								photoContainer += '<img src="' + jsonObj.Gallery[key].gallery_pic + '"/>';
								photoContainer += '</div>';
							}
						}
						$('#galleryContainer').append(photoContainer);
					}
				}
			}

			$('#optEditSave').on("click", function(e) {
				e.preventDefault();
				//console.log($(this).val());
				if ($(this).val() == "EDIT") {
					$('#branchAddr').prop('disabled', false);
				}  else {
					$('#branchAddr').prop('disabled', true);
					processRequest("backendprocess.php?saveBranchAddr=true&branchID=" 
						+ $('#branchAddr').attr("data-internalid") + "&address=" 
						+ $('#branchAddr').val());
				}

				$(this).val($(this).val() == "EDIT" ? "SAVE" : "EDIT");
			});
		
			var mapOptions = {
			    center: new google.maps.LatLng(37.7831,-122.4039),
			    zoom: 12,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			var map = new google.maps.Map(document.getElementById('map'), mapOptions);

			//Autocomplete
			var acOptions = {
				types: ['establishment']
			};

			var autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'),acOptions);
			autocomplete.bindTo('bounds',map);
			var infoWindow = new google.maps.InfoWindow();

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

			google.maps.event.addListener(map,'click',function(e){
				//console.log('clicked');
				var markerOptions = {
					map: map,
					draggable: true,
					animation: google.maps.Animation.DROP,
				    position: new google.maps.LatLng(e.latLng.lat(), e.latLng.lng())
				};					
				
				var marker = new google.maps.Marker(markerOptions);				

				if (toDelete == false) {
					marker.setMap(map);			  	
					markers.push(marker);
					//console.log("execute")
					getReverseGeocodingData(e, marker, "create");
				} else {
					marker.setMap(null);
					marker = null;
				}

				if (marker != null) {
					google.maps.event.addListener(marker, 'click', function() {
						console.log(marker.id);
						deleteMarker(marker, markers);
						// if (toDelete == true) {
						// 	var branchID = marker.branchID;
						// 	processRequest("backendprocess.php?deleteBranch=true&branchID="+branchID);
						// 	var index = markers.indexOf(marker);	
						// 	marker.setMap(null);
						// 	marker = null;
						// 	markers.splice(index, 1);
						// }
					});

	                google.maps.event.addListener(marker, "drag", function(e) {
	                	//console.log(marker.getPosition().toString());
	                	setUIInfos(marker);
	                });
					
					google.maps.event.addListener(marker, 'dragend', function(e) {
						var index = markers.indexOf(marker);
						console.log(marker.id);
						getReverseGeocodingData(e, marker, "update");
						console.log("inpudate");
						setUIInfos(marker);
					    // marker.position = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
					    // markers.push(marker);
					});					
				}
			});

			// Create the DIV to hold the control and call the CenterControl()
			// constructor passing in this DIV.
			var actionSignifier = ["add", "del"];
			var actionObj = [];
			var markers = [];
			var toDelete = false;
			//console.log(actionSignifier.length);

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

			function deleteMarker(marker, markers) {
				

				if (toDelete == true) {
					var branchID = marker.id;
					processRequest("backendprocess.php?deleteBranch=true&branchID="+branchID);
					var index = markers.indexOf(marker);	
					marker.setMap(null);
					marker = null;
					markers.splice(index, 1);
				} else {
					setUIInfos(marker);
				    $('#branchAddr').attr("data-internalid", marker.id);
					$('#branchAddr').val(marker.address);
					selectedIndex = markers.indexOf(marker);
					processRequest("backendprocess.php?branchSelected=true&estabID="+estabID
						+"&branchID="+marker.id);
				} 				
			}

			function setUIInfos(marker) {
				var latlngPOS = marker.getPosition().toString();
				latlngPOS = latlngPOS.substring(1, latlngPOS.length - 1).split(",");
				//console.log(latlngPOS);
				$('#latPOS').text("LAT: " + Number(latlngPOS[0]).toFixed(6));
				$('#lngPOS').text("LNG: " + Number(latlngPOS[1]).toFixed(6));
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

			function getReverseGeocodingData(e, marker, operation) {

			    var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
			    // This is making the Geocode request
			    var geocoder = new google.maps.Geocoder();
			    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
			        if (status !== google.maps.GeocoderStatus.OK) {
			            alert(status);
			        }
			        // This is checking to see if the Geoeode Status is OK before proceeding
			        if (status == google.maps.GeocoderStatus.OK) {
			        	var index = markers.indexOf(marker);
			            var address = (results[0].formatted_address);
			            var estabID = document.getElementById('estabID').value;
			            console.log(index);
			            selectedIndex = index;

			            //necessary data
			            //console.log(address);
			            //console.log(e.latLng.lat());
			            //console.log(e.latLng.lng());
			            if (operation == "update") {
			            	processRequest("backendprocess.php?updateBranch=true&addr="+address+"&lat="+e.latLng.lat()+"&lng="+e.latLng.lng()+"&estabID="+estabID+"&branchID="+marker.id);
			            } else if (operation == "create") {
			            	processRequest("backendprocess.php?createBranch=true&addr="+address+"&lat="+e.latLng.lat()+"&lng="+e.latLng.lng()+"&estabID="+estabID);			            				            			            
			            }

			        }
			    });

			}						
		</script>		
	</body>
</html>