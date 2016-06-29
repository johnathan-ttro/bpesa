<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Profile';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$contactPersonSql = 'SELECT id, name, surName, contactNumber, email, date
                     FROM contact_person
                     WHERE userID = ' . $_SESSION['userId'] . ' ORDER BY date LIMIT 3';
$contactPersons = $dbconnect->fetch($contactPersonSql);
echo '<h1 class="page-title"><span class="current-page">Con</span>tact person</h1>';
if(!empty($contactPersons)){    
    $i = 1;
    echo '
    <table class="table1" width="50%">';
    foreach($contactPersons as $contactPerson){   
    echo '
       <tr>
          <th colspan="2"> ' . $i . '. Contact person details</th>
       </tr>
       <tr>
          <td>Name</td>
          <td>' . $contactPerson['name'] . '</td>
        </tr>
        <tr>
          <td>Surname</td>
          <td>' . $contactPerson['surName'] . '</td>
        </tr>
       <tr>
          <td>Contact number</td>
          <td>' . $contactPerson['contactNumber'] . '</td>
        </tr>
        <tr>
          <td>Email Address</td>
          <td>' . $contactPerson['email'] . '</td>
        </tr>';
      if($i > 1){
      echo   '<tr>
                <td colspan="2">
                 <a href="' . HOSTNAME . 'functions/operators_add_contact_person_save.php?orginUrl=' . $currentpage . '&id=' . $contactPerson['id'] . '&userId=' . $_SESSION['userId'] . '">
      		   <img src="' . HOSTNAME . 'images/cross.jpg" width="15px">
      		   </a>
                </td>
             </tr>';
      }
    $i++;
   }
  echo '</table>'; 
}

echo '
    <div id="showFormButton"><h2><span class="selectors">Add Contact Person</span></h2></div>
    <div id="showContactForm" style="display:none;" class="container">
    <form action="' . HOSTNAME . 'functions/operators_add_contact_person_save.php" method="post" name="addContactForm" onsubmit="return validateAddContactForm()">
    <table class="table">
        <tr>
          <td><label class="text-info">Name</label></td>
          <td><input type="text" class="form-control" name="name"></td>
        </tr>
        <tr>
          <td><label class="text-info">Surname</label></td>
          <td><input type="text" class="form-control" name="surName"></td>
        </tr>
       <tr>
          <td><label class="text-info">Contact number</label></td>
          <td><input type="text" class="form-control" name="contactNumber"></td>
        </tr>
        <tr>
          <td><label class="text-info">Email Address</label></td>
          <td><input type="text" class="form-control" name="email"></td>
        </tr>
        <tr>
            <td>
            <input type="submit" name="submit" class="btn btn-primary" value="Add">
            <input type="hidden" name="originUrl" value="' . $currentpage . '">
            <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '">
            </td>
        </tr>
     </table>
    </form>
	</div>
<a href="' . HOSTNAME . 'operators/operators_profile.php"><strong>Back</strong></a>  
';
    
include '../footer.php'; ?>