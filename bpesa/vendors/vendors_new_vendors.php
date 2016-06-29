<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';

$dbconnect = NEW DB_Class();

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);
echo '<div id="customizedbanner"><h1 class="customizedheading" style="margin-top: 220px;">Welcome to the 3rd party/facilities provider registration page.</h1></div>';

 echo '
    <br />
    <br />
    Facilities provider are allowed to list their venues for hire. Providers on the Portal can thereby easily 
    find your venue offering and make a booking quickly and easily.
    <br />
    <br />
    <form  action="' . HOSTNAME . 'functions/vendor_save_profile.php" method="post" name="vendorForm" onsubmit="return validateForm5()" >
    <table id="form2" cellspacing="0" cellpadding="0"  style="margin-top: 0;" >
        <tr>
          <td>Username:</td>
          <td><input type="text" name="userName">
          <input type="hidden" name="originUrl" value="' . $currentpage . '">
          <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
              <div class="tooltip">This is your username. It differs from your actual name in that this can be any name or handle you choose.<br />You will use this name when logging in.</div>
          </div>
          </td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input type="password" name="password"></td>
        </tr>
        <tr>
          <td>Name:</td>
          <td><input type="text" name="realName" />
           <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
                <div class="tooltip">This is your actual name and surname.</div>
             </div>
          </td>
        </tr>
        <tr>
          <td>Company:</td>
          <td><input type="text" name="userCompany">
           <div class="hover" style="left:228px; top:-35px;padding-bottom:20px;"><img src="' . HOSTNAME . 'images/icon.png">
              <div class="tooltip">This is your company name. <br /> Users will see this company name on the website.</div>
          </div>
          </td>
        </tr>
        <tr>
          <td>Company Profile</td>
          <td><textarea name="userCompanyProfile"></textarea>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;<input type="hidden" name="userCategory" value="3rd Party/Provider/Captive"></td>
        </tr>
        <tr>
          <td>Email Address:</td>
          <td><input type="text" name="userEmail"></td>
        </tr>
        <tr>
          <td>Contact Number:</td>
          <td><input type="text" name="userContactNumber">
           <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
              <div class="tooltip">This is your contact number.</div>
            </div>
          </td>
        </tr>
        <tr>
          <td>Website</td>
          <td><input type="text" name="userWebsite">
          <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
          <div class="tooltip">Website.<br />
            This is your company website.
          </div>
        </div>
          </td>
        </tr>
        <tr>
          <td></td>
		      <td><div class="g-recaptcha" data-sitekey="6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e"></div></td>
		    </tr>
    		<tr>
          <td><input style="display: none;" id="bot" type="text" name="bot" size="25" value="" />&nbsp;</td>
          <td style="padding-bottom:25px;"><input type="submit" name="submit" class="submit" value="Register"></td>
        </tr>
      </table>
      </form>';
 
 include '../footer.php';
?>
