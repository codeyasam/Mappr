<?php require_once("../../includes/initialize.php"); ?>
<?php $session->is_logged_in() ? null : redirect_to("../index.php"); ?>
<?php  
	$user = User::find_by_id($session->user_id);
	$user->user_type != "SUPERADMIN" && $user->user_type != "ADMIN" ? redirect_to("../index.php") : null;	
?>
<?php  	
	$output = "{";
	//For category management
	if (isset($_POST['createCateg'])) {
		$new_category = new EstabCategory();
		$new_category->name = trim($_POST['categName']);
		$new_category->description = trim($_POST['categDescription']);
		$new_category->featured_category = trim($_POST['featured_category']);
		if ($_POST['categParentId'] != "-1") {
			$new_category->parent_category_id = trim($_POST['categParentId']);
		}
		$new_category->create();

		if (isset($_FILES['categIcon'])) {
			move_uploaded_file($_FILES['categIcon']['tmp_name'], "../DISPLAY_PICTURES/categ_display_pic".$new_category->id);
			$new_category->display_picture = "DISPLAY_PICTURES/categ_display_pic".$new_category->id;
			$new_category->update();
		}

		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr, true);
		$output .= ', "createdCateg":"true"';

		MapprActLog::recordActivityLog("Created " . $new_category->name . " category", $user->id);

	} else if (isset($_GET['getCategories'])) {
		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr, true);
	} else if (isset($_POST['deleteCateg'])) {
		$category_to_delete = EstabCategory::find_by_id($_POST['categoryID']);
		$has_affected_rows = EstabCategory::delete_by_id($_POST['categoryID']);
		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr, true);
		
		if ($has_affected_rows) {
			$output .= ', "deletedCateg":"true"';	
			MapprActLog::recordActivityLog("Deleted '" . $category_to_delete->name . "' category", $user->id);
		} else {
			$output .= ', "deletedCateg":"false"';
		}
				

	} else if (isset($_GET['editCateg'])) {
		$selected_category = EstabCategory::find_by_id($_GET['categoryID']);
		$output .= '"categorySelected":"true",';
		$output .= '"name":"' . $selected_category->name . '",';
		$output .= '"description":"' . $selected_category->description . '",';
		$output .= '"featured_category":"' . $selected_category->featured_category . '",';
		$output .= '"display_picture":"' . $selected_category->display_picture . '", ';
		if (empty($selected_category->parent_category_id)) {
			$output .= '"parent_category_id":"-1"'; 		
		} else {
			$output .= '"parent_category_id":"' . $selected_category->parent_category_id . '"'; 
		}
	} else if (isset($_POST['saveChanges'])) {
		$selected_category = EstabCategory::find_by_id($_POST['categoryID']);
		$selected_category->name = trim($_POST['categName']);
		$selected_category->description = trim($_POST['categDescription']);
		$selected_category->featured_category = trim($_POST['featured_category']);
		if (isset($_FILES['categIcon'])) {
			move_uploaded_file($_FILES['categIcon']['tmp_name'], "../DISPLAY_PICTURES/categ_display_pic".$selected_category->id);
			$selected_category->display_picture = "DISPLAY_PICTURES/categ_display_pic".$selected_category->id;
		}

		if ($_POST['categParentId'] != "-1") {
			$selected_category->parent_category_id = trim($_POST['categParentId']);
		} else {
			$selected_category->parent_category_id = "";
		}				

		$selected_category->update();

		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr, true);
		$output .= ', "updatedCateg":"true"';

		MapprActLog::recordActivityLog("Updated " . $selected_category->name . " category", $user->id);

	} else if (isset($_GET['getPlanDurations'])) { //For plan duration management
		$objArr = PlanDuration::find_all();
		$output .= createJSONEntity("PlanDurations", $objArr);
	} else if (isset($_GET['createPlanDuration'])) {
		$new_planDuration = new PlanDuration();
		$new_planDuration->description = trim($_GET['description']);
		$new_planDuration->duration_name = trim($_GET['duration_name']);
		$new_planDuration->duration_visibility = trim($_GET['duration_visibility']);
		$new_planDuration->create();

		$objArr = PlanDuration::find_all();
		$output .= createJSONEntity("PlanDurations", $objArr);		
	} else if (isset($_GET['deletePlanDuration'])) {
		PlanDuration::delete_by_id($_GET['planDurationID']);
		$objArr = PlanDuration::find_all();
		$output .= createJSONEntity("PlanDurations", $objArr);		
	} else if (isset($_GET['editPlanDuration'])) {
		$selected_planDuration = PlanDuration::find_by_id($_GET['planDurationID']);
		$output .= '"planDurationSelected":"true",';
		$output .= '"description":"' . $selected_planDuration->description . '",';
		$output .= '"duration_name":"' . $selected_planDuration->duration_name . '",';
		$output .= '"duration_visibility":"' . $selected_planDuration->duration_visibility . '"';	
	} else if (isset($_POST['saveChangesPD'])) {
		$selected_planDuration = PlanDuration::find_by_id($_POST['planDurationID']);
		$selected_planDuration->description = trim($_POST['description']);
		$selected_planDuration->duration_name = trim($_POST['duration_name']);
		$selected_planDuration->duration_visibility = trim($_POST['duration_visibility']);
		$selected_planDuration->update();

		$objArr = PlanDuration::find_all();
		$output .= createJSONEntity("PlanDurations", $objArr);		
		$output .= ', "saveChangesPD":"true"';

		MapprActLog::recordActivityLog("Updated '" . $selected_planDuration->duration_name . "' duration", $user->id);

	} else if (isset($_GET['getPlans'])) { //For plan management
		$objArr = Plan::find_all();
		$output .= createJSONEntity("Plans", $objArr);
	} else if (isset($_POST['createPlan'])) {
		$new_plan = new Plan();
		$new_plan->plan_name = trim($_POST['plan_name']);
		$new_plan->plan_interval = trim($_POST['durationID']);
		$new_plan->estab_no = trim($_POST['estab_no']);
		$new_plan->branch_no = trim($_POST['branch_no']);
		$new_plan->cost = (int)trim($_POST['cost']);
		$new_plan->visibility = trim($_POST['visibility']);
		//$new_plan->create();

		//\Stripe\Stripe::setApiKey("sk_test_5lqGe81cTwC39ryIuby7KNu2");
		$duration = PlanDuration::find_by_id($new_plan->plan_interval);
		$interval = !empty($_POST['interval']) ? $_POST['interval'] : $duration->duration_name; 
		$interval_count = $_POST['interval_count'] == "" || 
						  $_POST['interval_count'] < 1 ? 1 : $_POST['interval_count'];

		if ($duration->duration_name == "other") {
			$new_plan->custom_interval = $interval;
			$new_plan->interval_count = $interval_count;			
		}

		try {
			$new_plan->create();
			\Stripe\Plan::create(array(
			  "amount" => (int)number_format($new_plan->cost, 2, '.', ''), //
			  "interval" => $interval,
			  "interval_count" => $interval_count,
			  "name" => $new_plan->plan_name,
			  "currency" => "jpy",
			  "id" => $new_plan->id)
			);	
			$objArr = Plan::find_all();
			$output .= createJSONEntity("Plans", $objArr);	
			$output .= ', "createdPlan":"true"';

			MapprActLog::recordActivityLog("Created '" . $new_plan->plan_name . "' plan", $user->id);
		} catch (Exception $e) {
			Plan::delete_by_id($new_plan->id);
			$output .= '"createError":"true"';
			//die($e);
		}

		

	} else if (isset($_POST['deletePlan'])) {
		try {
			$plan_to_delete = Plan::find_by_id($_POST['planID']);
			$has_affected_rows = Plan::delete_by_id($_POST['planID']);
			$objArr = Plan::find_all();
			// $output .= $has_affected_rows ? createJSONEntity("Plans", $objArr) : '"hasPlanDeleteError":"true"';	

			if ($has_affected_rows) {
				$output .= createJSONEntity("Plans", $objArr);
				$output .= ', "hasPlanDeleteError":"false"';
				$plan = \Stripe\Plan::retrieve($_POST['planID']);
				$plan->delete();			
			} else {
				$output .= '"hasPlanDeleteError":"true"';
			}			

			MapprActLog::recordActivityLog("Deleted '" . $plan_to_delete->plan_name . "' plan", $user->id);

		} catch (Exception $e) {
			
		}
	
	} else if (isset($_GET['editPlan'])) {
		$selected_plan = Plan::find_by_id($_GET['planID']);
		$output .= '"planSelected":"true",';
		$output .= '"plan_interval":"' . $selected_plan->plan_interval . '",';
		$output .= '"estab_no":"' . $selected_plan->estab_no . '",';
		$output .= '"branch_no":"' . $selected_plan->branch_no . '",';
		$output .= '"cost":"' . $selected_plan->cost . '",';
		$output .= '"visibility":"' . $selected_plan->visibility . '",';		
		$output .= '"plan_name":"' . $selected_plan->plan_name . '"';

		$customDurationObj = PlanDuration::find_by_duration_name($selected_plan->custom_interval);
		
		if ($customDurationObj) {
			$output .= ',"custom_interval":"' . $customDurationObj->id . '"';
			$output .= ',"interval_count":"' . $selected_plan->interval_count . '"';
		}
		
	} else if (isset($_POST['saveChangesPL'])) {
		$selected_plan = Plan::find_by_id($_POST['planID']);
		$selected_plan->plan_name = trim($_POST['plan_name']);
		$selected_plan->plan_interval = trim($_POST['durationID']);
		$selected_plan->estab_no = trim($_POST['estab_no']);
		$selected_plan->branch_no = trim($_POST['branch_no']);
		$selected_plan->cost = trim($_POST['cost']);
		$selected_plan->visibility = trim($_POST['visibility']);
		$selected_plan->update();

		//\Stripe\Stripe::setApiKey("sk_test_5lqGe81cTwC39ryIuby7KNu2");

		$duration = PlanDuration::find_by_id($selected_plan->plan_interval);
		$p = \Stripe\Plan::retrieve($selected_plan->id);
		$p->name = $selected_plan->plan_name;
		$p->save();

		$objArr = Plan::find_all();
		$output .= createJSONEntity("Plans", $objArr);	
		$output .= ', "planUpdated":"true"';	

		MapprActLog::recordActivityLog("Updated '" . $selected_plan->plan_name . "' plan", $user->id);

	}

	$output .= "}";
	echo $output;

	function BACKUPcreateJSONEntity($holder, $objArr) {
		$otString = '"' . $holder . '":[';
		$otArray = array(); 
		
		foreach ($objArr as $key => $eachObj) {
			$fValueArr = array();
			foreach ($eachObj->getFields() as $key => $eachField) {
				$fValueArr[] = '"' . $eachField . '":"' . $eachObj->$eachField . '"';
			}
			$otArray[] = join(",",$fValueArr);
		}
		$otString .= "{" . join("},{", $otArray) . "}";
		$otString .= "]";
		// echo "<pre>";
		// 	print_r($otArray);
		// echo "</pre>";
		return $otString;
	}

	// moved to functions.php
	// function createJSONEntity($holder, $objArr) {
	// 	$otString = '"' . $holder . '":[';
	// 	$otArray = array();

	// 	foreach ($objArr as $key => $eachObj) {
	// 		$otArray[] = $eachObj->toJSON();
	// 	}

	// 	$otString .= "{" . join("},{", $otArray) . "}";
	// 	$otString .= "]";

	// 	return $otString;
	// }

	// $objArr = EstabCategory::find_all();
	// createJSONEntity("Categories", $objArr);
?>