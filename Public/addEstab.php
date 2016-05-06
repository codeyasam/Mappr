<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php isset($_GET['id']) ? null : redirect_to("index.php"); ?>
<?php  
	//IMPORTANT
	/*
		- validate image
		- other validations
	*/
	$subsPlan = SubsPlan::find_by_id($_GET['id']);
	$subsPlan ? null : redirect_to("index.php");
	$all_category = EstabCategory::find_all();
	if (isset($_POST['submit'])) {
		$new_estab = new Establishment();
		$new_estab->owner_id = $user->id;
		$new_estab->name = isset($_POST['estabName']) ? trim($_POST['estabName']) : "";
		$new_estab->category_id = isset($_POST['estabCategory']) ? trim($_POST['estabCategory']) : "";
		$new_estab->description = isset($_POST['description']) ? trim($_POST['description']) : "";
		$new_estab->tags = isset($_POST['tags']) ? trim($_POST['tags']) : "";	
			
		// NECESSARY PART 
		if ($new_estab->create()) {
			if ($_FILES['img_upload']) {
				move_uploaded_file($_FILES['img_upload']['tmp_name'], "DISPLAY_PICTURES/estab_display_pic".$new_estab->id);
				$new_estab->display_picture = "DISPLAY_PICTURES/estab_display_pic".$new_estab->id;			
				$new_estab->update();				
			}

			// DEBUGGING PART
			// EstabGallery
			// Uniqueness 	echo count(EstabGallery::find_all());
			echo "<pre>";
				print_r($_FILES['gallery']);
			echo "</pre>";
			// var_dump($_FILES['gallery']);
			// $gallery_array = reArrayFiles($_FILES['gallery']);
			$gallery_array = reArrayFiles($_FILES['gallery']);
			echo "<pre>";
				print_r($gallery_array);
			echo "</pre>";		
			$fixedName = "GALLERY/estabGallery";
			foreach ($gallery_array as $key => $gallery) {
				$uniqueness = count(EstabGallery::find_all());
				$unique_path = $fixedName . $uniqueness;
				$estabGallery = new EstabGallery();
				$estabGallery->estab_id = $new_estab->id;
				$estabGallery->gallery_pic = $unique_path;		
				$estabGallery->create();

				move_uploaded_file($gallery['tmp_name'], $unique_path);
			}

			//DONT FORGET TO ADD THE RECORD TO THE SUBSPLAN_ESTAB_TB			
			$subsPlanEstab = new SubsPlanEstab();
			$subsPlanEstab->subs_plan_id = $subsPlan->id;
			$subsPlanEstab->estab_id = $new_estab->id;
			$subsPlanEstab->create();

			redirect_to("manageEstab.php?sbscrbdID=".$_GET['id']);
		}


				

	}

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
		<?php include("../includes/navigation.php"); ?>
		<form id="mainForm" action="addEstab.php?id=<?php echo urlencode($_GET['id']); ?>" enctype="multipart/form-data" method="post"  runat="server">
			<div style="width: 20%; float: left;">
				<p><img id="output" height="100px" width="100px" src=""/></p>
				<p><input type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/></p>
				<p><input type="text" name="estabName" value="" placeholder="Name" required="required"/></p>
				<p><select name="estabCategory" >
				<?php foreach($all_category as $key => $eachCateg): ?>
					<option value="<?php echo $eachCateg->id; ?>"><?php echo htmlentities($eachCateg->name); ?></option>
				<?php endforeach; ?>
				</select></p>
				<p><textarea name="description" placeholder="description"></textarea></p>
				<p><input type="text" name="tags" value="" placeholder="tags"/></p>
				<p>Add photos to gallery: </p>
				<p><input id="files" name="gallery[]" type="file" multiple="multiple"/></p>
				<p><input type="submit" name="submit" value="SAVE"/></p>
			</div>
			<div style="width: 80%; float: left;">
				<h3>PHOTO GALLERY</h3>
				<output class="li-align" id="result" />
			</div>
		</form>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>	
		<script type="text/javascript" src="js/myScript.js"></script>
		<script type="text/javascript">
			var loadFile = function(event) {
			   	var output = document.getElementById('output');
			   	output.src = URL.createObjectURL(event.target.files[0]);
			   	$('#urlContent').attr('value', "");
			};		
			
		    if(window.File && window.FileList && window.FileReader)
		    {
		        var filesInput = document.getElementById("files");
		        filesInput.addEventListener("change", function(event){
		            var files = event.target.files; //FileList object
		            var output = document.getElementById("result");
		            for(var i = 0; i< files.length; i++)
		            {
		                var file = files[i];
		                //Only pics
		                if(!file.type.match('image'))
		                    continue;
		                var picReader = new FileReader();
		                picReader.addEventListener("load",function(event){
		                    var picFile = event.target;
		                    var div = document.createElement("div");
		                    div.className += div.className + 'thumbnail';
		                    div.innerHTML = "<img src='" + picFile.result + "'" +
		                    "title='" + picFile.name + "'/>";
		                    output.insertBefore(div,null);
		                });
		                //Read the image
		                picReader.readAsDataURL(file);
		            }
		        });
		    }					
		</script>		
	</body>
</html>