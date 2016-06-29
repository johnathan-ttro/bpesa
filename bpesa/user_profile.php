<!DOCTYPE html>
<html lang="en">
<head>
<title>BPeSA Skills Portal</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="css/sticky-footer-navbar.css">
<link rel="stylesheet" href="css/styles_profile.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>

<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

</head>
<body>
<div class="navbar navbar-default navbar-static-top" style="" role="navigation">
  <div style="position:relative" class="desktop-head"> 
    <img src="images/menu_sml.png" class="menu-icon" data-toggle="collapse" data-target="#menu" style="position:absolute; z-index:10;"> 
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
      <li><a href="index.php">Home</a></li>
      <li><a href="user_courses.php">Courses</a></li>
      <li><a   class="orange" style="background-color:#dadde0" href="user_profile.php">Edit Profile</a></li>
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
      <h1 class="page-title"><span class="current-page">Edi</span>t profile</h1>
    </div>
    <div class="col-lg-6" style="margin:0 auto; float:none">
    
    
    
    
      <table style="margin-bottom:35px;" width="100%" border="0" cellspacing="5" cellpadding="5">
        <tbody>
        
        <tr>
        <td colspan="2">
            <label>Profile Image</label>
			<div style="position:relative">
            
            <img src="images/profile.png">
            
            <input  style="display:inline-block; position:absolute;left:240px;padding:4px; border:none; background-color:transparent;" id="uploadFile" placeholder="Choose File" disabled="disabled" />
            <div style="position:absolute;left:160px; margin:0px;" class="fileUpload btn btn-primary">
                <span>Upload</span>
                <input id="uploadBtn" type="file" class="upload" />
            </div>

            <input  id="default" type="checkbox"  value=""><label  style="display:inline-block; position:absolute; top:30px; left:160px;" class="checkbox" for="default"><span></span>Use default image</label>
            
            </div>
        
        </td>
        </tr>
          <tr>
            <td><label>Username</label></td>
            <td><input type="text" disabled class="form-control" placeholder="username"></td>
          </tr>          <tr>
            <td><label>First Name</label></td>
            <td><input type="text" class="form-control" placeholder="First name"></td>
          </tr>          <tr>
            <td><label>Surname</label></td>
            <td><input type="text" class="form-control" placeholder="Surname"></td>
          </tr>          <tr>
            <td><label>ID Number</label></td>
            <td><input type="text" class="form-control" placeholder="9028719492088"></td>
          </tr>          <tr>
            <td><label>Employment Status</label></td>
            <td>
            <div style="position:relative">
                   <input id="employed" type="checkbox" value=""><label class="checkbox" for="employed"><span></span>Employed</label>
                   <input id="unemployed" type="checkbox"  value=""><label class="checkbox" for="unemployed"><span></span>Unemployed</label>

            </div>
            </td>
          </tr>
          <tr>
            <td><label>Contact Number</label></td>
            <td><input type="text" class="form-control" placeholder="071 1234 567"></td>
          </tr>
                    <tr>
            <td><label>E-mail</label></td>
            <td><input type="email" class="form-control" placeholder="email@email.com"></td>
          </tr>
          <tr>
            <td><label>Highest Level of Education</label></td>
            <td><select class="form-control">
                <option>No formal eduaction</option>
                <option>Grade 10</option>
                <option>Grade 12</option>
                <option>Certificate</option>
                <option>Diploma</option>
                <option>Higher Diploma</option>
                <option> Bachelors Degree</option>
                <option>Post Graduate Diploma</option>
                <option>Masters Degree</option>
                <option>Doctorate (PhD)</option>
              </select></td>
          </tr>
          <tr>
            <td><input type="submit" value="update" class="form-control"></td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<footer class="footer">
  <div class="container"> </div>
</footer>

<script>
document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};
</script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> 
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
</body>
</html>
