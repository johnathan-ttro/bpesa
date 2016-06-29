<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$trainingCategorySql = "SELECT id,categoryName FROM training_categories";
$trainingCatergoryOptions = $dbconnect->fetch($trainingCategorySql);

  echo '
  <form action="' . HOSTNAME . 'functions/provider_new_provider_form_save.php" method="post" enctype="multipart/form-data" id="providerFrom" name="providerFrom" onsubmit="return validateForm3()" >
    <table class="table"> 
      <tr>
        <td>User Name</td>
        <td>
          <span class="first" style = "margin:0;padding:0;">
            <input class="text" type="text" name="userName"/>
          </span>
        </td>
        <input type="hidden" name="originUrl" />
      </tr>
      <tr>
        <td style = "padding-right:100px;">Password</td>
        <td><input class = "text" type="password" name="password"/></td>
      </tr>
      <tr>
        <td>Company Name</td>
        <td><input class = "text" type="text" name="companyName"/></td>
      </tr>
      <tr>
        <td>Training Category</td>
        <td style = "padding-bottom:8px;">
          <span id="hideSelectOption" style = "margin:0;padding:5px;">
            <div id = "selectDiv" style = "float:left;">
              <select name="trainingCategories">
                <option value="other">
                  Please Select
                </option>';
                foreach($trainingCatergoryOptions as $trainingCatergoryOption) {
                  echo '<option value="' . $trainingCatergoryOption['id'] . '">' . $trainingCatergoryOption['categoryName'] . '</option>';
                }
              echo '
              </select>
            </div>
          </span>
          <a href= "#hideOther"><span id="hideOther" style = "margin:0;padding: 6px;background-color: #ccc;color: #fff;line-height: 31px;border: 2px solid #999;" >
            Other
          </span></a>
          <span id="otherTrainingCategory" style = "margin:0;padding:0;" >
            <input class = "text" type="text" name="trainingCategoriesOther" />
          </span>
        </td>
      </tr>
      <tr>
        <td>Contact Person</td>
        <td><input class = "text" type="text" name="contactName"></td>
      </tr>
      <tr>
        <td>Email Address</td>
        <td><input class = "text" type="text" name="email"></td>
      </tr>
      <tr>
        <td>Contact Number</td>
        <td><input class = "text" type="text" name="contactNumber"></td>
      </tr>
      <tr>
        <td>Location</td>
        <td>
		  <input class = "text" type="text" name="location">
		</td>
      </tr>
      <!--<tr>
        <td>Bank Details</td>
        <td><textarea name="bankDetails"></textarea></td>
      </tr>-->
      <tr>
        <td>Accreditation</td>
        <td style = "padding: 10px 0px;" ><input  type="file" name="accreditaton">
		 <div class="hover" style="left:228px; top:-23px;"><img src="' . HOSTNAME . 'images/icon.png">
             <div class="tooltip">If you need to load more than 1 document, you can add more once your profile has been approved.<br />
			             Alternatively, multiple documents can be scanned into one file and uploaded.</div>
           </div>
		</td>
      </tr>
      <tr>
        <td style = "padding: 0px 0px;" >Accreditation expiry date</td>
        <td style = "padding: 0px 0px;" >
          <span id="profileDatePicker" style = "margin:0;padding:0;" >
            <input type="text" name="accreditatonExpire" id="datepicker" >
			
          </span>
		  <div class="hover" style="left:228px; top:-35px;"><img src="' . HOSTNAME . 'images/icon.png">
             <div class="tooltip">The expiry date is the date when the accreditation expires.</div>
           </div>
        </td>
      </tr>
      <tr>
        <td>Company Logo</td>
        <td style = "padding: 10px 0px;"><input type="file" name="companyLogo">
		  <div class="hover" style="left:228px; top:-23px;"><img src="' . HOSTNAME . 'images/icon.png">
             <div class="tooltip">The logo for your company that the user will see on your profile.</div>
           </div></td>
      </tr>
      <tr>
        <td>Company Profile</td>
        <td><textarea name="companyProfile"></textarea></td>
      </tr>
      <tr>
        <td>Website</td>
        <td><input type="text" name="companyWebsite"></td>
      </tr>';

  ?>
    <!--submit the form-->
    <tr>
      <td>&nbsp;</td>
      <td>
        <span class="submit" style = "margin:0;padding:0;">
          <input type="submit" class="submit" name="submit" value="Submit" />
        </span>
      </td>
    </tr>
  </form>
</table>
<?php $here = HOSTNAME ; include ('../footer.php'); ?>