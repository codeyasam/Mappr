<?php require_once('../../includes/initialize.php'); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "SUPERADMIN" ? redirect_to("../index.php") : null;	
?>

<?php  
	if (isset($_POST['blockAdmin'])) {
		$user_to_block = User::find_by_id($_GET['id']);
		if ($user_to_block->user_type == "OWNER") {
			$user_to_block->account_status = "BLOCKED";
			$user_to_block->update();
			MapprActLog::recordActivityLog("Blocked Business Owner " . $user_to_block->full_name(), $user->id);
		}
	}
?>

<?php  
	if (isset($_POST['unblockAdmin'])) {
		$user_to_unblock = User::find_by_id($_GET['id']);
		if ($user_to_unblock->user_type == "OWNER") {
			$user_to_unblock->account_status = "ACTIVE";
			$user_to_unblock->login_attempt = 0;
			$user_to_unblock->update();	
			MapprActLog::recordActivityLog("Unblocked Business Owner " . $user_to_unblock->full_name(), $user->id);		
		}
	}
?>

<?php  
	$all_admins = User::find_all(array('key'=>'user_type', 'value'=>'OWNER', 'isNumeric'=>false));
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<?php include '../../includes/styles_admin.php'; ?>
		<link rel="stylesheet" type="text/css" href="../js/jquery-ui.css">		
	</head>
	<body>
		<input id="manageState" type="hidden" name="" value="<?php if(isset($_SESSION['message'])) echo htmlentities($_SESSION['message']); ?>">
		<header>
			<div class="center">		
				<?php include("../../includes/navigation.php"); ?>
			</div>
		</header>
		<div class="banner"></div>
		<div class="container page-wrap">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h1 class="heading-label"><span class="glyphicon glyphicon-cog"></span> Manage Business Owners</h1>
				</div>
				<div class="panel-body">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</div>
				<div class="clearfix">
					<table id="adminContainer" class="table table-hover data" style="float: right; width: 100%;">
						<tr>
							<th>#</th>
							<th>Username</th>
							<th>E-mail Address</th>
							<th>Name</th>
							<th>Display Picture</th>
							<th>Status</th>
							<!-- <th colspan="3">Options</th> -->
							<th colspan="2">Options</th>
						</tr>

						<?php foreach ($all_admins as $key => $eachAdmin): ?>
							<tr class='text-center'>
								<td><?php echo htmlentities($eachAdmin->id); ?></td>
								<td><?php echo htmlentities($eachAdmin->username); ?></td>
								<td><?php echo htmlentities($eachAdmin->email); ?></td>
								<td><?php echo htmlentities($eachAdmin->full_name()); ?></td>
								<td>
									<div class="round-image drop-shadow" style="margin-left: 0;display:inline-block; text-align:center; width: 35px; height: 35px; overflow: hidden;">
										<img style="width: 40px; margin-left: -3px;" class="category-icon" src="<?php echo htmlentities($eachAdmin->display_picture); ?>"/>
									</div>
								</td>
								<td><?php echo htmlentities($eachAdmin->account_status); ?></td>
								<td class="text-center"><a href="adminsActivityLog.php?id=<?php echo $eachAdmin->id; ?>"><span class="glyphicon glyphicon-list"></span><br>Activity&nbsp;Log</a></td>
								<!-- <td class="text-center"><a data-internalid="manageOwners.php?id=<?php echo htmlentities($eachAdmin->id); ?>" class="text-danger optDelete" href=""><span class="glyphicon glyphicon-remove"></span><br>Delete</a></td> -->
								<td class="text-center"><?php if ($eachAdmin->account_status == "ACTIVE") { ?><a data-internalid="manageOwners.php?id=<?php echo htmlentities($eachAdmin->id); ?>" class="text-warning optBlock" href=""><span class="glyphicon glyphicon-ban-circle"></span><br>Block</a> <?php } else { ?><a data-internalid="manageOwners.php?id=<?php echo htmlentities($eachAdmin->id); ?>" class="text-warning optUnblock" href=""><span class="glyphicon glyphicon-ok-circle"></span><br>Unblock</a><?php } ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				<div id="dialogDelete" style="display: none;" title="Confirmation Required">
					<p>Are you sure you want to delete this log?</p>
					<form action="" method="POST"> 
						<input id="confirmBtn" type="submit" name="deleteAdmin" value="OK" />
						<input id="cancelBtn" type="button" value="CANCEL" />
					</form>
				</div>
			</div>
		</div>
		<?php require_once('../../includes/footer.php'); ?>	
		<div class="mLoadingEffect"></div>
		<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="../js/functions.js"></script>
		<script type="text/javascript">		
			console.log("working fine.");

			$('#dialogDelete').dialog({
				autoOpen: false,
				modal: true
			});			
			
			$('.optBlock').on('click', function() {
				$('#dialogDelete > form').attr("action", $(this).attr('data-internalid'));
				$('#dialogDelete > p').text("Are you sure you want to block this business owner?");
				$('#confirmBtn').attr("name", "blockAdmin");
				$('#dialogDelete').dialog('open');
				return false;
			});

			$('.optUnblock').on('click', function() {
				$('#dialogDelete > form').attr("action", $(this).attr('data-internalid'));
				$('#dialogDelete > p').text("Are you sure you want to unblock this business owner?");
				$('#confirmBtn').attr("name", "unblockAdmin");
				$('#dialogDelete').dialog('open');
				return false;				
			});	
				
		</script>			
	</body>
</html>