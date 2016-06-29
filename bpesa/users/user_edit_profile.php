<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Edit profile';
require_once '../config.php';
require_once '../header.php';
require_once '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$learnersProfilesSql = 'SELECT id FROM leaners WHERE userID = ' . $_SESSION['userId'] .'';
$learnersProfilesSave= $dbconnect->getone($learnersProfilesSql);

if(!empty($learnersProfilesSave)){
    $currentUserProfilesSql = 'SELECT name, surName, idNumber, currentStatus, employmentStatus, learnerCompanyEmployed, position, learnerHighestEducation, profileImage, userName, realName, userEmail, userCategory, userCompany, userCompanyProfile, userEmail, userContactNumber, userWebsite  
                               FROM users INNER JOIN leaners ON users.id=leaners.userID AND users.id = ' . $_SESSION['userId'] .'';
}else{
    $currentUserProfilesSql = 'SELECT userName, 
                                      SUBSTRING_INDEX(realName, " ", 1) AS name,
                                      SUBSTRING_INDEX(realName, " ", -1) AS surName, userEmail, userCategory, userCompany, userCompanyProfile, userEmail, userContactNumber, userWebsite  
                                      FROM users WHERE users.id = ' . $_SESSION['userId'] .'';
}
$currentUserProfiles = $dbconnect->fetch($currentUserProfilesSql);

$employed = $unemployed = ''; 

$highestEducationSql = "SELECT id,name FROM highest_education";
$highestEducationOptions = $dbconnect->fetch($highestEducationSql);

if($currentUserProfiles) {
  foreach($currentUserProfiles as $currentUserProfile) {
    if($currentUserProfile['employmentStatus'] == 'yes'){
        $employed = ' checked="checked" ';  
    } else {
        $unemployed = ' checked="checked "';
    }

    echo '
  <h1 class="page-title"><span class="current-page">Edi</span>t profile</h1>
	<div class="container">
    <form name="editLearnerForm" action="' . HOSTNAME . 'functions/users_edit_profile_save.php" method="post" enctype="multipart/form-data" onsubmit="return validateEditLearnerForm()">
     <table class="table">
        <tr>
          <td><label class="text-info">Profile Image</label></td>
          <td>
          <label class="btn btn-primary btn-file">
            Browse <input type="file" id="profileImage" name="profileImage" style="display:none;" accept="image/*">
          </label>
          <span id="upload-file-info"></span>
          </td>
        </tr>
        <tr>';
      if(!empty($currentUserProfile['profileImage'])) {
         $image = $currentUserProfile['profileImage'];
         echo '<td><img src="' . $image . '" height="50%" />
                   <input type="hidden" name="profileImg" value="' . $image . '"></td>';
      }else{
         echo '<td><img src="' . HOSTNAME . 'images/profile.png" height="100%"></td>';
      }

      if($image != 'images/profile.png') {
         echo '<td></td>';
      }else{
             echo '
              <td>
                  <input type="checkbox" name="use_default" id="use_default" >
                  Use default picture.
              </td>
           ';
      }   
    
    echo '
        </tr>
        <tr>
          <td><label class="text-info">UserName</label></td>
          <td><label>' . $currentUserProfile['userName'] . '</label></td>
        </tr>
        <tr>
          <td><label class="text-info">Name</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['name'] . '" name="name"></td>
        </tr>
        <tr>
          <td><label class="text-info">Surname</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['surName'] . '" name="surName"></td>
        </tr>

        <tr>
          <td><label class="text-info">ID Number</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['idNumber'] . '" name="idNumber"></td>
        </tr>
        <tr>
          <td><label class="text-info">Employment Status</label></td>
          <td>
          <input type="radio" name="employmentStatus" value="yes" id="showEmployed" ' . $employed . ' > Employed
          <input type="radio" name="employmentStatus" value="no" id="hideEmployed" ' . $unemployed . '  > Unemployment
	      </td>
        </tr>';

        if($currentUserProfile['employmentStatus'] == 'yes'){
        echo '
            <tr class="showfields">
              <td><label class="text-info">Where Are You Employed ?</label></td>
              <td><input type="text"  class="form-control" value="' . $currentUserProfile['learnerCompanyEmployed'] . '" name="employmentCompany"></td>
            </tr>
            <tr class="showfields">
              <td><label class="text-info">Employment Position</label></td>
              <td><input type="text" class="form-control" value="' . $currentUserProfile['position'] . '" name="position"></td>
            </tr>';
        }

        echo
        '<tr>
          <td><label class="text-info">Contact Number</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['userContactNumber'] . '" name="ContactNumber"></td>
        </tr>
        <tr>
          <td><label class="text-info">Email</label></td>
          <td><input type="text" class="form-control" value="' . $currentUserProfile['userEmail'] . '" name="email"></td>
        </tr>
        <tr>
          <td><label class="text-info">Highest Level Of Education</label></td>
          <td>
          <span id="hideSelectOption">
            <div id="selectDiv" style="float:left;">
            <select name="highestEducation">
              <option value="Other">Please select</option>';
                foreach($highestEducationOptions as $highestEducationOption) {
                  echo '<option value="' . $highestEducationOption['id']. '"';
                  
                  if ($highestEducationOption['id'] == $currentUserProfile['learnerHighestEducation']){
                    echo ' selected = "selected" ';
                  }
                  
                  echo '>' . $highestEducationOption['name'] . '</option>';
                }
              echo '
            </select>
            </div>
          </span>
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>
           <input type="submit" name="submit" class="btn btn-primary" value="Update">
           <input type="hidden" name="originUrl" value="' . $currentpage . '"></td>
        </tr>
      </table>
    </form>
    </div>';

  }
}
include '../footer.php';
?>