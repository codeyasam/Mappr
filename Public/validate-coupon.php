<?php
  require_once("../includes/initialize.php");
  $answer = true;
  $coupon_id  = trim($_GET['coupon_id']);
  // needs if coupon_id is not blank  
  try {
    $coupon = \Stripe\Coupon::retrieve($coupon_id);  
  } catch (\Stripe\Error\InvalidRequest $e) {
	  // $answer is already set to false
    $answer = false;
  } catch (InvalidArgumentException $e) {
    $answer = false;
  } 

  if ($answer === true) {
    if ($coupon->valid) {
      if (!empty($coupon->percent_off)) {
        echo $coupon->percent_off . " %";
      } else {
        echo $coupon->amount_off / 100 . " " . $coupon->currency;        
      }
    } else {
      echo false;      
    }    
    //echo $coupon->valid === true ? $coupon : false;
  } else echo false;

  //echo $answer === false ? $answer : $coupon;  // this sends false or coupon object
  //echo $answer;  //this sends 0 or 1
  
  //TODO:  Rework to use Stripe's status codes https://stripe.com/docs/api/php#errors
  // 200 means the coupon is valid
  // 400 means the coupon code was missing
  // 402 means it was a good coupon code, but it's expired or otherwise can't be used
  // 404 means the coupon code does not exist
?>