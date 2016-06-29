<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - User access history';
require_once '../config.php';
require_once '../header.php';

if(isset($_POST['submit'])) {
  if(empty($_POST['userFilter']) && empty($_POST['userActive'])){
    $userListsSql = "SELECT id, realName, userType, userCompany, userEmail FROM users"; 
  } 
  if(!empty($_POST['userFilter']) && empty($_POST['userActive'])){
      $where .= ' WHERE userType= "' . $_POST['userFilter'] . '"';
  }
  if(empty($_POST['userFilter']) && !empty($_POST['userActive'])){
      $where .= ' WHERE active= "' . $_POST['userActive'] . '"';
  }
   if(!empty($_POST['userFilter']) && !empty($_POST['userActive'])){
      $where .= ' WHERE userType= "' . $_POST['userFilter'] . '" AND active= "' . $_POST['userActive'] . '"';
  } 
 
  $userListsSql = "SELECT id, realName, userType, userCompany, userEmail FROM users" . $where;
} else {
 $userListsSql = "SELECT id, realName, userType, userCompany, userEmail FROM users";
}
$userLists = $dbconnect->fetch($userListsSql);

echo '
  <h1 class="page-title"><span class="current-page">User Acc</span>ess History</h1>
  <br />
  <form action="#" method="post">
    <div id="selectDiv">
    <select name="userFilter">
      <option value="">No Filter</option>
      <option value="provider">Providers</option>
      <option value="users">Users</option>
      <option value="thirdParty">3rd Party Providers</option>
    </select>
    </div>
    <br />
    <div id="selectDiv">
    <select name="userActive">
      <option value="">All Users</option>
      <option value="Y">Active Users</option>
      <option value="N">Dormant Users</option>
    </select>
    </div>
    <br />
    <input type="submit" class="btn btn-primary" value="Filter Users" name="submit">
  </form>
  <br />

  <table class="table1">
    <th>User Name</th>
    <th>User Type</th>
    <th>Company</th>
    <th>Email Address</th>
    <th>Access History</th>';
foreach($userLists as $userList){
  echo '
  <tr>
    <td>' . $userList['realName'] . '</td>
    <td>' . $userList['userType'] . '</td>
    <td>' . $userList['userCompany'] . '</td>
    <td><a href="' . HOSTNAME . 'admin/admin_send_email.php?recipientId=' . $userList['id'] . '">' . $userList['userEmail'] . '</a></td>
    <td><a href="' . HOSTNAME . 'reports/reports_user_access.php?userId=' . $userList['id'] . '">Access History</a></td>
  </tr>';
}
echo '</table>';

//save to Excel
//if($saveExcel == true) {
    require_once '../functions/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

    // Set properties
    $objPHPExcel->getProperties()->setCreator("BPeSA reporting System")
                                 ->setLastModifiedBy("System")
                                 ->setTitle("BPeSA") //perhaps add date range here
                                 ->setSubject("BPeSA User List")
                                 ->setDescription("A list of users on th BPeSA Skills Portal")
                                 ->setKeywords("User List")
                                 ->setCategory("User List");
  
    //first, insert the record count
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'RecordCount');
                

    //set headings

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'User Name')
                ->setCellValue('B2', 'User Type')
                ->setCellValue('C2', 'Company')
                ->setCellValue('D2', 'Email Address');
    //begin to loop through the Users Object
    $count = 3;
    $counter = 0;

    foreach($userLists as $userList) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $count, $userList['realName']); 	
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $userList['userType']); 
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $count, $userList['userCompany']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $count, $userList['userEmail']); 
      $count++;
      $counter++;
    }
    $objPHPExcel->getActiveSheet()->setTitle('CPD Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $counter);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(HOSTNAME . 'reports/temp_reports/excelReport.xls');
$objWriter->save('../reports/temp_reports/excelReport.xls');

echo '
  <br />
  <a href="' . HOSTNAME . 'reports/temp_reports/excelReport.xls">Click to download this report.</a>
  <br />
  <a href="' . HOSTNAME . 'admin/admin_reports.php"><strong>Back</strong></a>
  <br />
  <br />';
include '../footer.php';
?>
