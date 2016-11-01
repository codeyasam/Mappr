<?php require_once("includes/phpqrcode/qrlib.php"); ?>
<?php  

	QRcode::png('Advanced happy 222222 <3', 'another.png'); // creates file
	//QRcode::png('some othertext 1234'); // creates code image and outputs it directly into browser
?>