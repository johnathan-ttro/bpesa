<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once 'config.php';
//use this to determine which menus need to be hidden - for instance, the registration page wont need a loggin form
$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
header('Access-Control-Allow-Origin: *');

?>
<!DOCTYPE html>
<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	  <title><?php echo $page_title; ?></title>
	  <!-- Bootstrap -->
	  <link href="<?php echo HOSTNAME . 'css/bootstrap.min.css'; ?>" rel="stylesheet" >
	  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	  <link rel="stylesheet" href="<?php echo HOSTNAME . 'css/responsive.css'; ?>">
	  <link rel="stylesheet" href="<?php echo HOSTNAME . 'css/sticky-footer-navbar.css'; ?>">
	  <link rel="stylesheet" href="<?php echo HOSTNAME . 'css/custom.css'; ?>">
	  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' type='text/css'>
	  <script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>
	  <!-- TinyMCE -->
	  <script type="text/javascript" src="<?php echo HOSTNAME . 'js/tinymce/js/tinymce/tinymce.min.js'; ?>"></script>
	  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
<body>

	<div class="navbar navbar-default navbar-static-top" style="" role="navigation">
	  <div style="position:relative" class="desktop-head"> 
	  	<img src="<?php echo HOSTNAME . 'images/menu_sml.png'; ?>" class="menu-icon" data-toggle="collapse" data-target="#menu" style="position:absolute; z-index:10;"> 
	  	<img src="<?php echo HOSTNAME . 'images/header2.png'; ?>" style="position:relative; width:100%; max-height:126px;max-width:960px;" class="img-responsive"> 
	  </div>
	  <div style="position:relative;" class="mobile-head"> 
	  	<img src="<?php echo HOSTNAME . 'images/header_sml.png'; ?>" style="position:relative; width:100%; max-height:126px;max-width:479px;" class="img-responsive">
	    <div style="width:100%; background-color:#475664; display:block; height:32px; text-align:center"> 
	    	<img src="<?php echo HOSTNAME . 'images/menu_sml.png'; ?>" data-toggle="collapse" data-target="#menu">
	    </div>
	  </div>
	</div>

	<!-- Menu -->
	<?php
	$dbconnect = NEW DB_Class();

	if($_SESSION['userType'] == 'admin') {
        $pageNamesQuery = "SELECT pageUrl, pageType, pageName, pageOrder FROM adminpages WHERE visible='Y' ORDER BY pageOrder";

    }elseif($_SESSION['userType'] == 'provider') {
    	$pageNamesQuery = "SELECT pageUrl, pageType, pageName, pageOrder FROM providerpages WHERE visible='Y' ORDER BY pageOrder";

    }elseif($_SESSION['userType'] == 'users') {
        $pageNamesQuery = "SELECT pageUrl, pageType, pageName, pageOrder FROM userpages WHERE visible='Y' ORDER BY pageOrder";

    }elseif($_SESSION['userType'] == 'vendors') {
        $pageNamesQuery = "SELECT pageUrl, pageType, pageName, pageOrder FROM vendorpages WHERE visible='Y' ORDER BY pageOrder";

    }elseif($_SESSION['userType'] == 'operators') {
        $pageNamesQuery = "SELECT pageUrl, pageType, pageName, pageOrder FROM operatorpages WHERE visible='Y' ORDER BY pageOrder";
    }else{
        $pageNamesQuery = "SELECT pageUrl, pageType, pageName FROM userpages WHERE pageUrl = 'user_courses' AND visible='Y'";
    }
    echo $pageNames;
    $pageNames = $dbconnect->fetch($pageNamesQuery);

	echo '
	<div id="menu" class="panel panel-default panel-collapse collapse">
	  <div class="container">
	    <ul style="position:fixed; left:50%; top:50%;  transform: translate(-50%, -50%); font-size:24px; font-weight:bold; color:#475664; text-transform:uppercase" class="nav nav-pills nav-stacked">
	      <li><a data-toggle="collapse" data-target="#menu">Close</a></li>
	      <li><a href="' . HOSTNAME . 'home.php">Home</a></li>';

			foreach($pageNames as $pageName) {
		        echo '<li><a href="'. HOSTNAME .$pageName['pageType'] . '/' . $pageName['pageUrl'] .'.php">' . $pageName['pageName'] . '</a></li>';
		    }
			if(empty($_SESSION['userName'])) {
		    echo '
				<li><a href="' . HOSTNAME . 'users/user_search.php">Search</a></li>
				<li><a href="' . HOSTNAME . 'users/user_competency_profile.php">Competency Profiles</a></li>';
		    }else{
		    	echo '<li><a  href="' . HOSTNAME . 'functions/logout.php">Logout</a></li>';
		    }

	echo '</ul>
	  </div>
	</div>';

	?>
	<!-- End of the menu -->

<!-- fullscreen menu (.fullscreen) -->
<div class="container-fluid">
  <div class="row">
  	<div class="col-lg-12 col-md-12 col-md-12 col-xs-12">