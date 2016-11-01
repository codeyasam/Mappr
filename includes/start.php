<?php  
	require 'vendor/autoload.php';

	$paypal = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
			'AThazSMlHHatISP-h6mXIUPcAotbwnc5mbDzuMUyt-cvxHiEhUZeH1AECkBpmUUWnnwVFZ7_rKDohg9S',
			'EFZi2sD2CwSvTyBMYQkW99QcH_aKCCLzHlOZ4sWbtUvXSxihEwyhY8YLZAzyJ555L_kV4LgU1XePJBCn'
		)
	);
?>