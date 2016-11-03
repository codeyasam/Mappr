<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php isset($_GET['id']) ? null : redirect_to("index.php"); ?>
<?php  
	$currentSubsPlanEstab = SubsPlanEstab::find_by_id($_GET['id']);
	$sbscrbdID = $currentSubsPlanEstab->subs_plan_id;
	$estabID = $currentSubsPlanEstab->estab_id;
	$user_subscriptions = SubsPlan::get_owner_subscriptions($user->id);
	$subscriptionIDs = array_map(function($obj) { return $obj->id;}, $user_subscriptions);
	//print_r($subscriptionIDs);
	//echo $sbscrbdID;
	//die("beforeindex");
	//die($estabID);
	in_array($sbscrbdID, $subscriptionIDs) ? null : redirect_to("index.php");

	$estab = Establishment::find_by_id($estabID);
	//die($estab->owner_id . " " . $user->id);
	$estab->owner_id == $user->id ? null : redirect_to("index.php");
	
	$all_category = EstabCategory::find_all();
	$photos = EstabGallery::find_all(array("key" => "estab_id", "value" => $estab->id, "isNumeric" => true));
	//print_r($photos);
?>
<?php 
	if (isset($_POST['submit'])) {
		
		//For record keeping - activity logs
		if ($estab->name != trim($_POST['estabName'])) {
			MapprActLog::recordActivityLog("Updated an Establishment: " . $estab->name . "[EstablishmentID - " . $estabID . "] name from " . $estab->name . " to " . trim($_POST['estabName']), $user->id);
		} 
		
		if ($estab->category_id != trim($_POST['estabCategory'])) {
			$old_categ = EstabCategory::find_by_id($estab->category_id);
			$selected_categ = EstabCategory::find_by_id(trim($_POST['estabCategory']));
			MapprActLog::recordActivityLog("Updated an Establishment: " . $estab->name . "[EstablishmentID - " . $estabID . "] category from " . $old_categ->name . " to " . $selected_categ->name, $user->id);
		}
		
		if ($estab->description != trim($_POST['description'])) {
			MapprActLog::recordActivityLog("Updated an Establishment: " . $estab->name . "[EstablishmentID - " . $estabID . "] description from " . $estab->description . " to " . trim($_POST['description']), $user->id);
		}
		
		//end of record keeping - activity logs
			
		
		$estab->name = isset($_POST['estabName']) ? trim($_POST['estabName']) : "";
		$estab->category_id = isset($_POST['estabCategory']) ? trim($_POST['estabCategory']) : "";
		$estab->description = isset($_POST['description']) ? trim($_POST['description']) : "";
		$estab->tags = isset($_POST['tags']) ? trim($_POST['tags']) : "";
		if (file_exists($_FILES['img_upload']['tmp_name'])) {
			move_uploaded_file($_FILES['img_upload']['tmp_name'], "DISPLAY_PICTURES/estab_display_pic". $estab->id);
			$estab->display_picture = "DISPLAY_PICTURES/estab_display_pic" . $estab->id;						
		}				
		$estab->update();	

		if($_FILES['gallery']['error'][0] == 0){
			$gallery_array = reArrayFiles($_FILES['gallery']);		
			$fixedName = "GALLERY/estabGallery";
			foreach ($gallery_array as $key => $gallery) {
				$uniqueness = count(EstabGallery::find_all()) + 1;
				$unique_path = $fixedName . $uniqueness;
				$estabGallery = new EstabGallery();
				$estabGallery->estab_id = $estab->id;
				$estabGallery->gallery_pic = $unique_path;		
				$estabGallery->create();

				move_uploaded_file($gallery['tmp_name'], $unique_path);
			}
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
		redirect_to("editEstabDetails.php?id=".urlencode($_GET['id'])."&sbscrbdID=".urlencode($sbscrbdID));
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
			<div class="panel panel-warning drop-shadow">
				<div class="panel-heading">
					<h1 class="heading-label"><span class="glyphicon glyphicon-pencil"></span> Edit Establishment Details</h1>
				</div>
				<div class="panel-body">
					<form id="mainForm" action="editEstabDetails.php?id=<?php echo urlencode($_GET['id']); ?>&sbscrbdID=<?php echo urlencode($sbscrbdID); ?>" enctype="multipart/form-data" method="post"  runat="server">
						<div class="form-group text-center" style="padding: 10px;">
							<div class="branch-dp round-image drop-shadow" style="display:inline-block; text-align:center; width: 125px; height: 125px; overflow: hidden;">
								<img id="output" src="<?php echo htmlentities($estab->display_picture); ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label>Upload Logo</label>
							<input type="file" name="img_upload" accept="image/*" onchange="loadFile(event)"/>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" name="estabName" value="<?php echo htmlentities($estab->name); ?>" placeholder="Name" required="required"/>
						</div>
						
						<div class="form-group">
							<label>Category</label>
							<select class="form-control" name="estabCategory" >
							<?php foreach($all_category as $key => $eachCateg): ?>
								<?php $isSelected = ($eachCateg->id === $estab->category_id) ? "selected" : ""; ?>
								<option value="<?php echo $eachCateg->id; ?>"<?php echo $isSelected; ?>><?php echo htmlentities($eachCateg->name); ?></option>
							<?php endforeach; ?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Description</label>
							<textarea name="description" class="form-control" placeholder="Say something about your establishment..."><?php echo htmlentities($estab->description); ?></textarea>
						</div>
						
						<div class="form-group">
							<label>Tags</label>
							<input type="text" class="form-control" name="tags" value="<?php echo htmlentities($estab->tags); ?>" placeholder="tags"/>
						</div>						
						<hr>
						<div class="form-group main-window clearfix">
							<label><h4>Photo Gallery</h4></label>
							<br>					
							<?php foreach ($photos as $key => $photo): ?>
								<div class="thumbnail" style="text-align:left;">
									<input type="checkbox" name="selected[<?php echo $key; ?>]" value="<?php echo $photo->id; ?>" style="position: absolute;"/>
									<img src="<?php echo $photo->gallery_pic; ?>" class=""/>
								</div>
							<?php endforeach; ?>
							<output class="li-align" id="result">
								<?php if(count($photos) <= 0) { ?>
									<i><h4><span class="glyphicon glyphicon-picture"></span> No photos yet.</h4></i>
								<?php } ?>
							</output>
						</div>
						<div class="form-group">
							<label>Add photos to gallery</label>
							<input id="files" name="gallery[]" type="file" multiple="multiple"/>
						</div>		
						

						<div class="form-group">
							<input type="submit" name="deletePics" class="btn btn-danger" value="Delete Selected"/>
							<input type="submit" class="btn btn-primary" name="submit" value="Save"/>
						</div>
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