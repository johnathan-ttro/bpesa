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
    <img src="images/menu_sml.png" data-toggle="collapse" data-target="#menu" class="menu-icon"> 
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
      <li><a class="orange" style="background-color:#dadde0" href="user_messages.php">Inbox</a></li>
      <li><a href="user_forum.php">Forum</a></li>
      <li><a href="user_search.php">Search</a></li>
      <li><a href="user_competency_profile.php">Competency Profiles</a></li>
    </ul>
  </div>
</div>

<!-- FULLSCREEN MENU CODE (.fullscreen) -->

<div class="container-fluid" style="padding-top:26px !important; padding-bottom:26px;">
  <div class="row">
    <div class="col-md-12"  style="margin-bottom:20px !important">
      <h1 class="page-title"><span class="current-page">Inb</span>ox</h1>
    </div>
    <div class="col-lg-12">
      <div class="col-md-4">
        <div class="message">
          <div style="float:right;margin-top:12px;" > <a href="#"><img src="images/unread.png"></a> <a href="#"><img style="margin-left:5px;"  src="images/delete.png"></a> </div>
          <h1 class="msg-title">Message Title</h1>
          <span class="date">12:42. 10/02/2016</span>
          <h1 class="msg-sender"><span class="msg-user">USERNAME</span> to me</h1>
        </div>
        <div class="message-open msg-divide">
          <div style="float:right;margin-top:12px;" > <a href="#"><img src="images/unread.png"></a> <a href="#"><img style="margin-left:5px;"  src="images/delete.png"></a> </div>
          <h1 class="msg-title">Message Title</h1>
          <span class="date">12:42. 10/02/2016</span>
          <h1 class="msg-sender"><span class="msg-user">USERNAME</span> to me</h1>
        </div>
        <div class="message msg-divide">
          <div style="float:right;margin-top:12px;" > <a href="#"><img src="images/unread.png"></a> <a href="#"><img style="margin-left:5px;"  src="images/delete.png"></a> </div>
          <h1 class="msg-title">Message Title</h1>
          <span class="date">12:42. 10/02/2016</span>
          <h1 class="msg-sender"><span class="msg-user">USERNAME</span> to me</h1>
        </div>
        <div class="message msg-divide">
          <div style="float:right;margin-top:12px;" > <a href="#"><img src="images/unread.png"></a> <a href="#"><img style="margin-left:5px;"  src="images/delete.png"></a> </div>
          <h1 class="msg-title">Message Title</h1>
          <span class="date">12:42. 10/02/2016</span>
          <h1 class="msg-sender"><span class="msg-user">USERNAME</span> to me</h1>
        </div>
        <div class="message msg-divide">
          <div style="float:right;margin-top:12px;" > <a href="#"><img src="images/unread.png"></a> <a href="#"><img style="margin-left:5px;"  src="images/delete.png"></a> </div>
          <h1 class="msg-title">Message Title</h1>
          <span class="date">12:42. 10/02/2016</span>
          <h1 class="msg-sender"><span class="msg-user">USERNAME</span> to me</h1>
        </div>
      </div>
      <div class="col-md-8">
        <div class="msg-head" style="border-bottom:3px solid #ff6600;padding-bottom:10px; position:relative;margin-top:20px;margin-bottom:15px;">
          <div class="user-image"><img src="images/user.png"> </div>
          <div class="msg-info" style="display:inline; margin-left:20px !important">
            <h1 style="display:inline-block; font-size:24px; margin:0px !important; position:absolute; top:5px">Message Title</h1>
            <h3 style="display:inline-block; font-size:14px; margin:0px ; position:absolute; top:40px">USERNAME to me</h3>
          </div>
          <div class="msg-actions"> <a href="#"><img src="images/trash.png"></a> <a href="#"><img style="margin-left:10px;" src="images/reply.png"></a> <a href="#"><img style="margin-left:15px;"  src="images/forward.png"></a> </div>
        </div>
        <div class="msg-content" style="font-size:13px">
          <p>Nam a venenatis metus, eu imperdiet felis. Nullam sollicitudin, erat in luctus semper, tortor est cursus nibh, id condimentum metus dolor nec risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque pellentesque arcu a orci imperdiet vulputate. Etiam aliquet sodales ligula sit amet suscipit. Nulla hendrerit maximus nulla a auctor. Curabitur erat dui, posuere sed sapien eu, luctus pulvinar massa. Donec eget rhoncus leo. Aenean scelerisque euismod mauris quis eleifend. Ut mattis mauris enim, ut cursus velit fringilla at. </p>
          <p> Mauris convallis ante ut eleifend vehicula. Duis vulputate tellus ante. Sed volutpat euismod mi, non congue purus sollicitudin sit amet. Praesent scelerisque at magna in tempus. Nam mollis, purus vitae gravida accumsan, ipsum velit tempus purus, eget tempor mi nisi sit amet dolor. Etiam vulputate vitae dui eget interdum. Integer consectetur eget turpis ac ullamcorper. Nulla nec urna et tortor tincidunt rhoncus in vitae nisi. Morbi arcu magna, posuere vitae nunc malesuada, dictum tincidunt lacus. Duis interdum felis feugiat efficitur elementum. Duis vestibulum nisi ac nisl bibendum fringilla. Donec nec dolor sit amet eros dapibus condimentum.Nunc ultrices quam at justo congue vehicula. Sed eu massa vel felis ma</p>
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
