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
			if (file_exists($_FILES['img_upload']['tmp_name'])) {
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
			//die("don't panic, I'm just debugging the site.");
			// var_dump($_FILES['gallery']);
			// $gallery_array = reArrayFiles($_FILES['gallery']);
			$gallery_array = reArrayFiles($_FILES['gallery']);
			echo "<pre>";
				print_r($gallery_array);
			echo "</pre>";		
			
			if($_FILES['gallery']['error'][0] == 0){
				$fixedName = "GALLERY/estabGallery";
				foreach ($gallery_array as $key => $gallery) {
					$uniqueness = count(EstabGallery::find_all()) + 1;
					$unique_path = $fixedName . $uniqueness;
					$estabGallery = new EstabGallery();
					$estabGallery->estab_id = $new_estab->id;
					$estabGallery->gallery_pic = $unique_path;		
					$estabGallery->create();
					
					//quick fix for uniqueness
					$unique_path = $fixedName . $estabGallery->id;
					$estabGallery->gallery_pic = $unique_path;
					$estabGallery->update();
					//end of quick fixs
					
					move_uploaded_file($gallery['tmp_name'], $unique_path);
				}
			}

			//DONT FORGET TO ADD THE RECORD TO THE SUBSPLAN_ESTAB_TB			
			$subsPlanEstab = new SubsPlanEstab();
			$subsPlanEstab->subs_plan_id = $subsPlan->id;
			$subsPlanEstab->estab_id = $new_estab->id;
			$subsPlanEstab->create();

			MapprActLog::recordActivityLog("Added an Establishment: " . $new_estab->name . " [EstablishmentID - " . $new_estab->id . "]", $user->id);

			redirect_to("manageEstab.php?sbscrbdID=".$_GET['id']);
		}


				

	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<style type="text/css">
		</style>
		<?php include '../includes/styles.php'; ?>
	</head>
	<body>
		<header>
			<div class="center">			
				<?php include("../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container edit-establishment center clearfix">	
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="heading-label">
						<span class="glyphicon glyphicon-plus"></span> Add Establishment
					</h1>
				</div>
				<div class="panel-body">
					<!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum. -->

					<form id="mainForm" action="addEstab.php?id=<?php echo urlencode($_GET['id']); ?>" enctype="multipart/form-data" method="post"  runat="server">
						<!-- <div class="manage" style="margin-top: 0;"> -->

							<div class="form-group text-center" style="padding: 10px;">
								<div class="branch-dp round-image drop-shadow" style="display:inline-block; text-align:center; width: 125px; height: 125px; overflow: hidden;">
									<img id="output" src="DISPLAY_PICTURES/defaultEstabIcon.png"/>
								</div>
							</div>
							<div class="form-group">
								<label>Upload Logo</label>
								<input type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/>
							</div>
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" name="estabName" value="" placeholder="Name" required="required"/>
							</div>
							
							<div class="form-group">
								<label>Category</label>
								<select class="form-control" name="estabCategory" >
								<?php foreach($all_category as $key => $eachCateg): ?>
									<option value="<?php echo $eachCateg->id; ?>"><?php echo htmlentities($eachCateg->name); ?></option>
								<?php endforeach; ?>
								</select>
							</div>
							
							<div class="form-group">
								<label>Description</label>
								<textarea name="description" class="form-control" placeholder="Say something about your establishment..."></textarea>
							</div>
							
							<div class="form-group">
								<label>Tags</label>
								<input type="text" class="form-control" name="tags" value="" placeholder="tags"/>
							</div>
							
							<hr>
							<div class="form-group main-window clearfix">
								<label><h4>Photo Gallery</h4></label>
								<output class="li-align" id="result">

									<i><h4><span class="glyphicon glyphicon-picture"></span> No photos yet.</h4></i>
									
								</output>
							</div>
							
							<div class="form-group">
								<label>Add photos to gallery</label>
								<input id="files" name="gallery[]" type="file" multiple="multiple"/>
							</div>		

							<div class="form-group">
								<input type="submit" class="btn btn-primary" name="submit" value="Save"/>
							</div>
						<!-- </div> -->
					</form>
				</div>

			</div>
		</div>	
		<?php include '../includes/footer.php'; ?>
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
			            output.innerHTML = "";
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
			                    div.className += div.className + 'thumbnail ';
			                    div.className += div.className + 'establishment-gallery';
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
