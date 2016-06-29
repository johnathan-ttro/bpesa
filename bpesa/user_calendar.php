<!DOCTYPE html>
<html lang="en">
<head>
<title>BPeSA Skills Portal</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sticky-footer-navbar.css">
<link rel="stylesheet" href="css/styles_calendar.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>

<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

</head>
<body>
<div class="navbar navbar-default navbar-static-top" style="" role="navigation">
  <div style="position:relative" class="desktop-head"> <img src="images/menu_sml.png" class="menu-icon" data-toggle="collapse" data-target="#menu" style="position:absolute; z-index:10;"> <img src="images/header2.png" style="position:relative; width:100%; max-height:126px;max-width:960px;" class="img-responsive"> </div>
  <div style="position:relative;" class="mobile-head"> <img src="images/header_sml.png" style="position:relative; width:100%; max-height:126px;max-width:479px;" class="img-responsive">
    <div style="width:100%; background-color:#475664; display:block; height:32px; text-align:center"> <img src="images/menu_sml.png" data-toggle="collapse" data-target="#menu"> </div>
  </div>
</div>
<div id="menu" class="panel panel-default panel-collapse collapse">
  <div class="container">
    <ul style="position:fixed; left:50%; top:50%;  transform: translate(-50%, -50%); font-size:24px; font-weight:bold; color:#475664; text-transform:uppercase" class="nav nav-pills nav-stacked">
      <li><a data-toggle="collapse" data-target="#menu" href="#">Close</a></li>
      <li><a href="index.php">Home</a></li>
      <li><a  class="orange" style="background-color:#dadde0" href="user_courses.php">Courses</a></li>
      <li><a href="#">Edit Profile</a></li>
      <li><a href="user_messages.php">Inbox</a></li>
      <li><a href="user_forum.php">Forum</a></li>
      <li><a href="user_search.php">Search</a></li>
      <li><a href="user_competency_profile.php">Competency Profiles</a></li>
    </ul>
  </div>
</div>

<!-- FULLSCREEN MENU CODE (.fullscreen) -->

<div class="container-fluid" style="padding-top:26px !important">
  <div class="row">
        <div class="col-md-12"  style="margin-bottom:20px !important">
      <h1 class="page-title"><span class="current-page">Cal</span>endar</h1>
    </div>
<div class="col-lg-12">

<?php
$width = 100/7;
?>
<table width="100%"  border="1" class="table table-responsive" >
  <tbody>
    <tr>
      <th colspan="7">
      <div style="padding-bottom:15px;">
      <select class="form-control">
      <option>All provinces</option>
      <option>Western Cape</option>
      <option>KwaZulu Natal</option>
      <option>Eastern Cape</option>
      <option>Northern Cape</option>
      <option>North West Province</option>
      <option>Free State</option>
      <option>Gauteng</option>
      <option>Mpumalanga</option>
      <option>Limpopo</option>
      
      </select>
      
      <table width="275px;" style="text-align:center; margin-left:100px;"><tbody>
      <tr>
      <th>      <img src="images/left-arr.png"></th>
      <th style="text-align:center">      <h1 class="bold" style="margin-top:10px; font-size:28px; display:inline-block">january 2016</h1></th>
      <th>      <img src="images/right-arr.png"></th>
      <tr>
      </tbody></table>

      
      </div>
      </th>
    </tr>
    <tr>
      <th width="<?php echo $width ?>%" class="text-center">Monday</th>
      <th width="<?php echo $width ?>%" class="text-center">Tuesday</th>
      <th width="<?php echo $width ?>%" class="text-center">Wednesday</th>
      <th width="<?php echo $width ?>%" class="text-center">Thursday</th>
      <th width="<?php echo $width ?>%" class="text-center">Friday</th>
      <th width="<?php echo $width ?>%" class="text-center">Saturday</th>
      <th width="<?php echo $width ?>%" class="text-center">Sunday</th>
    </tr>
   <tr>
   <td>1</td>
   <td>2</td>
   <td>3</td>
   <td>4</td>
   <td>5</td>
   <td>6</td>
   <td>7</td>
   </tr>
      <tr>
   <td>8</td>
   <td>9</td>
   <td>10</td>
   <td>11</td>
   <td>12</td>
   <td>13</td>
   <td>14</td>
   </tr>   <tr>
   <td>15</td>
   <td>16</td>
   <td>17</td>
   <td>18</td>
   <td>19</td>
   <td>20</td>
   <td>21</td>
   </tr>   <tr>
   <td>22</td>
   <td>23</td>
   <td>24</td>
   <td>25</td>
   <td>26</td>
   <td>27</td>
   <td>28</td>
   </tr>   <tr>
   <td>29</td>
   <td>30</td>
   <td>31</td>
   <td class="next-month">1</td>
   <td class="next-month">2</td>
   <td class="next-month">3</td>
   <td class="next-month">4</td>
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
