<?php require_once("../includes/initialize.php"); ?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div id="formContainer">
		<input id="pic" type="file" name="img_upload" accept="image/*"/>
		<input id="submit" type="submit" name="submit" value="submit"/>				
	</div>

	<script type="text/javascript" src="../Public/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../Public/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../Public/js/functions.js"></script>
	<script type="text/javascript">

		function handleServerResponse() {
			if (objReq.readyState == 4 && objReq.status == 200) {
				console.log(objReq.responseText);
				var jsonObj = JSON.parse(objReq.responseText);
				if (jsonObj.successna) {
					console.log("na process");
				}
			}
		}

		function handleSuccessResponse(response) {
			console.log(response);
		}

		$('#submit').on('click', function(e) {
			e.preventDefault();
			var pic = document.getElementById('pic').files[0];
			var formData = new FormData();
			formData.append('file', pic);
			formData.append('testlang', 'true');
			$.ajax({
				url: 'test_backendprocess.php',
				type: 'POST',
				data: formData,
				success: function(response) {
					console.log("yeah yea");
					console.log(response);
				},
				cache: false,
				contentType: false,
				processData: false
			});
		});	
	</script>		
</body>
</html>