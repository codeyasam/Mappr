<?php require_once("../includes/initialize.php"); ?>
<?php $user = $session->is_logged_in() ? User::find_by_id($session->user_id) : redirect_to("login.php"); ?>
<?php isset($_GET['sbscrbdID']) ? null : redirect_to("index.php"); ?>
<?php  
	isset($_GET['sbscrbdID']) ? null : redirect_to("index.php");
	$subsPlan = SubsPlan::find_by_id($_GET['sbscrbdID']);
	$subsPlan ? null : redirect_to("index.php");
	$plan = Plan::find_by_id($subsPlan->plan_id);

	//Restriction in URL redirect user if this isn't his subscription
	$user_subscriptions = SubsPlan::get_owner_subscriptions($user->id);
	$subscriptionIDs = array_map(function($obj) { return $obj->id;}, $user_subscriptions);
	in_array($_GET['sbscrbdID'], $subscriptionIDs) ? null : redirect_to("index.php");

	$condition['key'] = "subs_plan_id";
	$condition['value'] = $subsPlan->id;
	$condition['isNumeric'] = true;

	$all_user_establishment = [];
	$subsPlanEstab = SubsPlanEstab::find_all($condition);

	// foreach ($subsPlanEstab as $key => $eachPlanEstab) {
	// 	$all_user_establishment[] = Establishment::find_by_id($eachPlanEstab->estab_id);
	// }
	
	$all_user_establishment = array_map(function($obj) { return Establishment::find_by_id($obj->estab_id); }, $subsPlanEstab);
	
	//BECAREFUL USING FIND ALL WITH PARAMETERS - ARGUMENTS ARE NOT ESCAPED
	//$all_user_establishment = Establishment::find_all($condition);
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php include '../includes/styles.php'; ?>
		<link rel="stylesheet" type="text/css" href="js/jquery-ui.css"/>
	</head>
	<body>
	<header>
		<div class="center">			
			<?php include("../includes/navigation.php"); ?>
		</div>
	</header>
	<div class="banner"></div>
	<div class="container center">	

		<div class="panel panel-default drop-shadow">
			<div class="panel-heading"><h1 class="heading-label"><span class="glyphicon glyphicon-glass"></span> Manage Establishments</h1></div>
			<div class="panel-body">
			</div>

			<table class="table table-hover data">
				<tr>
					<th style="width: 100px;">NAME</th>
					<th style="width: 600px;">DESCRIPTION</th>
					<th colspan="2">OPTION</th>
				</tr>
			<?php 
			foreach($subsPlanEstab as $key => $eachSubsPlanEstab): ?>
			<?php $eachEstab = Establishment::find_by_id($eachSubsPlanEstab->estab_id); ?>
				<tr>
					<td style="font-weight: bolder;"><?php echo htmlentities($eachEstab->name); ?></td>
					<td><?php echo cym_decode_unicode($eachEstab->description); ?></td>
					<td>
						<form action="deleteEstablishment.php?id=<?php echo urlencode($eachSubsPlanEstab->id); ?>" method="POST">
							<a href="manageBranch.php?id=<?php echo urlencode($eachSubsPlanEstab->id); ?>"><span class="glyphicon glyphicon-cog"></span> Manage Branches</a><br>
							<a href="editEstabDetails.php?id=<?php echo urlencode($eachSubsPlanEstab->id); ?>">
							<span class="glyphicon glyphicon-pencil"></span> Edit Establishment Details</a>
							<input type="hidden" name="deleteEstab" value="true"/>
					</td>
					<td>
							<input class="btn btn-danger deleteEstabBtn" type="button" value="Delete Establishment" data-internalId="<?php echo $key; ?>"/>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="100%" class="text-center">
				<?php if (count($all_user_establishment) < $plan->estab_no) {  ?>
				<a href="addEstab.php?id=<?php echo urlencode($_GET['sbscrbdID']); ?>"><h5><span class="glyphicon glyphicon-plus"></span> Add Establishment</h5></a>
				<?php } else { ?>
				<p>YOU HAVE REACHED MAXIMUM NUMBER OF ESTABLISHMENT FOR THIS SUBSCRIPTION</p>
				<?php } ?></td>
			</tr>
			</table>
		</div>	
		</div>	

		<?php include '../includes/footer.php'; ?>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/functions.js"></script>
		<script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
		<script type="text/javascript">

			$(document).on('click', '.deleteEstabBtn', function() {
				console.log("delete clicked");
				console.log($(this).attr("data-internalId"));
				var index = $(this).attr("data-internalId");
				var action_performed = function() {
					$('#dialog').dialog('close');
					console.log(index);
					$("form")[index].submit();
					//document.getElementById("myForm").submit();
				};

				confirm_action("Are you sure you want to delete this establishment?", action_performed);
			});
		</script>		
	</div>
	</body>
</html>