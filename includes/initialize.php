<?php ob_start(); ?>
<?php 
	//absolute path definition
	defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

	defined("SITE_ROOT") ? null : define("SITE_ROOT", DS. "var" . DS . "www" . DS . "html" . DS . "capstone");
	//defined("SITE_ROOT") ? null : define("SITE_ROOT", DS. "var" . DS . "www" . DS . "html" . DS . "thesis");
	//defined("SITE_ROOT") ? null : define("SITE_ROOT", "D:" . DS. "SITE" . DS . "thesis");
// =======
 	//defined("SITE_ROOT") ? null : define("SITE_ROOT", DS. "home1" . DS . "chulien" . DS . "codeyasam.com" . DS . "capstone");
// >>>>>>> 9cd94834053e91bc505db5099ec1d99381d876f2

	defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT . DS . "includes");

	defined("TEMPORARY_ROOT_HOSTNAME") ? null : define("TEMPORARY_ROOT_HOSTNAME", "http://localhost/capstone/");
	
    //    defined("TEMPORARY_ROOT_HOSTNAME") ? null : define("TEMPORARY_ROOT_HOSTNAME", "http://www.codeyasam.com/capstone/");

	defined("MAPPR_PUBLIC_URL") ? null : define("MAPPR_PUBLIC_URL", TEMPORARY_ROOT_HOSTNAME . "Public/");

	require_once(LIB_PATH . DS . "db_config.php");
	require_once(LIB_PATH . DS . "functions.php");

	//load Core Objects
	require_once(LIB_PATH . DS . "database.php");
	require_once(LIB_PATH . DS . "session.php");
	require_once(LIB_PATH . DS . "databaseObject.php");

	//load database-realted classes
	require_once(LIB_PATH . DS . "user.php");
	require_once(LIB_PATH . DS . "estabcateg.php");
	require_once(LIB_PATH . DS . "estab.php");
	require_once(LIB_PATH . DS . "branches.php");
	require_once(LIB_PATH . DS . "plans.php");
	require_once(LIB_PATH . DS . "subsplan.php");
	require_once(LIB_PATH . DS . "transac.php");
	require_once(LIB_PATH . DS . "review.php");
	require_once(LIB_PATH . DS . "gallery.php");
	require_once(LIB_PATH . DS . "planDuration.php");
	require_once(LIB_PATH . DS . "paypalmappr.php");
	require_once(LIB_PATH . DS . "subsplanestab.php");
	require_once(LIB_PATH . DS . "branchGallery.php");
	require_once(LIB_PATH . DS . "bookmark.php");
	require_once(LIB_PATH . DS . "businesshours.php");
	require_once(LIB_PATH . DS . "activitylog.php");
	require_once(LIB_PATH . DS . "pagination.php");

	//load minor dependencies
	require_once(LIB_PATH . DS . "phpqrcode/qrlib.php");
	require_once(LIB_PATH . DS . "mailer.php");

	//joinedModule
	require_once(LIB_PATH . DS . "mapprplotretriever.php");

	//load stripe
	require_once(LIB_PATH . DS . "vendor/autoload.php");
	\Stripe\Stripe::setApiKey("sk_test_5lqGe81cTwC39ryIuby7KNu2");

	//load dummy module for testing purposes
	require_once(LIB_PATH . DS . "dummy.php");
	
	date_default_timezone_set('Asia/Manila');
?>