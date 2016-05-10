<?php require_once("../../includes/initialize.php"); ?>
<?php  	
	$output = "{";
	//For category management
	if (isset($_GET['createCateg'])) {
		$new_category = new EstabCategory();
		$new_category->name = trim($_GET['categName']);
		$new_category->description = trim($_GET['categDescription']);
		$new_category->create();
		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr);

	} else if (isset($_GET['getCategories'])) {
		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr);
	} else if (isset($_GET['deleteCateg'])) {
		EstabCategory::delete_by_id($_GET['categoryID']);
		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr);		
	} else if (isset($_GET['editCateg'])) {
		$selected_category = EstabCategory::find_by_id($_GET['categoryID']);
		$output .= '"categorySelected":"true",';
		$output .= '"name":"' . $selected_category->name . '",';
		$output .= '"description":"' . $selected_category->description . '"';
	} else if (isset($_GET['saveChanges'])) {
		$selected_category = EstabCategory::find_by_id($_GET['categoryID']);
		$selected_category->name = trim($_GET['categName']);
		$selected_category->description = trim($_GET['categDescription']);
		$selected_category->update();

		$objArr = EstabCategory::find_all();
		$output .= createJSONEntity("Categories", $objArr);
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
	} else if (isset($_GET['saveChangesPD'])) {
		$selected_planDuration = PlanDuration::find_by_id($_GET['planDurationID']);
		$selected_planDuration->description = trim($_GET['description']);
		$selected_planDuration->duration_name = trim($_GET['duration_name']);
		$selected_planDuration->duration_visibility = trim($_GET['duration_visibility']);
		$selected_planDuration->update();

		$objArr = PlanDuration::find_all();
		$output .= createJSONEntity("PlanDurations", $objArr);		
	} else if (isset($_GET['getPlans'])) { //For plan management
		$objArr = Plan::find_all();
		$output .= createJSONEntity("Plans", $objArr);
	} else if (isset($_GET['createPlan'])) {
		$new_plan = new Plan();
		$new_plan->plan_name = trim($_GET['plan_name']);
		$new_plan->plan_interval = trim($_GET['durationID']);
		$new_plan->estab_no = trim($_GET['estab_no']);
		$new_plan->branch_no = trim($_GET['branch_no']);
		$new_plan->cost = trim($_GET['cost']);
		$new_plan->visibility = trim($_GET['visibility']);
		$new_plan->create();

		\Stripe\Stripe::setApiKey("sk_test_5lqGe81cTwC39ryIuby7KNu2");

		$duration = PlanDuration::find_by_id($new_plan->plan_interval);
		\Stripe\Plan::create(array(
		  "amount" => (int)number_format($new_plan->cost, 2, '', ''), //
		  "interval" => $duration->duration_name,
		  "name" => $new_plan->plan_name,
		  "currency" => "usd",
		  "id" => $new_plan->id)
		);	

		$objArr = Plan::find_all();
		$output .= createJSONEntity("Plans", $objArr);		
	} else if (isset($_GET['deletePlan'])) {
		Plan::delete_by_id($_GET['planID']);
		$objArr = Plan::find_all();
		$output .= createJSONEntity("Plans", $objArr);		
	} else if (isset($_GET['editPlan'])) {
		$selected_plan = Plan::find_by_id($_GET['planID']);
		$output .= '"planSelected":"true",';
		$output .= '"plan_interval":"' . $selected_plan->plan_interval . '",';
		$output .= '"estab_no":"' . $selected_plan->estab_no . '",';
		$output .= '"branch_no":"' . $selected_plan->branch_no . '",';
		$output .= '"cost":"' . $selected_plan->cost . '",';
		$output .= '"visibility":"' . $selected_plan->visibility . '",';		
		$output .= '"plan_name":"' . $selected_plan->plan_name . '"';			
	} else if (isset($_GET['saveChangesPL'])) {
		$selected_plan = Plan::find_by_id($_GET['planID']);
		$selected_plan->plan_name = trim($_GET['plan_name']);
		$selected_plan->plan_interval = trim($_GET['durationID']);
		$selected_plan->estab_no = trim($_GET['estab_no']);
		$selected_plan->branch_no = trim($_GET['branch_no']);
		$selected_plan->cost = trim($_GET['cost']);
		$selected_plan->visibility = trim($_GET['visibility']);
		$selected_plan->update();

		\Stripe\Stripe::setApiKey("sk_test_5lqGe81cTwC39ryIuby7KNu2");

		$duration = PlanDuration::find_by_id($selected_plan->plan_interval);
		$p = \Stripe\Plan::retrieve($selected_plan->id);
		$p->name = $selected_plan->plan_name;
		$p->save();

		$objArr = Plan::find_all();
		$output .= createJSONEntity("Plans", $objArr);		
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