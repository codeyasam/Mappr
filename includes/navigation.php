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
      <a class="navbar-brand" href="<?php echo MAPPR_PUBLIC_URL; ?>index.php">
        <img style="display: inline;" src="<?php echo MAPPR_PUBLIC_URL; ?>images/logo_2.png" alt="brand">
		<!-- <span class="glyphicon glyphicon glyphicon-map-marker"></span> -->
		Coin One</a>
    </div>
   
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <!-- <?php if (!empty($user) && strtolower($user->user_type) == "admin") { ?>
          <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>index.php"><span class="glyphicon glyphicon-home"></span> Homepage</a></li>
        <?php } ?> -->
        <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>subscription.php"><span class="glyphicon glyphicon-shopping-cart"></span> Purchase Subscriptions</a></li>
          <?php if (empty($user)) { ?>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li><a href="registeruser.php"><span class="glyphicon glyphicon-tag"></span> Register</a></li>
          <?php } else { ?>

            <?php if(strtolower($user->user_type) == "admin" || strtolower($user->user_type) == "superadmin") { ?>
            <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> Control Panel <span class="caret"></span></a>
                    <ul class="dropdown-menu">   
                      <?php if(strtolower($user->user_type) == "superadmin") { ?>
                      <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>Admin/manageAdmins.php"><span class="glyphicon glyphicon-cog"></span> Super Admin Panel</a></li>
                      <?php } ?>
                      <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>Admin/manageCategory.php"><span class="glyphicon glyphicon-cutlery"></span> Manage Establishment Category</a></li>
                      <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>Admin/managePlan.php"><span class="glyphicon glyphicon-list-alt"></span> Manage Plans</a></li>
                      <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>Admin/managePlanduration.php"><span class="glyphicon glyphicon-hourglass"></span> Manage Plan Duration</a></li>
                    </ul>
                  </li>
            <?php } else { ?>

            <?php } ?>

            <li class="dropdown">
              
              <a style="display: inline-block;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> My Account <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">          
                <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>mysubscription.php"><span class="glyphicon glyphicon-tags"></span> My Subscriptions</a></li>
                <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>paymentSummary.php"><span class="glyphicon glyphicon-check"></span> View Transactions</a></li>

                <li role="separator" class="divider"></li>
                
                <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>accountsettings.php"><span class="glyphicon glyphicon-pencil"></span> Edit Profile</a></li>
                <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>activitylogSummary.php"><span class="glyphicon glyphicon-list"></span> Activity Log</a></li>
                <li><a href="<?php echo MAPPR_PUBLIC_URL; ?>logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
              </ul>
            </li>    
          <?php } ?>
          <li><a href="help.php"><span class="glyphicon glyphicon-question-sign"></span> Help</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->

    <!-- Collect the nav links, forms, and other content for toggling -->
  </div><!-- /.container-fluid -->
</nav>
