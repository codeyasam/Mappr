<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php isset($_GET['id']) ? null : redirect_to("index.php"); ?>
<?php  
	$condition['key'] = "estab_id";
	$condition['value'] = $database->escape_value($_GET['id']);
	$condition['isNumeric'] = true;
	$noOfBranches = count(EstabBranch::find_all($condition));

	if (isset($_POST['submit'])) {
		//debugging
		//echo $_GET['id']; //kusang nababago kahit palitan pa sa taas dahil sa form action
		//debugging
		$addressesArray = explode("<>",$_POST['addressesStorage']);
		print_r($addressesArray);
		$allCoords = explode(")(", substr($_POST['allCoords'], 1, -1));
		print_r($allCoords);
		foreach ($allCoords as $key => $eachCoords) {
			$latlng = explode(",", $eachCoords);
			$newBranch = new EstabBranch();
			$newBranch->estab_id = $_GET['id'];
			$newBranch->address = $addressesArray[$key];
			$newBranch->lat = $latlng[0];
			$newBranch->lng = $latlng[1];
			$newBranch->create();
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<style type="text/css">
			html, body, #map {
			  height: 100%;
			  margin: 0;
			}

			#autocomplete {
			  width: 100%;
			  height: 25px;
			}			
		</style>		
	</head>
	<body>
		<?php include("../includes/navigation.php"); ?>
		<form action="manageBranch.php?id=<?php echo urlencode($_GET['id']); ?>" method="POST">
			<input id="allCoords" type="hidden" name="allCoords" value=""/>
			<input id="addressesStorage" type="hidden" name="addressesStorage"/>
			<input type="submit" name="submit" value="REGISTER"/>
		</form>
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDDpPDWu9z820FMYyOVsAphuy0ryz4kt2o&libraries=places&sensor=false"></script>
		<input type="text" id="autocomplete">
		<div id="map"></div>


		<script type="text/javascript">
			var addressesStorage = document.getElementById('addressesStorage');
			var addressesArray = [];
		
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

			var allCoords = document.getElementById("allCoords");

			google.maps.event.addListener(map,'click',function(e){

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
					console.log("execute")
					getReverseGeocodingData(e.latLng.lat(), e.latLng.lng());
				} else {
					marker.setMap(null);
					marker = null;
				}

				if (marker != null) {
					google.maps.event.addListener(marker, 'click', function() {
						if (toDelete == true) {
							var index = markers.indexOf(marker);
							console.log("must be first");	
							marker.setMap(null);
							marker = null;
							markers.splice(index, 1);

							//debugggggg
							//console.log(index);	
							addressesArray.splice(index, 1);
							//end debuuuug								

							setCoordsAndAddresses(e);
				
						}
					});
					google.maps.event.addListener(marker, 'dragend', function(e) {
						var index = markers.indexOf(marker);
					    //geocodePosition(marker.getPosition());
					    markers.splice(index, 1);
					    addressesArray.splice(index, 1);
					    // console.log(addressesArray);

					    marker.position = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
					    markers.push(marker);

					    getReverseGeocodingData(e.latLng.lat(), e.latLng.lng());
					    setCoordsAndAddresses();
					});					
				}

				setCoordsAndAddresses(e);
			});

			// Create the DIV to hold the control and call the CenterControl()
			// constructor passing in this DIV.
			var actionSignifier = ["add", "del"];
			var actionObj = [];
			var markers = [];
			var toDelete = false;
			console.log(actionSignifier.length);

			for (var i = 0; i < actionSignifier.length; i++) {
				var centerControlDiv = document.createElement('div');
				var centerControl = CenterControl(centerControlDiv, map, actionSignifier[i]);				
				actionObj.push(centerControl);

				centerControlDiv.index = 1;
				map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
			}

			console.log(actionObj);
			actionObj[0].addEventListener('click', function(e) {
				console.log("print lang");
				toDelete = false;
			});

			actionObj[1].addEventListener('click', function() {
				console.log("delete latLng");
				toDelete = true;
			});

			function setCoordsAndAddresses() {
				allCoords.value = "";
				var outputString = "";
				for (var i = 0; i < markers.length; i++) {
					outputString += markers[i].getPosition().toString();
				}
				allCoords.value = outputString;
				console.log(outputString);			
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

			function geocodePosition(pos) {
			   geocoder = new google.maps.Geocoder();
			   geocoder.geocode
			    ({
			        latLng: pos
			    }, 
			        function(results, status) 
			        {
			            if (status == google.maps.GeocoderStatus.OK) 
			            {
			                $("#mapSearchInput").val(results[0].formatted_address);
			                $("#mapErrorMsg").hide(100);
			                console.log(results[0].formatted_address);
			            } 
			            else 
			            {
			                $("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
			            }
			        }
			    );
			}

			function getReverseGeocodingData(lat, lng) {

			    var latlng = new google.maps.LatLng(lat, lng);
			    // This is making the Geocode request
			    var geocoder = new google.maps.Geocoder();
			    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
			        if (status !== google.maps.GeocoderStatus.OK) {
			            alert(status);
			        }
			        // This is checking to see if the Geoeode Status is OK before proceeding
			        if (status == google.maps.GeocoderStatus.OK) {
			            var address = (results[0].formatted_address);
			            addressesArray.push(address);
			        	console.log(addressesArray);
			        }
			        addressesStorage.value = addressesArray.join("<>");
			    });

			}			
					
		</script>		
	</body>
</html>