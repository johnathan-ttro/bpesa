<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Profile';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$operatorDetailsSql = "SELECT users.userName, 
                              users.realName, 
                              userCompany, 
                              userCompanyProfile, 
                              userContactNumber, 
                              userWebsite,
                              operators.companyLogo
                              FROM users
                              INNER JOIN operators ON operators.userID = users.id
                              WHERE users.id = " . $_SESSION['userId'] . "";
$operatorDetails = $dbconnect->fetch($operatorDetailsSql);

$contactPersonSql = 'SELECT name, surName, contactNumber, email, date
                     FROM contact_person
                     WHERE userID = ' . $_SESSION['userId'];
$contactPersons = $dbconnect->fetch($contactPersonSql);

$regionNameDetailsSql = "SELECT regions.id,
                         regions.regionNames
                         FROM regions
                         INNER JOIN region_links ON regions.id = region_links.regionId
                         WHERE region_links.userId = " . $_SESSION['userId'] . " ";
$regionNameDetails = $dbconnect->fetch($regionNameDetailsSql);

$regionNamesSql = "SELECT id,regionNames FROM regions";
$regionNamesOptions = $dbconnect->fetch($regionNamesSql);

$providerProfileContentSql = "SELECT pageContent FROM providerpages WHERE pageUrl = '" . $currentpage . "'";
$providerProfileContent = $dbconnect->getone($providerProfileContentSql);
?>

<?php
  echo '<h1 class="page-title"><span class="current-page">Edi</span>t profile</h1>' . $providerProfileContent;
  foreach ($operatorDetails as $operatorDetail) {
   echo '
   <div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-12 col-xs-12">
      <form name="editOperatorForm" action="' . HOSTNAME . 'functions/operators_profile_save.php" method="post"enctype="multipart/form-data" onsubmit="return validateEditOperatorForm()" >
      <table class="table">
       <tr>
        <td><label class="text-info">UserName</label></td>
        <td><strong>' . $operatorDetail['userName'] . '</strong>
            <input type="hidden" name="userId"" value="' . $_SESSION['userId'] . '">
            <input type="hidden" name="originUrl" value="' . $currentpage . '">
        </td>
      </tr>
      <tr>
          <td><label class="text-info">Company name</label></td>
          <td><input type="text" class="form-control" name="companyName" value="' . $operatorDetail['userCompany'] . '"></td>
       </tr>';
if(!empty($operatorDetail['companyLogo'])) {
echo '<tr>
        <td>
        <input type="hidden" name="imageUrl" value="' . $operatorDetail['companyLogo'] . '">
        <img src="' . $operatorDetail['companyLogo'] . '" /></td>
        <td>&nbsp;</td>
      </tr>';
}else{
  echo '<tr>
        <td><img src="' . HOSTNAME . 'images/users.png" height="150px" />
            <input type="hidden" name="imageUrl" value="' . HOSTNAME . 'images/users.png" accept="image/*"></td>
        <td>&nbsp;</td>
      </tr>';
}
echo '<tr>
          <td><label class="text-info">Company logo</label></td>
          <td><label class="btn btn-primary btn-file">Browse <input type="file" id="profileImage" name="companyLogo" style="display: none;" accept="image/*"></label><span id="upload-file-info"></span>
          </td>
        </tr>  
      <tr>
        <td><label class="text-info">Company Profile</label></td>
        <td><textarea name="companyProfile">' . $operatorDetail['userCompanyProfile'] . '</textarea></td>
      </tr>
      <tr>
        <td><label class="text-info">Website</label></td>
        <td><input type="text" class="form-control" name="companyWebsite" value="' . $operatorDetail['userWebsite'] . '"></td>
      </tr>
      <tr>
      <td colspan="2">';
   
if(!empty($contactPersons)){
$i = 1;
foreach($contactPersons as $contactPerson){   
echo '
    <table class="table1">
       <tr>
          <th colspan="2"> ' . $i . '. Contact person</th>
       </tr>
       <tr>
          <td>Contact Person Name</td>
          <td>' . $contactPerson['name'] . '</td>
       </tr>
       <tr>
          <td>Contact Person Surname</td>
          <td>' . $contactPerson['surName'] . '</td>
        </tr>
       <tr>
          <td>Contact number</td>
          <td>' . $contactPerson['contactNumber'] . '</td>
        </tr>
        <tr>
          <td>Email Address</td>
          <td>' . $contactPerson['email'] . '</td>
        </tr>
     </table>
     <br/>';
     $i++;
 }
echo '
      </td>
    </tr>
     <tr>
        <td>&nbsp;</td>
        <td style = "margin:0;padding:20px;">
        <a href="' . HOSTNAME . 'operators/operators_add_contact_person.php?originUrl=' . $currentpage . '"><strong>Add/Delete contact user details</strong></a>
        </td>
    </tr>';
}else{
  echo '
      </td>
    </tr>
     <tr>
        <td>&nbsp;</td>
        <td>
        <a href="' . HOSTNAME . 'operators/operators_add_contact_person.php?originUrl=' . $currentpage . '"><strong>Add/Delete contact user details</strong></a>
        </td>
    </tr>';
}

echo   '<tr>
          <td><label class="text-info">Region/Location</label></td>
          <td valign="top">';
    if(!empty($regionNamesOptions)){
          foreach($regionNamesOptions as $regionNamesOption){
              
            echo '<input type="checkbox" name="regionNames[]" value="' . $regionNamesOption['id']. '"';
                foreach($regionNameDetails as $regionNameDetail){
                    if ($regionNamesOption['id'] == $regionNameDetail['id']){
                            echo ' checked = "checked" ';
                    }
                }
            echo '>  ' . $regionNamesOption['regionNames'] . '<br />';
         }
    }    

echo    '</td>
        </tr>';
}

?>
    <!--submit the form-->
    <tr>
      
      <td><span class="submit" style="margin:0px; padding:0px;">
            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
          </span>
      </td>
      <td>&nbsp</td>
    </tr>
  </form>
</table>
</div>
<div>
<?php include '../footer.php'; ?>