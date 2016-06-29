<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Edit Profile';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$currentUserProfilesSql = "SELECT userName, SUBSTRING_INDEX(SUBSTRING_INDEX(realName, ' ', 1), ' ', -1) AS first_name , SUBSTRING_INDEX(SUBSTRING_INDEX(realName, ' ', 2), ' ', -1) AS last_name, userEmail, userCompany, userCompanyProfile, userEmail, userContactNumber, userWebsite FROM users WHERE id = " . $_SESSION['userId'];
$currentUserProfiles = $dbconnect->fetch($currentUserProfilesSql);

if($currentUserProfiles) {
  foreach($currentUserProfiles as $currentUserProfile) {
    echo '<div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-12 col-xs-12">
	<h1 class="page-title"><span class="current-page">Edi</span>t profile</h1>
	<form action="' . HOSTNAME . 'functions/vendor_edit_profile.php" method="post">
    <table class="table">
         <tr>
          <td><label class="text-info">UserName</label></td>
          <td><input type="hidden" name="originUrl" value="' . $currentpage . '">
          <label>' . $currentUserProfile['userName'] . '</label>
          </td>
        </tr>
        <tr>
          <td><label class="text-info">Name</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['first_name'] . '" name="realName"></td>
        </tr>
		<tr>
          <td><label class="text-info">Surname</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['last_name'] . '" name="surName"></td>
        </tr>
        <tr>
          <td><label class="text-info">Company</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['userCompany'] . '" name="userCompany"></td>
        </tr>
        <tr>
          <td><label class="text-info">Company Profile</label></td>
          <td><textarea name="userCompanyProfile">' . $currentUserProfile['userCompanyProfile'] . '</textarea>
        </tr>
        <tr>
          <td><label class="text-info">Category</label></td>
          <td>
          <span id="hideSelectOption">
            <div id="selectDiv" style="float:left;">
            <select name="userCategory">
              <option>Please select</option>
              <option value="domestic/international">Domestic/International</option>
              <option value="3rd Party/Provider/Captive">3rd Party/Provider/Captive</option>
              <option value="Public/Private">Public/Private</option>
            </select>
            </div>
          </span>
          </td>
        </tr>
        <tr>
          <td><label class="text-info">Email</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['userEmail'] . '" name="userEmail"></td>
        </tr>
        <tr>
          <td><label class="text-info">Contact Number</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['userContactNumber'] . '" name="userContactNumber"></td>
        </tr>
        <tr>
          <td><label class="text-info">Website</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['userWebsite'] . '" name="userWebsite"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="submit" name="submit" class="btn btn-primary" value="Update"></td>
        </tr>
      </table>
	</form>
   </div>
 <br/>';
  }
}
include '../footer.php';
?>
