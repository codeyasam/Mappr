<?php  
	require_once("includes/initialize.php");
	//anonymous function php
	// $get_addresses = function($obj) {
	// 	return $obj->address;
	// };
	
	// // $arrObj = EstabBranch::find_all();
	// // $myArr = array_map(function($obj) {return $obj->address;}, $arrObj);
	// // print_r($myArr);
	// // echo join("<>", $myArr);

	// function testlang() {
	// 	$arrObj = EstabBranch::find_all();
	// 	$myArr = array_map(function($obj) {return $obj->address;}, $arrObj);
	// 	print_r($myArr);
	// 	echo join("<>", $myArr);		
	// }

	// testlang();

	echo SubsPlanEstab::get_total_branch_plotted(3);	
?>