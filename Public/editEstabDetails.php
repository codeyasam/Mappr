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

	$estab = Establishment::find_by_id($estabID);
	$estab->owner_id == $user->id ? null : redirect_to("index.php");
	$all_category = EstabCategory::find_all();
	$photos = EstabGallery::find_all(array("key" => "estab_id", "value" => $estab->id, "isNumeric" => true));
	//print_r($photos);
?>
<?php 
	if (isset($_POST['submit'])) {
		$estab->name = isset($_POST['estabName']) ? trim($_POST['estabName']) : "";
		$estab->category_id = isset($_POST['estabCategory']) ? trim($_POST['estabCategory']) : "";
		$estab->description = isset($_POST['description']) ? trim($_POST['description']) : "";
		$estab->tags = isset($_POST['tags']) ? trim($_POST['tags']) : "";
		if ($_FILES['img_upload']) {
			move_uploaded_file($_FILES['img_upload']['tmp_name'], "DISPLAY_PICTURES/estab_display_pic".$estab->id);
			$estab->display_picture = "DISPLAY_PICTURES/estab_display_pic".$estab->id;						
		}				
		$estab->update();	

		$gallery_array = reArrayFiles($_FILES['gallery']);		
		$fixedName = "GALLERY/estabGallery";
		foreach ($gallery_array as $key => $gallery) {
			$uniqueness = count(EstabGallery::find_all());
			$unique_path = $fixedName . $uniqueness;
			$estabGallery = new EstabGallery();
			$estabGallery->estab_id = $estab->id;
			$estabGallery->gallery_pic = $unique_path;		
			$estabGallery->create();

			move_uploaded_file($gallery['tmp_name'], $unique_path);
		}
		redirect_to("manageEstab.php?sbscrbdID=".urlencode($sbscrbdID));		
	}

	if (isset($_POST['deletePics'])) {
		foreach ($photos as $key => $photo) {
			if (isset($_POST['selected'][$key])) {
				BranchGallery::delete_all(array("key" => "gallery_id", "value" => $_POST['selected'][$key], "isNumeric" => true));

				EstabGallery::delete_by_id($_POST['selected'][$key]);
				unlink(SITE_ROOT . DS . "Public" . DS . $photo->gallery_pic);
			}
		}
		redirect_to("editEstabDetails.php?id=".urlencode($estabID)."&sbscrbdID=".urlencode($sbscrbdID));
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
		<div class="container edit-establishment center clearfix">
			<span style="margin-top:0;" />
			<form id="mainForm" action="editEstabDetails.php?id=<?php echo urlencode($estabID); ?>&sbscrbdID=<?php echo urlencode($sbscrbdID); ?>" enctype="multipart/form-data" method="post"  runat="server">
				<div class="manage" style="margin-top: 0;">
					<a style="background:#323232; padding: 10px 15px; border-radius: 0 20px 20px 0;" href="manageEstab.php?sbscrbdID=<?php echo urlencode($sbscrbdID); ?>">Go back</a>
					<div class="branch-dp"><img id="output" height="100px" width="100px" src="<?php echo htmlentities($estab->display_picture); ?>"/></div>
					
					<h5><i>Upload Display Photo</i></h5>
					<input type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/>
					<h5><i>Name:</i></h5>
					<input type="text" name="estabName" value="<?php echo htmlentities($estab->name); ?>" placeholder="Name" required="required"/>
					<h5><i>Category:</i></h5>
					<select name="estabCategory" >
					<?php foreach($all_category as $key => $eachCateg): ?>
						<?php $isSelected = ($eachCateg->id === $estab->category_id) ? "selected" : ""; ?>
						<option value="<?php echo $eachCateg->id; ?>"<?php echo $isSelected; ?>><?php echo htmlentities($eachCateg->name); ?></option>
					<?php endforeach; ?>
					</select>
					<h5><i>Description:</i></h5>
					<textarea name="description" placeholder="description"><?php echo htmlentities($estab->description); ?></textarea>
					<h5><i>Tags:</i></h5>
					<input type="text" name="tags" value="<?php echo htmlentities($estab->tags); ?>" placeholder="tags"/>
					<h5><i>Add photos to gallery:</i></h5>
					<input id="files" name="gallery[]" type="file" multiple="multiple"/>
					<input type="submit" name="submit" value="SAVE"/>
				</div>
				<div class="main-window">
					<h3>PHOTO GALLERY</h3>
					<div>
						<output class="li-align" id="result"></output>
					</div>
					
					
					<?php foreach ($photos as $key => $photo): ?>
						<div class="thumbnail" style="text-align:left;">
							<input type="checkbox" name="selected[<?php echo $key; ?>]" value="<?php echo $photo->id; ?>" style="position: absolute;"/>
							<img src="<?php echo $photo->gallery_pic; ?>" class=""/>
						</div>
					<?php endforeach; ?>
					<div>
						<input type="submit" name="deletePics" value="DELETE SELECTED PHOTOS" style="float:right;"/>
						<p style="clear:both;"></p>
					</div>									
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
		</div>
		<footer class="container center">
			<?php include '../includes/footer.php'; ?>
		</footer>
				
	</body>
</html>