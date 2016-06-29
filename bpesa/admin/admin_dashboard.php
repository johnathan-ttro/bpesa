<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Dashboard';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

if(isset($_POST['submit'])) {
  $where = ' WHERE ';
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'Y'){
      $where .= ' active = "Y"';
  } 
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'N'){
      $where .= ' active = "N"';
  }
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'allActive'){
      $where .= ' active = "N" OR active = "Y"';
  }
  if(!empty($_POST['approvedFilter']) && $_POST['approvedFilter'] == 'Y'){
      $where .= ' AND approved = "Y"';
  }
  if(!empty($_POST['approvedFilter']) && $_POST['approvedFilter'] == 'N'){
      $where .= ' AND approved = "N"';
  }
  if(!empty($_POST['approvedFilter']) && $_POST['approvedFilter'] == 'approvedFilter') {
      $where .= ' AND approve = "N" OR approve = "Y"';
  }
}

$dbconnect = NEW DB_Class();

if(!empty($where)){
  $providerListSql = "SELECT id, companyName, contactPerson, email, active, userID, approved, badge FROM providers " . $where . "";
} else {
  $providerListSql = "SELECT id, companyName, contactPerson, email, active, userID, approved, badge FROM providers";
}
$providerLists = $dbconnect->fetch($providerListSql);

$providerPageContentSql = "SELECT pageContent FROM adminpages WHERE pageUrl = 'admin_dashboard'";
$providerPageContent = $dbconnect->getone($providerPageContentSql);
?>
<h1 class="page-title"><span class="current-page">Ad</span>min Dashboard</h1>
<?php
  echo $providerPageContent;
?>
Filter By:
<br />
<form action="admin_dashboard.php" method="post" id="dashBoardForm">
<div id = "selectDiv">
  <select name="activeFilter" form="dashBoardForm">
    <option value="allActive">All</option>
    <option value="Y">Active</option>
    <option value="N">Not Active</option>
  </select>
</div>
<br />
  <div id = "selectDiv">
  <select name="approvedFilter" form="dashBoardForm">
    <option value="allApproved">All</option>
    <option value="Y">Approved</option>
    <option value="N">Not Approved</option>
  </select>
</div>
  <br />
  <input class="btn btn-primary" type="submit" value="Filter Results" name="submit" />
</form>
<br />
<table class = "table1">
  <th>Company Name</th>
  <th>Contact Person</th>
  <th>Email</th>
  <th>Active</th>
  <th style = "color:#ffffff">Approved</th>
  <th>Course List</th>
  <!--PHP Loop with the providers list-->
  <?php
  foreach($providerLists as $providerList) {
      if($providerList['badge'] == "Y") {
          $companyName = '<span class="badge">' . $providerList['companyName'] . '</span> ';
          $style = ' style="height:60px;"';
      } else {
          $companyName = $providerList['companyName'];
          $style = false;
      }
      echo '<tr ' . $style . '>
              <td>' . $companyName . '</td>
              <td>' . $providerList['contactPerson'] . '</td>
              <td><a href="' . HOSTNAME . 'admin/admin_send_email.php?recipientId=' . $providerList['userID'] . '">' . $providerList['email'] . '</a></td>';
              if($providerList['active'] == "Y") {
                echo '<td style="text-align:center">
                        <a href="' . HOSTNAME . 'functions/provider_approve.php?providerId=' . $providerList['id']. '&originUrl=' . $currentpage . '&status=Y&procedure=active&userId=' . $providerList['userID'] .'">
                        <img src="' . HOSTNAME . 'images/tick.jpg" width=15px/></a>
                      </td>';                  
              } else {
                echo '<td style="text-align:center">
                       <a href="' . HOSTNAME . 'functions/provider_approve.php?providerId=' . $providerList['id']. '&originUrl=' . $currentpage . '&status=N&procedure=active&userId=' . $providerList['userID'] .'">
                       <img src="' . HOSTNAME . 'images/cross.jpg" width=15px/></a>
                      </td>';        
              }
              if($providerList['approved'] == "Y") {
                echo '<td style="text-align:center">
                        <a href="' . HOSTNAME . 'functions/provider_approve.php?providerId=' . $providerList['id']. '&originUrl=' . $currentpage . '&status=Y&procedure=approved&userId=' . $providerList['userID'] .'">
                        <img src="' . HOSTNAME . 'images/tick.jpg" width=15px/></a>
                      </td>';                  
              } else {
                echo '<td style="text-align:center">
                        <a href="' . HOSTNAME . 'functions/provider_approve.php?providerId=' . $providerList['id']. '&originUrl=' . $currentpage . '&status=N&procedure=approved&userId=' . $providerList['userID'] .'">
                        <img src="' . HOSTNAME . 'images/cross.jpg" width=15px/></a>
                      </td>';        
              }
              echo '<td>
                      <a href="admin_view_courses.php?providerId=' . $providerList['userID'] . '">Courses</a>
                    </td>
            </tr>';
  }
  ?>
</table>
<br>
<?php $here = HOSTNAME ; include ('../footer.php'); ?>