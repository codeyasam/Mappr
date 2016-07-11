<a href="."><img src="images/logo.png"></a>	
<nav class="right">
	<ul>
		<?php if (empty($user)) { ?>
			<li><a href="login.php">Login</a></li>
			<li><a href="registeruser.php">Register</a></li>
			<li><a href="subscription.php">Subscription</a></li>
		<?php } else { ?>
			<li><a href="paymentSummary.php">View Transactions</a></li>
			<li><a href="mysubscription.php">My Subscriptions</a></li>
			<li><a href="subscription.php">Subscription</a></li>
			<li><a href="logout.php">Logout</a></li>
		<?php } ?>
	</ul>
</nav>