<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once 'config.php';

//use this to determine which menus need to be hidden - for instance, the registration page wont need a loggin form
$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
header('Access-Control-Allow-Origin: *');

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$trainingCategorySql = "SELECT id,categoryName FROM training_categories";
$trainingCatergoryOptions = $dbconnect->fetch($trainingCategorySql);


$highesteducationSql = "SELECT id, name FROM highest_education";
$highesteducationOptions = $dbconnect->fetch($highesteducationSql);

$regionNamesSql = "SELECT id,regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>BPeSA Skills Portal</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo HOSTNAME . 'css/sticky-footer-navbar.css'; ?>">
<link rel="stylesheet" href="<?php echo HOSTNAME . 'css/styles.css'; ?>">

<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit'></script>
<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
<!--<script type="text/javascript" src="js/modernizr.custom.04022.js"></script>-->

<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo HOSTNAME . 'js/tinymce/js/tinymce/tinymce.min.js'; ?>"></script>
</head>
<body>
<div class="container-fluid">
  <div class="row" style="background-color:#475664"><img src="images/login.png"  style="margin:0;" class="img-responsive"></div>
  <div class="row">
    <div class="col-md-3"> </div>
    <div class="col-md-6 text-center"  style="color:#fff; margin-top:10%; font-size:16px;">
      <div style="max-width:500px; margin:0 auto;">
        <div class="col-md-3 login tabs selected" id="show_login">Login</div>
        <div class="col-md-3 register tabs unselected" id="show_register">Register</div>
        <div class="col-md-6 reset tabs unselected" id="show_reset">Forgot Password?</div>
        <div class="col-md-12 blocks">

          <!-- Login  -->
          <div id="login_block" style=" max-width:400px; margin:0 auto;">
            <form name="loginForm" action="<?php echo HOSTNAME . 'functions/loginCheck.php'; ?>" onsubmit="return validateLoginForm()" method="post">
              <input class="text" type="hidden" name="originUrl" value="home">
              <h3 style="color:#fff; margin-top:0px;padding-top:10px;">Log into skills portal</h3>
              <p>
                <input style="border-radius:0;" class="form-control" type="text" placeholder="Username" name="userName">
              </p>
              <p>
                <input style="border-radius:0;"  class="form-control" type="password" placeholder="Password" name="password">
              </p>
              <p>
                <input type="submit" class="btn-sm" value="Login">
              </p>
            </form>
          </div>
          <!-- End of login -->

          <div id="register_block" style=" max-width:600px; margin:0 auto;">
            <div class="text-center">
              <div class="btn-group">
                <div id="btn_trainer" class="btn btn-sm active" style="background-color:#475664; border:1px solid #ff6600">Training provider</div>
                <div id="btn_learner" class="btn btn-sm" style="background-color:#475664; border:1px solid #ff6600">Learner</div>
                <div id="btn_facilities" class="btn btn-sm" style="background-color:#475664; border:1px solid #ff6600">Facilities provider</div>
                <div id="btn_operator" class="btn btn-sm" style="background-color:#475664; border:1px solid #ff6600">Operator</div>
              </div>
            </div>

            <?php
            echo '
            <div id="trainer_form">
              <h3 style="color:#fff; margin-top:0px;padding-top:10px;">Register as a training provider</h3>
              <form name="trainingProviderForm" action="' . HOSTNAME . 'functions/provider_new_provider_form_save.php" method="post" enctype="multipart/form-data" onsubmit="return validateTrainingProviderForm()">
                <p>
                  <label>Username</label>
                  <input type="hidden" name="originUrl">
                  <input type="text" class="form-control" name="userName" autocomplete="off">
                </p>
                <p>
                  <label>Password</label>
                  <input type="password" class="form-control" name="password">
                </p>
                <p>
                  <label>Company Name</label>
                  <input type="text" class="form-control" name="companyName">
                </p>
                <p>
                  <label>Training Category</label>
                  <select class="form-control" name="trainingCatergory">
                    <option value="other">Please Select</option>';

                    foreach($trainingCatergoryOptions as $trainingCatergoryOption) {
                      echo '<option value="' . $trainingCatergoryOption['id'] . '">' . $trainingCatergoryOption['categoryName'] . '</option>';
                    }

              echo '
                  </select>
                </p>
                <p>
                  <label>Contact Person</label>
                  <input type="text" class="form-control" name="contactName">
                </p>
                <p>
                  <label>Email Address</label>
                  <input type="text" class="form-control" name="email">
                </p>
                <p>
                  <label>Contact Number</label>
                  <input type="tel" class="form-control" name="contactNumber">
                </p>
                <p>
                  <label>Location</label>
                  <input type="text" class="form-control" name="location">
                </p>
                <p>
                  <label>Accreditation</label>
                  <input type="file" name="accreditaton">
                </p>
                <p>
                  <label>Accreditation Expiry Date</label>
                  <span id="profileDatePicker" style = "margin:0;padding:0;">
                  <input type="text" class="form-control" name="accreditatonExpire"  id="datepicker">
                  </span>
                </p>
                <p>
                  <label>Company Logo</label>
                  <input type="file"  name="companyLogo">
                </p>
                <p>
                  <label>Company Profile</label>
                  <textarea class="form-control" name="companyProfile"></textarea>
                </p>
                <p>
                  <label>Website</label>
                  <input type="text" class="form-control" name="companyWebsite">
                </p>
                <div class="text-center">
                  <div  id="RecaptchaField1" class="g-recaptcha" style="margin:0 auto;padding:47px; " data-sitekey="6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e"></div>
                </div>
                <p>
                  <input type="submit" value="Submit" class="form-control">
                </p>
              </form>
            </div>';

            
            echo '
            <div id="learner_form">
              <h3 style="color:#fff; margin-top:0px;padding-top:10px;">Register as learner</h3>
              <form name="learnerForm" method="post" action="' . HOSTNAME . 'functions/users_new_save_form.php" onsubmit="return validateLearnerForm()">
                <p>
                  <label>Username</label>
                  <input type="text" class="form-control" name="userName">
                </p>
                <p>
                  <label>Password</label>
                  <input type="password" class="form-control" name="password">
                </p>
                <p>
                  <label>Name</label>
                  <input type="text" class="form-control"  name="name">
                </p>
                <p>
                  <label>Surname</label>
                  <input type="text" class="form-control"  name="surName">
                </p>
                <p>
                  <label>ID Number</label>
                  <input type="text" class="form-control"  name="idNumber">
                </p>
                <p>
                  <label>Employment Status</label>
                  <br>
                  <label>
                    <input type="radio" name="employmentStatus" value="yes" id="employedstatus">
                    Employed</label>
                  <label style="float:right">
                    <input type="radio" name="employmentStatus" value="no" id="unemployedstatus">
                    Unemployed</label>
                  <br>
                </p>
                <div class="showEmploymentfields">
                <p>
                  <label>Where are you employed ?</label>
                  <input type="text" class="form-control" name="employmentCompany">
                </p>
                <p>
                  <label>Employment Position</label>
                  <input type="text" class="form-control" name="position">
                </p>
                </div>
                <p>
                  <label>Contact Number</label>
                  <input type="text" class="form-control" name="ContactNumber">
                </p>
                <p>
                  <label>Email Address</label>
                  <input type="text"  id="email" class="form-control" name="email">
                  <div class="email_avail_result" id="email_avail_result"></div>
                </p>
                <p>
                  <label>Highest Level of Education</label>
                  <select name="highestEducation" class="form-control">
                  <option value="other">Please select</option>';

                  foreach($highesteducationOptions as $highesteducationOption) {
                    echo '<option value="' . $highesteducationOption['id'] . '">' . $highesteducationOption['name'] . '</option>';
                  }

                  echo '
                </select>
                </p>
                <div class="text-center">
                  <div id="RecaptchaField2" class="g-recaptcha" style="margin:0 auto;padding:47px; " data-sitekey="6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e"></div>
                </div>
                <p>
                  <input type="submit" value="Submit" class="form-control">
                </p>
              </form>
            </div>';
            
          echo '
          <div id="facilities_form">
            <h3 style="color:#fff; margin-top:0px;padding-top:10px;">Register as a facilities provider</h3>
            <form name="facilityproviderForm" action="' . HOSTNAME . 'functions/vendor_save_profile.php" method="post" onsubmit="return validateFacilityproviderForm()" >
                <p>
                  <label>Username</label>
                  <input type="text" class="form-control" name="userName">
                  <input type="hidden" name="originUrl" value="' . $currentpage . '">
                </p>
                <p>
                  <label>Password</label>
                  <input type="password" class="form-control" name="password">
                </p>
                <p>
                  <label>Fullname</label>
                  <input type="text" class="form-control" name="realName">
                </p>
                <p>
                  <label>Company</label>
                  <input type="text" class="form-control" name="userCompany">
                </p>
                <p>
                  <label>Company Profile</label>
                  <textarea name="userCompanyProfile"></textarea> 
                  <input type="hidden" name="userCategory" value="3rd Party/Provider/Captive">
                </p>
                <p>
                  <label>Email Address</label>
                  <input type="text" class="form-control" name="userEmail">
                </p>
                <p>
                  <label>Contact Number</label>
                  <input type="text" class="form-control" name="userContactNumber">
                </p>
                <p>
                  <label>Website</label>
                  <input type="text" class="form-control" name="userWebsite">
                </p>
                <p>
                  <div class="g-recaptcha" data-sitekey="6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e"></div>
                </p>
                <p>
                  <input style="display: none;" id="bot" type="text" name="bot" size="25" value="">
                  <input type="submit" value="Register" class="form-control" name="submit">
                </p>
              </form>
            </div>';

          echo '
            <div id="operator_form">
              <h3 style="color:#fff; margin-top:0px;padding-top:10px;">Register as an operator</h3>
                <form name="operatorForm" action="' . HOSTNAME . 'functions/operators_new_operator_save_form.php" method="post" onsubmit="return validateOperatorForm()">
                  <p>
                    <label>Username</label>
                    <input type="text" class="form-control" name="userName">
                    <input type="hidden" name="originUrl" value="' . $currentpage . '">
                  </p>
                  <p>
                    <label>Password</label>
                    <input type="password" class="form-control" name="password">
                  </p>
                  <p>
                    <label>Company Name</label>
                    <input type="text" class="form-control" name="companyName">
                  </p>
                  <p>
                    <label>Company Profile</label>
                    <textarea name="companyProfile"></textarea>
                  </p>
                  <p>
                    <label>Website</label>
                    <input type="text" class="form-control" name="companyWebsite">
                  </p>
                  <p>
                    <label>Contact Person Name</label>
                    <input type="text" class="form-control" name="name">
                  </p>
                  <p>
                    <label>Contact Person Surname</label>
                    <input type="text" class="form-control" name="surName">
                  </p>
                  <p>
                    <label>Contact Number</label>
                    <input type="text" class="form-control" name="contactNumber">
                  </p>
                  <p>
                    <label>Email Address</label>
                    <input type="text" class="form-control" name="email">
                  </p>
                  <p>
                    <label>Region/Location</label>
                    <br />';
                if(!empty($regionNamesOptions)){
                      foreach($regionNamesOptions as $regionNamesOption) {
                        echo '
                        <input type="checkbox" name="regionNames[]" value="' . $regionNamesOption['id'] . '"> ' . $regionNamesOption['regionNames'] . '<br />';  
                      }
                }    

          echo '</p>
                <p>
                  <div class="g-recaptcha" data-sitekey="6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e"></div>
                </p>
                <p>
                  <input style="display: none;" id="bot" type="text" name="bot" size="25">
                  <input type="submit" class="form-control" value="Register" name="submit">
                </p>
              </form>
            </div>
          </div>'; 

          ?>
          <div id="reset_block" style=" max-width:400px; margin:0 auto;">
            <form action="<?php echo HOSTNAME . 'functions/forgot_password_form_save.php' ?>" method="post" onsubmit="return validateForgotPassword()">
              <h3 style="color:#fff; margin-top:0px;padding-top:10px;">Forgot password</h3>
              <p>Enter email and click submit to receive login details.</p>
              <p>
                <input style="border-radius:0;" class="form-control" type="email" name="userEmail" placeholder="example@user.com">
                <input class="text" type="hidden" name="originUrl" value="<?php echo $currentpage ?>" />
              </p>
              <p>
                <input type="submit" class="btn-sm" value="Submit">
              </p>
            </form>
          </div>
        </div>

      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>
