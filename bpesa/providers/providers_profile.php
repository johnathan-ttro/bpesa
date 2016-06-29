<?php
//turn off deprecicated warnings
//error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Edit profile';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$providerDetailsSql = "SELECT companyName, 
                              contactPerson, 
                              email, 
                              contactNumber, 
                              location, 
                              companyLogo,
                              bankDetails,
                              website,
                              StartDate,
                              users.userCompanyProfile,
                              customTrainingCategory
                              FROM providers
                              INNER JOIN users on providers.userID = users.id
                              WHERE userID = " . $_SESSION['userId'] . "";
$providerDetails = $dbconnect->fetch($providerDetailsSql);

$providerIdSql = 'SELECT id FROM providers WHERE userID = ' . $_SESSION['userId'];
$providerId = $dbconnect->getone($providerIdSql);

$accredDocsSql = 'SELECT documentName, documentUrl, expiaryDate
                  FROM accreditationdocuments
                  WHERE providerId = ' . $providerId;

$accredDocs = $dbconnect->fetch($accredDocsSql);

$providerProfileContentSql = "SELECT pageContent FROM providerpages WHERE pageUrl = '" . $currentpage . "'";
$providerProfileContent = $dbconnect->getone($providerProfileContentSql);

$trainingCategorySql = "SELECT id,categoryName FROM training_categories";
$trainingCatergoryOptions = $dbconnect->fetch($trainingCategorySql);
?>

<?php
 echo '<h1 class="page-title"><span class="current-page">Edi</span>t profile</h1>';

  echo $providerProfileContent;
  foreach ($providerDetails as $providerDetail) {
    echo '
    <div class="container">
    <table class="table">
      <form action="' . HOSTNAME . 'functions/provider_form_save.php" method="post" enctype="multipart/form-data" class="providerprofile" name="providerFrom" onsubmit="return validateForm3()">
      <tr>
        <td><label class="text-info">Username</label></td>
        <td>
          <label>' . $_SESSION['userName'] . '</label>
          <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '" >
          <input type="hidden" name="originUrl" value="' . $currentpage . '" >
        </td>                
      </tr>
      <tr>
        <td><label class="text-info">Company Name</label></td>
        <td><input type="text" class="form-control" name="companyName" value="' . $providerDetail['companyName'] . '"></td>
      </tr>
      <tr>
        <td><label class="text-info">Company Profile</label></td>
        <td><textarea name="companyProfile">' . $providerDetail['userCompanyProfile'] . '</textarea></td>
      </tr>
      <tr>
        <td><label class="text-info">Training Category</label></td>
        <td>
          <span id="hideSelectOption">
            <div id = "selectDiv" style = "float:left;">
              <select name="trainingCategories">
                <option value="other">Please Select</option>';
                foreach($trainingCatergoryOptions as $trainingCatergoryOption) {
                    
                  echo '<option value="' . $trainingCatergoryOption['id'] . '"'; 
                  if ($providerDetail['customTrainingCategory'] == $trainingCatergoryOption['id']){
                    echo ' selected = "selected"';
                  }
                  echo '>' . $trainingCatergoryOption['categoryName'] . '</option>';
                }
              echo '
              </select>
            </div>
          </span>
          <span id="hideOther" style = "margin:0 0 0 5px;padding: 5px;background-color:#25cad3; color:#fff;line-height: 27px;border: 2px solid #fff;">Other</span>
          <span id="otherTrainingCategory" style="margin:0px; padding:0px;"><input type="text" name="trainingCategoriesOther" /></span>
        </td>
      </tr>
      <tr>
        <td><label class="text-info">Contact Person</label></td>
          <td><input type="text" class="form-control" name="contactName" value="' . $providerDetail['contactPerson'] . '"></td>  
        </tr>
        <tr>
          <td><label class="text-info">Email Address</label></td>
          <td><input type="text" class="form-control" name="email" value="' . $providerDetail['email'] . '"></td>
        </tr>
        <tr>
          <td><label class="text-info">Contact Number</label></td>
          <td><input type="text" class="form-control" name="contactNumber" value="' . $providerDetail['contactNumber'] . '"></td>
        </tr>
        <tr>
          <td><label class="text-info">Location</label></td>
          <td><input type="text" class="form-control" name="location" value="' . $providerDetail['location'] . '"> </td>
        </tr>
        <tr>
          <td><label class="text-info">Bank Details</label></td>
          <td><textarea name="bankDetails">' . $providerDetail['bankDetails'] . '</textarea></td>
        </tr>
        <tr>
          <td><label class="text-info">Accreditation</label></td>
          <td><input type="file" name="accreditaton"></td>
        </tr>
        <tr>
          <td><label class="text-info">Accreditation Expiry Date</label></td>
          <td><span id="profileDatePicker" style="margin:0px; padding:0px;">
              <input type="text" class="form-control" name="accreditatonExpire" id="datepicker" value="' . $providerDetail['StartDate'] . '">
              </span> 
          </td>
        </tr>';
        if(!empty($accredDocs)) {
          echo '
          <tr>
            <td></td>
            <td><strong>Current Accreditation Documents:</strong></td>
          </tr>';
          foreach($accredDocs as $accredDoc){
            echo '
            <tr>
              <td>&nbsp;</td>
              <td>' . $accredDoc['documentName'] . ' , ' . $accredDoc['expiaryDate'] . '</td>
            </tr>';
          }
          echo '
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>';
        }
        if(!empty($providerDetail['companyLogo'])) {
          echo '<tr>
                  <td>&nbsp;</td>
                  <td><img src="' . $providerDetail['companyLogo'] . '" /></td>
                </tr>';
        } 
        echo '
        <tr>
          <td><label class="text-info">Company Logo</label></td>
          <td><input type="file" name="companyLogo"></td>
        </tr>
        <tr>
          <td><label class="text-info">Website</label></td>
          <td><input type="text" class="form-control" name="companyWebsite" value="' . $providerDetail['website'] . '"></td>
        </tr>';
  }
?>
    <!--submit the form-->
    <tr>
      <td>&nbsp</td>
      <td><input type="submit" class="btn btn-primary" name="submit" value="Submit"></td>
    </tr>
  </form>
 </table>
</div>
</div>

<?php include '../footer.php'; ?>