<?php require_once("PHPMailer/class.phpmailer.php"); ?>
<?php require_once("PHPMailer/class.smtp.php"); ?>
<?php require_once("PHPMailer/language/phpmailer.lang-en.php"); ?>


<?php  
 	class Mailer {
 		public $to_name;
 		public $to_email;
 		public $subj = "Coin One Forgot Password";
 		public $message;
 		public $from_name = "Coin One";
 		public $from_email = "coinone777@gmail.com";

 		public static function send_reset_code($userObj) {

 			$email = new self();
 			$email->to_name = $userObj->full_name();
 			$email->to_email = $userObj->email;
 			$message = "Thank you for trusting us.\n";
 			$message .= "Your Reset Code: " . $userObj->reset_code . "\n";
 			$message .= "Have a nice day ahead!";

 			$email->message = $message;
 			$email->message = wordwrap($email->message, 70);

 			$mail = $email->create_mail();
 			$result = $mail->Send();
 			return $result ? 'Sent' : 'Error'; 
 		} 
 		
 		public static function send_verification_code($userObj) {	
 			$email = new self();
 			$email->to_name = $userObj->full_name();
 			$email->to_email = $userObj->email;
 			$email->subj = "Verify your account.";
 			
 			$message = "Welcome to Coin One. Your first step is to verify your email. Click on the link below \n";
 			$message .= "http://www.codeyasam.com/capstone/Public/verifyuser.php?code=" . $userObj->verification_key;
 			$message .= " Have a nice day!";
 			
  			$email->message = $message;
 			$email->message = wordwrap($email->message, 70);			
 			
 			$mail = $email->create_mail();
 			$result = $mail->Send();
 			return $result ? 'Sent' : 'Error'; 		
 		} 

 		public function create_mail() {
 			$mail = new PHPMailer();

 			$mail->IsSMTP();
 			$mail->Host = 'smtp.gmail.com';
 			$mail->Port = 465;
 			$mail->SMTPAuth = true;
 			$mail->SMTPSecure = 'ssl';
 			$mail->Username = "coinone777@gmail.com";
 			$mail->Password = "cosecret123";

 			$mail->FromName = $this->from_name;
 			$mail->From = $this->from_email;
 			$mail->AddAddress($this->to_email, $this->to_name);
 			$mail->Subject = $this->subj;
 			$mail->Body = $this->message;
 			return $mail;
 		}
 		
 		
 	}
?>