<footer class="footer">
  <div class="container"> </div>
</footer>
<script src="<?php echo HOSTNAME . 'js/jquery.min.js'; ?>"></script>
<script src="<?php echo HOSTNAME . 'js/bootstrap.min.js'; ?>"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo HOSTNAME . 'js/validationscript.js'; ?>"></script>
<script>
    var CaptchaCallback = function(){
        grecaptcha.render('RecaptchaField1', {'sitekey' : '6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e'});
        grecaptcha.render('RecaptchaField2', {'sitekey' : '6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e'});
    };
  // Registration Tabs
  $("#facilities_form").hide();    
	$("#learner_form").hide();
  $("#operator_form").hide();

$("#btn_trainer").click(function(){
	$("#btn_trainer").addClass('active');
  $("#trainer_form").show(0);
  $("#learner_form").hide(0);
  $("#facilities_form").hide(0);
  $("#operator_form").hide(0);
	$("#btn_facilities").removeClass('active');	
	$("#btn_learner").removeClass('active');
	$("#btn_operator").removeClass('active');		
});

$("#btn_learner").click(function(){
	$("#btn_learner").addClass('active');
  $("#learner_form").show(0);
  $("#trainer_form").hide(0);
  $("#facilities_form").hide(0);
  $("#operator_form").hide(0);
	$("#btn_facilities").removeClass('active');	
	$("#btn_trainer").removeClass('active');
	$("#btn_operator").removeClass('active');
});

