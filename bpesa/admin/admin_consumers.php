<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Users';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

if(isset($_POST['submit'])) {
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'Y'){
      $where .= ' AND active = "Y"';
  }
  if(!empty($_POST['activeFilter']) && $_POST['activeFilter'] == 'N'){
      $where .= ' AND active = "N"';
  }
}

if(!empty($where)){
  $consumerListSql = "SELECT id, realName, userEmail, active, userContactNumber, lastLogin FROM users WHERE userType='users'" . $where;
} else {
  $consumerListSql = "SELECT id, realName, userEmail, active, userContactNumber, lastLogin FROM users WHERE userType='users'";
}

$consumerLists = $dbconnect->fetch($consumerListSql);

$consumerPageContentSql = "SELECT pageContent FROM adminpages WHERE pageUrl = 'admin_consumers'";
$consumerPageContents = $dbconnect->getone($consumerPageContentSql);
?>

<?php
  echo '<h1 class="page-title"><span class="current-page">Use</span>rs</h1>' . $consumerPageContents;
?>

<!--Filter the active or non active users-->
<form action="admin_consumers.php" method="post" id="dashBoardForm"> 
<div id = "selectDiv">
  <select name="activeFilter" form="dashBoardForm">
    <option value="allActive">All</option>
    <option value="Y">Active</option>
    <option value="N">Not Active</option>
  </select>
</div>
<br />
<input class="btn btn-primary" type="submit" value="Filter Results" name="submit">
</form>
<br />

<!--display user list-->
<table class = "table1">
  <th>Consumer Name</th>
  <th>Email</th>
  <th>Contact</th>
  <th>Active</th>
  <th>Last Login</th>
  <!--PHP Loop with the providers list-->
  <?php
  foreach($consumerLists as $consumerList) {
      echo '<tr>
              <td>' . $consumerList['realName'] . '</td>
              <td><a href="' . HOSTNAME . 'admin" >' . $consumerList['userEmail'] . '</a></td>
              <td>' . $consumerList['userContactNumber'] . '</td>    
              <td  style="text-align:center">';
              if($consumerList['active'] == 'Y') {
                echo '
                <a href="' . HOSTNAME .'functions/user_approve.php?userId=' . $consumerList['id'] . '&originUrl=' . $currentpage . '&active=Y">
                  <img src="' . HOSTNAME . 'images/tick.jpg" width=15px/>
                </a>';
              }
              if($consumerList['active'] == 'N') {
                echo '
                <a href="' . HOSTNAME .'functions/user_approve.php?userId=' . $consumerList['id'] . '&originUrl=' . $currentpage . '&active=N">
                  <img src="' . HOSTNAME . 'images/cross.jpg" width=15px/>
                </a>';
              }
              $consumerList = strtotime($consumerList['lastLogin']);
              $LastLogin = date("d/m/Y H:i:s A", $consumerList);
              echo'
              </td>
              <td>' . $LastLogin . '</td> 
            </tr>';
  }
  ?>
</table>
<br>

<?php $here = HOSTNAME ; include ('../footer.php'); ?>
