<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$trainingCategorySql = "SELECT id,categoryName FROM user_category";
$trainingCatergoryOptions = $dbconnect->fetch($trainingCategorySql);

$highesteducationSql = "SELECT id, name FROM highest_education";
$highesteducationOptions = $dbconnect->fetch($highesteducationSql);

echo '<div id="customizedbanner"><h1 class="customizedheading" style="margin-top: 220px;">Welcome to the learner registration page.</h1></div>';

echo '<br />
      <br />
      Users on the BPeSA Skills Portal are able to view and attend the courses and competencies, add comments on the forum and contact the
      course providers.
      <br />
      <br />';

echo '
 <form  method="post" action="' . HOSTNAME . 'functions/users_new_save_form.php" id="form2" name="userForm" onsubmit="return validateForm4()" >
    <table width="50%" cellspacing="0" cellpadding="0">
      <tr>
        <td>Username</td>
        <td>
        <input type="text" name="userName" />
        <input type="hidden" name="originUrl" value="' . $currentpage . '" />
        </td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input type="password" name="password" /></td>
      </tr>
      <tr>
        <td>Name</td>
        <td><input type="text" name="name" /></td>
      </tr>
      <tr>
        <td>Surname</td>
        <td><input type="text" name="surName" /></td>
      </tr>
      <tr>
        <td>ID Number</td>
        <td><input type="text" name="idNumber" /></td>
      </tr>
      <tr>
        <td>Employment Status</td>
        <td style = "margin:0;padding:15px 0;">
        <input type="radio" name="employmentStatus" value="yes" id="employedstatus" >Employed
        <input type="radio" name="employmentStatus" value="no" id="unemployedstatus" >Unemployment
	      </td>
      </tr>
      <tr class="showEmploymentfields" style="display:none;">
        <td>Where are you employed ?</td>
        <td><input type="text" name="employmentCompany" /></td>
      </tr>
      <tr class="showEmploymentfields" style="display:none;">
        <td>Employment Position</td>
        <td><input type="text" name="position" /></td>
      </tr>
      <tr>
        <td>Contact Number</td>
        <td><input type="text" name="ContactNumber" /></td>
      </tr>
      <tr>
        <td>Email Address</td>
        <td><input type="text" name="email" /></td>
      </tr>
      <tr>
        <td>Highest Level of Education</td>
        <td>
        <span id="hideSelectOption">
            <div id="selectDiv" style="float:left;">
            <select name="highestEducation">
                <option>Please select</option>';
                foreach($highesteducationOptions as $highesteducationOption) {
                  echo '<option value="' . $highesteducationOption['id'] . '">' . $highesteducationOption['name'] . '</option>';
                }
              echo '
            </select>
            <br />
            <br />
            </div>
          </span>
          <br />
          </td>
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
