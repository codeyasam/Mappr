<?php  
    require_once("includes/initialize.php");
	// //anonymous function php
	// // $get_addresses = function($obj) {
	// // 	return $obj->address;
	// // };
	
	// // // $arrObj = EstabBranch::find_all();
	// // // $myArr = array_map(function($obj) {return $obj->address;}, $arrObj);
	// // // print_r($myArr);
	// // // echo join("<>", $myArr);

	// // function testlang() {
	// // 	$arrObj = EstabBranch::find_all();
	// // 	$myArr = array_map(function($obj) {return $obj->address;}, $arrObj);
	// // 	print_r($myArr);
	// // 	echo join("<>", $myArr);		
	// // }

	// // testlang();

	// //echo SubsPlanEstab::get_total_branch_plotted(3);
	// $objArr = EstabBranch::find_all();
	// // echo "<pre>";
	// // 	print_r(createJSONEntity("Branches", $objArr));
	// // echo "</pre>";
	// echo "{" . createJSONEntity("Branches", $objArr) . "}";
	// $subject = "<h2>yeah</h2>";
	// $result = preg_replace('%([+\"\'<>/]+)%', '\\\\$1', $subject);
	// echo $result;
    //var_dump(User::check_username_format("asfasチトシハ"));
    var_dump(User::check_existing("codeyasam", "username", "has existing username"));
    var_dump(User::check_existing("codeyasam", "email", "has existing username")); 
    var_dump($errors);   
?>
