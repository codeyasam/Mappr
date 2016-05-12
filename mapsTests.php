<!DOCTYPE html>
<html>
	<head>
		<title>Google Maps WEB</title>
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
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDDpPDWu9z820FMYyOVsAphuy0ryz4kt2o&libraries=places"></script>
		<input type="text" id="autocomplete">
		<div id="map"></div>
		<script type="text/javascript">
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
			//End of autocomplete

			//Creating markers
			// var markerOptions = {
			//     position: new google.maps.LatLng(37.7831, -122.4039)
			// };

			// var marker = new google.maps.Marker(markerOptions);
			// marker.setMap(map);		
			//End of creating of markers

			google.maps.event.addListener(map,'click',function(e){
				// console.log(e.latLng);
			  	// console.log("Latitude: " + e.latLng.lat());
			  	// console.log("Longhitude: " + e.latLng.lng());
				var markerOptions = {
					map: map,
					draggable: true,
					animation: google.maps.Animation.DROP,
				    position: new google.maps.LatLng(e.latLng.lat(), e.latLng.lng())
				};					
				
				var marker = new google.maps.Marker(markerOptions);				
				console.log(toDelete);
				if (toDelete == false) {
					marker.setMap(map);			  	
					markers.push(marker);
				} else {
					marker.setMap(null);
					marker = null;
				}

				if (marker != null) {
					google.maps.event.addListener(marker, 'click', function() {
						if (toDelete == true) {
							marker.setMap(null);
							marker = null;
						} else {
							google.maps.event.addListener(marker, 'dragend', function() 
							{
							    geocodePosition(marker.getPosition());
							});						
						}
					});
				}


				
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


			// var centerControlDiv = document.createElement('div');
			// var centerControl = CenterControl(centerControlDiv, map);
			
			// centerControl.addEventListener('click', function() {
			// console.log("print lang");
			// });

			// centerControlDiv.index = 1;
			// map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);


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
			            } 
			            else 
			            {
			                $("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
			            }
			        }
			    );
			}
					
		</script>
	</body>
</html>