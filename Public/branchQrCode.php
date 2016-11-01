<?php 
	session_start(); 
	require_once("../includes/phpqrcode/qrlib.php");	
	QRcode::png($_SESSION['branchID']);
	QRcode::png($_SESSION['branchID'], "DYNAMICQRCODES/branchCode" . $_SESSION['branchID'] . ".png");
	//rename("branchCode.png", "DYNAMICQRCODES/branchCode.png");
	//QRcode::png(1);
?>