<!DOCTYPE html>
<html lang="en">
<head>
<title>BPeSA Skills Portal</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sticky-footer-navbar.css">
<link rel="stylesheet" href="css/styles_search.css">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>
<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

</head>
<body>
<div class="navbar navbar-default navbar-static-top" style="" role="navigation">
  <div style="position:relative" class="desktop-head"> 
    <img src="images/menu_sml.png" data-toggle="collapse" data-target="#menu" style="position:absolute; z-index:10;"> 
    <img src="images/header2.png" style="position:relative; width:100%; max-height:126px;max-width:960px;" class="img-responsive"> </div>
  <div style="position:relative;" class="mobile-head"> 
    <img src="images/header_sml.png" style="position:relative; width:100%; max-height:126px;max-width:479px;" class="img-responsive">
    <div style="width:100%; background-color:#475664; display:block; height:32px; text-align:center"> 
      <img src="images/menu_sml.png" data-toggle="collapse" data-target="#menu"> </div>
  </div>
</div>
<div id="menu" class="panel panel-default panel-collapse collapse">
  <div class="container">
    <ul style="position:fixed; left:50%; top:50%;  transform: translate(-50%, -50%); font-size:24px; font-weight:bold; color:#475664; text-transform:uppercase" class="nav nav-pills nav-stacked">
      <li><a data-toggle="collapse" data-target="#menu" href="#">Close</a></li>
      <li><a href="#">Home</a></li>
      <li><a href="#">Courses</a></li>
      <li><a href="#">Edit Profile</a></li>
      <li><a href="user_messages.php">Inbox</a></li>
      <li><a href="user_forum.php">Forum</a></li>
      <li><a class="orange" style="background-color:#dadde0" href="user_search.php">Search</a></li>
      <li><a href="user_competency_profile.php">Competency Profiles</a></li>
    </ul>
  </div>
</div>

<!-- FULLSCREEN MENU CODE (.fullscreen) -->

<div class="container-fluid" style="padding-top:26px !important; padding-bottom:26px;">
  <div class="row">
  <div class="col-md-12">
        <h1 class="page-title"><span class="current-page">Sea</span>rch</h1>
        <h3 class="page-subtitle">Select your search requirements and click on search to filter results</h3>
        
        
</div>
          <form action="http://www.bpesaskillsportal.co.za/users/user_search_results.php" method="post">

    <div class="col-md-12">

    
    <?php
	
	CLASS DB_Class {
  var $db;
  //Live site
   function DB_Class($dbname, $username, $password) {
	$this->db = mysql_connect ('sql17.cpt4.host-h.net', 'bpesatqdmt_4', 'Y4QQdDu8') or die ("Unable to connect to Database Server");
    mysql_select_db ('bpesa_calendar', $this->db) or die ("Could not select database!");
  }
 
  function query($sql) {
    $result = mysql_query ($sql, $this->db) or die ("Invalid query: " . mysql_error());
    return $result;
  }

  function fetch($sql) {
     $data = array();
     $result = $this->query($sql);

     while($row = MYSQL_FETCH_ASSOC($result)) {
          $data[] = $row;
     }
          return $data;
   }

   function getone($sql) {
   $result = $this->query($sql);

    if(MYSQL_NUM_ROWS($result) == 0)
      $value = false;
    else
      $value = MYSQL_RESULT($result, 0);
      return $value;
    }    
}
	
	$dbconnect = NEW DB_Class('bpesa_calendar', 'bpesatqdmt_4', 'Y4QQdDu8');

	
	$competencyCriteriaListsSql = "SELECT id, competencyName FROM compentencies ORDER BY competencyName";
$competencyCriteriaLists = $dbconnect->fetch($competencyCriteriaListsSql);
	
	
	$roleCriteriaListsSql = "SELECT id, roleName FROM course_roles ORDER BY roleName";
$roleCriteriaLists = $dbconnect->fetch($roleCriteriaListsSql);
	
	?>

    <div class="col-md-6 collapser">

<table class="table table-bordered table-striped table-responsive table-hover"   width="35%" border="1" cellspacing="5" cellpadding="5">
  <tbody>
    <th style="background-color:#475664; color:#fff; text-transform:uppercase;padding-left:10px;">Competencies</th>

    
    <?php
	
		$c = 1;
	      foreach($competencyCriteriaLists as $competencyCriteriaList){
      echo '<tr><td>
        <input id="c'. $competencyCriteriaList['id'] .'" type="checkbox" name="competencyName[]" value="' . $competencyCriteriaList['id'] . '"><label for="c'.$competencyCriteriaList['id'].'"><span></span>' . $competencyCriteriaList['competencyName'] . '</label></td></tr>';
		
		$c++;
      }
	

	?>
    
    
    

  </tbody>
</table>
</div>
    <div class="col-md-6 collapser">

<table class="table table-bordered table-striped table-responsive table-hover"   width="65%" border="1" cellspacing="5" cellpadding="5">
  <tbody class="border-left">
    <th style="background-color:#475664; color:#fff;text-transform:uppercase; padding-left:10px;">Roles</th>

    
        <?php
				$b = 1;
	
		      foreach($roleCriteriaLists as $roleCriteriaList) {
        echo '<tr><td>
        <input id="b'. $roleCriteriaList['id']  .'" type="checkbox" name="roleName[]" value="' . $roleCriteriaList['id'] . '"><label for="b'.$roleCriteriaList['id'] .'"><span></span>' . $roleCriteriaList['roleName'] . '</label></td></tr>';
		$b++;  
      }
	
	
	?>
  </tbody>
</table>  
  </div>

    </div>
    
  <div class="col-md-12">
  <input class="search" type="submit" value="Search">
  </div>  
      </form>

  
  </div>
</div>
<footer class="footer">
  <div class="container"> </div>
</footer>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
</body>
</html>
