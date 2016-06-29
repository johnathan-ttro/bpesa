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
      <img src="images/menu_sml.png" data-toggle="collapse" data-target="#menu"> 
    </div>
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
    <div class="col-md-12">
    
<table class="table table-responsive table-hover"  width="100%">
  <tbody>
    <tr>
      <th width="65%">Latest news and announcements</th>
      <th width="10%" class="text-right">Threads/posts</th>
      <th width="25%">Last post</th>
    </tr>
    <tr   onclick="window.location='user_forum_post.php'">
      <td>
      
      <p class="text-uppercase bold">Announcements</p>
      <p>General announcements</p>
      </td>
      <td class="text-right">
      
      <p>Threads: 33</p>
      <p>Posts: 142</p>
      
      </td>
      <td>
      
      <p>The way forward by <span class="text-uppercase orange">Steve</span></p>
      <p>12:42. 04/02/2016</p>
      </td>
    </tr>
    
  </tbody>
</table>

<table class="table table-responsive table-hover"  width="100%">
  <tbody>
    <tr>
    <th width="65%">General</th>
      <th width="10%" class="text-right">Threads/posts</th>
      <th width="25%">Last post</th>
    </tr>
    
    
       

    
    
    <tr   onclick="window.location='user_forum_post.php'">
      <td>
      <p class="text-uppercase bold">Business Life</p>
      <p>General announcements</p>
      </td>
      <td class="text-right">
      
      <p>Threads: 33</p>
      <p>Posts: 142</p>
      
      </td>
      <td>
      
      <p>The way forward by <span class="text-uppercase orange">Steve</span></p>
      <p>12:42. 04/02/2016</p>
      </td>
    </tr>
   

    
        <tr class="border-top"  onclick="window.location='user_forum_post.php'">
      <td>
      
      <p class="text-uppercase bold">Business Life</p>
      <p>General announcements</p>
      </td>
      <td class="text-right">
      
      <p>Threads: 33</p>
      <p>Posts: 142</p>
      
      </td>
      <td>
      
      <p>The way forward by <span class="text-uppercase orange">Steve</span></p>
      <p>12:42. 04/02/2016</p>
      </td>
    </tr>
    
    
        <tr class="border-top"  onclick="window.location='user_forum_post.php'">
      <td>
      
      <p class="text-uppercase bold">Business Life</p>
      <p>General announcements</p>
      </td>
      <td class="text-right">
      
      <p>Threads: 33</p>
      <p>Posts: 142</p>
      
      </td>
      <td>
      
      <p>The way forward by <span class="text-uppercase orange">Steve</span></p>
      <p>12:42. 04/02/2016</p>
      </td>
    </tr>
    
    
    
    
    
        <tr class="border-top"  onclick="window.location='user_forum_post.php'">
      <td>
      
      <p class="text-uppercase bold">Business Life</p>
      <p>General announcements</p>
      </td>
      <td class="text-right">
      
      <p>Threads: 33</p>
      <p>Posts: 142</p>
      
      </td>
      <td>
      
      <p>The way forward by <span class="text-uppercase orange">Steve</span></p>
      <p>12:42. 04/02/2016</p>
      </td>
    </tr>
    
    
    
    
    
        <tr class="border-top"  onclick="window.location='user_forum_post.php'">
      <td>
      
      <p class="text-uppercase bold">Business Life</p>
      <p>General announcements</p>
      </td>
      <td class="text-right">
      
      <p>Threads: 33</p>
      <p>Posts: 142</p>
      
      </td>
      <td>
      
      <p>The way forward by <span class="text-uppercase orange">Steve</span></p>
      <p>12:42. 04/02/2016</p>
      </td>
    </tr>
    
    
  </tbody>
</table>
    
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