$("#btn_facilities").click(function(){		
	$("#btn_facilities").addClass('active');
  $("#facilities_form").show(0);
  $("#learner_form").hide(0);
  $("#trainer_form").hide(0);
  $("#operator_form").hide(0);
	$("#btn_learner").removeClass('active');	
	$("#btn_trainer").removeClass('active');
	$("#btn_operator").removeClass('active');
});

$("#btn_operator").click(function(){
	$("#btn_operator").addClass('active');
  $("#operator_form").show(0);
	$("#facilities_form").hide(0);
  $("#learner_form").hide(0);
  $("#trainer_form").hide(0);
	$("#btn_learner").removeClass('active');	
	$("#btn_trainer").removeClass('active');
	$("#btn_facilities").removeClass('active');		
});

//Login, Register and Forgot Tabs
$("#reset_block").hide();
$("#register_block").hide();

$("#show_login").click(function(){
  $("#login_block").show(0);
  $("#reset_block").hide(0);
  $("#register_block").hide(0);
	$("#show_login").addClass('selected');
	$("#show_register").addClass('unselected');
	$("#show_register").removeClass('selected');
	$("#show_reset").addClass('unselected');
	$("#show_reset").removeClass('selected');		
});
	
$("#show_register").click(function(){	
  $("#login_block").hide(0);
  $("#reset_block").hide(0);
  $("#register_block").show(0);
	$("#show_register").addClass('selected');
	$("#show_login").addClass('unselected');
	$("#show_login").removeClass('selected');
	$("#show_reset").addClass('unselected');
	$("#show_reset").removeClass('selected');
	
});


