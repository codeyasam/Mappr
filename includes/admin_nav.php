<a href="."><img src="../images/logo.png"></a>	
<nav class="right">
	<ul>
		<li><a href="managePlanduration.php">Manage Plan Duration</a></li>
		<li><a href="managePlan.php">Manage Plans</a></li>
		<li><a href="manageCategory.php">Manage Establishment Category</a></li>
		<li><a href="../logout.php">logout</a></li>
	</ul>
</nav>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">
        <img style="display: inline;" src="../images/logo_2.png" alt="brand">
		<!-- <span class="glyphicon glyphicon glyphicon-map-marker"></span> -->
		Coin One</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
		<?php if (empty($user)) { ?>
			<li><a href="login.php">Login</a></li>
			<li><a href="registeruser.php">Register</a></li>
		<?php } else { ?>
			<li class="dropdown">
	         	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Control Panel <span class="caret"></span></a>
           		<ul class="dropdown-menu">					
					<li><a href="managePlanduration.php">Manage Plan Duration</a></li>
					<li><a href="managePlan.php">Manage Plans</a></li>
					<li><a href="manageCategory.php">Manage Establishment Category</a></li>
           		</ul>
          	</li>
			<li class="dropdown">
	         	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
           		<ul class="dropdown-menu">					
					<li><a href="../accountsettings.php">Edit Profile</a></li>
					<li><a href="../mysubscription.php">My Subscriptions</a></li>
					<li><a href="../paymentSummary.php">View Transactions</a></li>
        			<li role="separator" class="divider"></li>
					<li><a href="../logout.php">Logout</a></li>
           		</ul>
          	</li>
		<?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>