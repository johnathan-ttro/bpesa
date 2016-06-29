<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$regionNamesSql = "SELECT id,regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

echo '<div id="customizedbanner"><h1 class="customizedheading" style="margin-top: 220px;">Welcome to the operator registration page.</h1></div>';

echo '<br />
      <br />
      Operators on the BPeSA Skills Portal are able to add courses and competencies, add comments on the forum and contact users.
      <br />
      <br />';

echo '
    <form action="' . HOSTNAME . 'functions/operators_new_operator_save_form.php" method="post" name="operatorForm" onsubmit="return validateForm6()">
    <table width="600px" cellspacing=0 cellpadding=0 id="form2" style="margin-top: 0;"/>
        <tr>
        <td>Username:</td>
        <td> 
            <input type="text" name="userName"/>
            <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
            <div class="tooltip">This is your username. It differs from your actual name in that this can be any name or handle you choose.<br />You will use this name when logging in.</div>
            </div>
            
            <input type="hidden" name="originUrl" value="' . $currentpage . '">
        </td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="password"/></td>
      </tr>
      <tr>
          <td>Company Name:</td>
          <td>
             <span class="first" style = "margin:0;padding:0;">
             <input type="text" name="companyName">
             <div class="hover" style="left:228px; top:-35px;padding-bottom:20px;"><img src="' . HOSTNAME . 'images/icon.png">
                <div class="tooltip">This is your company name. <br /> Users will see this company name on the website.</div>
             </div>
             </span> 
          </td>
        </tr>
      <tr>
        <td>Company Profile:</td>
        <td><textarea name="companyProfile"></textarea></td>
      </tr>
      <tr>
        <td>Website:</td>
        <td>
          <span class="first" style = "margin:0;padding:0;">
          <input type="text" name="companyWebsite">
           <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
              <div class="tooltip">Website.<br />
              This is your company website.
           </div>
          </span>
        </td>
      </tr>
        <tr>
          <td>Contact Person Name:</td>
          <td>
          <input type="text" name="name">
          <span class="first" style = "margin:0;padding:0;">
          </span>
          </td>
        </tr>
        <tr>
          <td>Contact Person Surname:</td>
          <td>
            <span class="first" style = "margin:0;padding:0;">
            <input type="text" name="surName">
            </span>
         </td>
        </tr>
       <tr>
          <td>Contact Number:</td>
          <td>
            <span class="first" style = "margin:0;padding:0;">
            <input type="text" name="contactNumber">
              <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
                <div class="tooltip">This is your contact number.</div>
              </div>
            </span>
          </td>
        </tr>
        <tr>
          <td>Email Address:</td>
          <td>
            <span class="first" style = "margin:0;padding:0;">
            <input type="text" name="email">
              <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
                <div class="tooltip">This is your actual email address.</div>
              </div>
            </span>
          </td>
        </tr>
        <tr>
          <td>Region/Location:</td>
          <td valign="top">';
    if(!empty($regionNamesOptions)){
          foreach($regionNamesOptions as $regionNamesOption) {
            echo '
            <input type="checkbox" name="regionNames[]" value="' . $regionNamesOption['id'] . '">' . $regionNamesOption['regionNames'] . '<br />';  
          }
    }    

echo   '</td>
        </tr>
		        <tr>
		<td></td>
		<td><div class="g-recaptcha" data-sitekey="6Lc36g0TAAAAAHJSq1K6D24krnzhyDrHQXqWCk2e"></div></td>
		</tr>
        <tr>
          <td><input style="display: none;" id="bot" type="text" name="bot" size="25" value="" />&nbsp;</td>
          <td><input type="submit" name="submit" class="submit" value="Register"></td>
        </tr>
      </form>
    </table>
    <br/>
    <br/>';

include '../footer.php';
?>