$("#show_reset").click(function(){
	
  $("#login_block").hide(0);
  $("#reset_block").show(0);
  $("#register_block").hide(0);
	$("#show_reset").addClass('selected');
	$("#show_register").addClass('unselected');
	$("#show_register").addClass('border_line');
	$("#show_register").removeClass('selected');	
	$("#show_login").addClass('unselected');
	$("#show_login").removeClass('selected');

});

$(".showEmploymentfields").hide();

$("#employedstatus").click(function(){;
    $(".showEmploymentfields").show("slow");
});

$("#unemployedstatus").click(function(){;
    $(".showEmploymentfields").hide("slow");
});

tinymce.init({
    selector: "textarea"
 });

$( document ).ready(function() {
  var date = $('#datepicker').datepicker({ dateFormat: 'dd/mm/yy' }).val();
  var date2 = $('#datepicker2').datepicker({ dateFormat: 'dd/mm/yy' }).val();
  var date3 = $('#courseEndDate').datepicker({ dateFormat: 'dd/mm/yy' }).val();
  var date4 = $('#courseStartDate').datepicker({ dateFormat: 'dd/mm/yy' }).val();

  $("#profileDatePicker").click(function() {
    $("#datepicker").datepicker();
  });

  $(function(){
    $("#datepicker").datepicker();
  });
    
  $(function(){
    $("#datepicker2").datepicker();
  });
    
  $(function(){
    $("#courseEndDate").datepicker();
  });

});

</script>
</body>
</html>
