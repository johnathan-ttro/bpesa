<!DOCTYPE html>
<html lang="en">
<head>
<title>BPeSA Skills Portal</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sticky-footer-navbar.css">
<link rel="stylesheet" href="css/styles.css">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>

<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->


</head>
<body>
<div class="navbar navbar-default navbar-static-top" style="" role="navigation">
  <div style="position:relative" class="desktop-head"> 
    <img src="images/menu_sml.png" data-toggle="collapse" data-target="#menu" style="position:absolute; z-index:10;"> 
  <?php
  
  $header = 'mail';
  
  if($header='mail'){
	  
	  echo ' <img src="images/header_mail.png" style="position:relative; width:100%; max-height:126px;max-width:960px;" class="img-responsive"> ';

	  
  }else{
	  
	  	  echo ' <img src="images/header2.png" style="position:relative; width:100%; max-height:126px;max-width:960px;" class="img-responsive"> ';
	  
	  
  }
  
  ?>
  
  
  
  </div>
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
      <li><a class="orange" style="background-color:#dadde0" href="user_forum.php">Forum</a></li>
      <li><a href="user_search.php">Search</a></li>
      <li><a href="user_competency_profile.php">Competency Profiles</a></li>
    </ul>
  </div>
</div>

<!-- FULLSCREEN MENU CODE (.fullscreen) -->

<div class="container-fluid" style="padding-top:26px !important; padding-bottom:26px;">
  <div class="row">
    <div class="col-md-12"  style="margin-bottom:20px !important">
      <h1 class="page-title"><span class="current-page">For</span>um</h1>
    </div>
    <div class="col-lg-12">
    
	<div class="col-md-12" style="background-color:#FF6600; padding:10px; color:#fff; padding-left:25px;">
    <p style="margin-bottom:0px"><span class="text-uppercase">Thread: </span>The way forward</p>
    </div>    

<div>
	<div class="col-md-12" style="background-color:#475664; padding:10px; color:#fff; padding-right:25px; padding-left:25px;margin-top:10px;">
    <p style="margin-bottom:0px; float:left;">March 2nd, 2015, 10:02 PM</p>
    <p style="margin-bottom:0px; float:right">#1</p>
    </div> 
    
	<div class="col-md-3" style="padding:25px; background-color:#dadde0; color:#475664">
    <p class="orange text-uppercase bold">Username</p>
    <p><img src="images/users.png" style="background-color:#ff6600" width="50%" height="50%"></p>
    <p style="margin-bottom:3px;">Join date: March 2015</p>
    <p style="margin-bottom:3px;">Location: CPT</p>
    <p style="margin-bottom:0px;">Posts: 300</p>
    </div>
    
    <div class="col-md-9"  style="padding:25px; color:#475664">
    <p>Sed pulvinar placerat velit, at eleifend elit semper in. Proin feugiat tincidunt enim sed lacinia. Praesent sapien ligula, consectetur et dignissim id, varius sit amet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut porta massa in nulla tristique egestas. Cras non justo nec elit faucibus vulputate ac elementum augue. Curabitur porttitor ut leo at tempus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras sed lorem non nibh luctus consectetur. Proin dictum quam eget mauris iaculis mattis. Aliquam erat volutpat. Vivamus faucibus pretium tortor non fermentum. Etiam tristique lacus quis massa faucibus, eget posuere nulla dictum. Aliquam luctus odio libero, vel vestibulum orci consectetur quis.</p>

<p>Praesent in cursus arcu. Maecenas vitae est ex. Aenean vestibulum blandit nunc, vitae molestie ligula viverra sagittis. Nullam mollis lacus in interdum blandit. Pellentesque rhoncus efficitur porttitor. In est felis, fringilla in purus vel, facilisis accumsan lectus. Sed arcu erat, sagittis vel dignissim quis, ultrices et tellus. Integer quis finibus purus. In rutrum pulvinar augue nec lacinia. Mauris est felis, vulputate eget vehicula quis, fringilla ut orci. Sed pellentesque tellus tincidunt, interdum nulla non, vehicula orci.</p>
    </div>
  
  </div>
  
  <div>
	<div class="col-md-12" style="background-color:#475664; padding:10px; color:#fff; padding-right:25px; padding-left:25px;margin-top:10px;">
    <p style="margin-bottom:0px; float:left;">March 9th, 2015, 5:02 PM</p>
    <p style="margin-bottom:0px; float:right">#2</p>
    </div> 
    
	<div class="col-md-3" style="padding:25px; background-color:#dadde0; color:#475664">
    <p class="orange text-uppercase bold">Username</p>
    <p><img src="images/users.png" style="background-color:#ff6600" width="50%" height="50%"></p>
    <p style="margin-bottom:3px;">Join date: March 2015</p>
    <p style="margin-bottom:3px;">Location: CPT</p>
    <p style="margin-bottom:0px;">Posts: 300</p>
    </div>
    
    <div class="col-md-9"  style="padding:25px; color:#475664">
    <p>Sed pulvinar placerat velit, at eleifend elit semper in. Proin feugiat tincidunt enim sed lacinia. Praesent sapien ligula, consectetur et dignissim id, varius sit amet massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut porta massa in nulla tristique egestas. Cras non justo nec elit faucibus vulputate ac elementum augue. Curabitur porttitor ut leo at tempus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras sed lorem non nibh luctus consectetur. Proin dictum quam eget mauris iaculis mattis. Aliquam erat volutpat. Vivamus faucibus pretium tortor non fermentum. Etiam tristique lacus quis massa faucibus, eget posuere nulla dictum. Aliquam luctus odio libero, vel vestibulum orci consectetur quis.</p>

<p>Praesent in cursus arcu. Maecenas vitae est ex. Aenean vestibulum blandit nunc, vitae molestie ligula viverra sagittis. Nullam mollis lacus in interdum blandit. Pellentesque rhoncus efficitur porttitor. In est felis, fringilla in purus vel, facilisis accumsan lectus. Sed arcu erat, sagittis vel dignissim quis, ultrices et tellus. Integer quis finibus purus. In rutrum pulvinar augue nec lacinia. Mauris est felis, vulputate eget vehicula quis, fringilla ut orci. Sed pellentesque tellus tincidunt, interdum nulla non, vehicula orci.</p>
    </div>
  
  </div>
  
    
    </div>
    
    
    
    
  </div>
</div>
<footer class="footer">
  <div class="container"> </div>
</footer>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
</body>
</html>
