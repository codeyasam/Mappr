<?php  
	use \PayPal\Api\Payer;
	use \PayPal\Api\Item;
	use \PayPal\Api\ItemList;
	use \PayPal\Api\Details;
	use \PayPal\Api\Amount;
	use \PayPal\Api\Transaction;
	use \PayPal\Api\RedirectUrls;
	use \PayPal\Api\Payment;
	use \PayPal\Exception\PayPalConnectionException;
	use \PayPal\Api\PaymentExecution;

	require('start.php');
	
?>

<?php  
	
	class PaypalMappr {

		private $payer;
		private $itemList;
		private $details;
		private $amount;
		private $transaction;
		private $redirectUrls;	
		private $payment;

		public $eachOrder;
		public $items;
		public $itemQuantity;

		public function __construct() {
			$this->payer = new Payer();
			$this->itemList = new ItemList();
			$this->details = new Details();
			$this->amount = new Amount();
			$this->transaction = new Transaction();
			$this->redirectUrls = new RedirectUrls();
			$this->payment = new Payment();

			$this->eachOrder = array();
			$this->items = array();
		}	

		public function makePayment($planID, $user_id) {
			global $paypal;

			$this->payer->setPaymentMethod("paypal");
			$allItemsCost = $this->paypalSetItem();
			$this->itemList->setItems($this->items);

			$this->amount->setTotal($allItemsCost) 
				->setCurrency("PHP");	

			$this->transaction->setAmount($this->amount)
				->setItemList($this->itemList)
				->setDescription('Clothes Shop Checkout')
				->setInvoiceNumber(uniqid());

			$this->redirectUrls->setReturnUrl("http://localhost/thesis/Public/pay.php?success=true&planID={$planID}&userID={$user_id}")
				->setCancelUrl("http://localhost/thesis/Public/index.php");	

			$this->payment->setIntent('sale')
				->setPayer($this->payer)
				->setRedirectUrls($this->redirectUrls)
				->setTransactions([$this->transaction]);			

			try {
				$this->payment->create($paypal);
			} catch (PayPalConnectionException $e) {
				echo $e->getData();
				echo "<pre>";
					print_r($this->amount);
					print_r($this->transaction);
				echo "</pre>";

				die($e);
			}

		    echo $approvalURL = $this->payment->getApprovalLink();		
			redirect_to($approvalURL);									
		}						

		public function addItem($orderDetailObject) {
			$this->eachOrder[] = $orderDetailObject;
		}

		// public function paypalSetItem($planObj) {
		// 	$item = new Item();
		// 	$item->setName($planObj->toString())
		// 		->setCurrency('PHP')
		// 		->setQuantity(1)
		// 		->setPrice($planObj->cost);

		// 	$this->items[] = $item;
		// 	return $planObj->cost;

		// }

		public function paypalSetItem() {

			$total = 0;
			foreach ($this->eachOrder as $key => $details) {

				$item = new Item();
				$item->setName($details->toString())
					->setCurrency('PHP')
					->setQuantity(1)
					->setPrice($details->cost);

				$this->items[] = $item;
				$total += $details->cost;
			}

			return $total;
		}

		public static function reviewPayment($planID="", $user_id="") {
			global $paypal;
			
			if (!isset($_GET['success'], $_GET['paymentId'], 
				$_GET['PayerID'])) {
				//redirect 
				redirect_to('subscriptionplans.php');
			}	
			
			if ((bool)$_GET['success'] === false) {
				$_SESSION["PAYMENT_CONFIRMATION_OK"] = "false";
				//redirect
				redirect_to('checkoutDetails.php');
			}	

			$paymentId = $_GET['paymentId'];
			$payerID = $_GET['PayerID'];

			$payment = Payment::get($paymentId, $paypal);

			$execute = new PaymentExecution();
			$execute->setPayerId($payerID);

			try {
				$result = $payment->execute($execute, $paypal);
			} catch (Exception $e) {
				die($e);
			}

			//if no errors then register the transaction
			$planObj = Plan::find_by_id($planID);
			$durationObj = PlanDuration::find_by_id($planObj->duration_id);

			$subs_plan = new SubsPlan();
			$subs_plan->owner_id = $user_id;
			$subs_plan->plan_id = $planID;
			$subs_plan->date_start = get_mysql_datetime(time());
			$subs_plan->date_end = get_mysql_datetime(time() + ($durationObj->days_no * 24 * 60 * 60));
			$subs_plan->create();

			echo "Payment made. Thanks!";
			$_SESSION["PAYMENT_CONFIRMATION_OK"] = "true";
			//redirect to somewhere	to post the message	
			redirect_to('paymentSummary.php');								
		}
	}
?>