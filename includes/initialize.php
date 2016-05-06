<?php 
	
	//absolute path definition
	defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

	defined("SITE_ROOT") ? null : define("SITE_ROOT", DS . "var" . DS . "www" . DS . "html" . DS . "thesis");

	defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT . DS . "includes");

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

	//load minor dependencies
	require_once(LIB_PATH . DS . "phpqrcode/qrlib.php");

?>