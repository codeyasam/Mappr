<nav>
	<ul>
		<?php if (empty($user)) { ?>
			<li><a href="login.php">Login</a></li>
			<li><a href="registeruser.php">Register</a></li>
		<?php } else { ?>
			<li><a href="logout.php">Logout</a></li>
			<li><a href="paymentSummary.php">Transactions</a></li>
			<li><a href="mysubscription.php">My Subscriptions</a></li>
		<?php } ?>
		<li><a href="subscription.php">Subscription</a></li>
	</ul>
</nav>