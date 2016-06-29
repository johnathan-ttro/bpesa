<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Vendor List';
require_once '../config.php';
require_once '../header.php';

$getVendorListsSql = 'SELECT vendorName, vendorEmail, vendorTel, vendorLocation, vendorAddress, vendorCapacity
                      FROM vendors';

$getVendorLists = $dbconnect->fetch($getVendorListsSql);

 echo '
  <h1 class="page-title"><span class="current-page">Facil</span>ities provider</h1>
  <br/>
  <table class="table1">
    <th>Venue Name</th>
    <th>Email</th>
    <th>Telephone</th>
    <th>Location</th>
    <th>Address</th>
    <th>Capacity</th>';
	
if($getVendorLists) {
 
  foreach($getVendorLists as $getVendorList) {
    echo '
      <tr>
        <td>' . $getVendorList['vendorName'] . '</td>
        <td>' . $getVendorList['vendorEmail'] . '</td>
        <td>' . $getVendorList['vendorTel'] . '</td>
        <td>' . $getVendorList['vendorLocation'] . '</td>
        <td>' . $getVendorList['vendorAddress'] . '</td>
        <td style="text-align:center">' . $getVendorList['vendorCapacity'] . '</td>
      </tr>';
  }
}else{
	echo '<tr><td colspan="6">There is currently no facility</td></tr>';
}
echo '
</table>
<br>
<a href="' . HOSTNAME . 'admin/admin_reports.php"><strong>Back</strong></a>
<br>';
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
                                 ->setSubject("BPeSA Vendor List")
                                 ->setDescription("A list of users on th BPeSA Skills Portal")
                                 ->setKeywords("User List")
                                 ->setCategory("User List");
  
    //first, insert the record count
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'RecordCount');
                

    //set headings

    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'Vendor Name')
                ->setCellValue('B2', 'Email')
                ->setCellValue('C2', 'Telephone')
                ->setCellValue('D2', 'Location')
                ->setCellValue('E2', 'Address')
                ->setCellValue('F2', 'Capacity');
    //begin to loop through the Users Object
    $count = 3;
    $counter = 0;

    foreach($getVendorLists as $getVendorList) {
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $count, $getVendorList['vendorName']); 	
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $count, $getVendorList['vendorEmail']); 
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $count, $getVendorList['vendorTel']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $count, $getVendorList['vendorLocation']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $count, $getVendorList['vendorAddress']);
      $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $count, $getVendorList['vendorCapacity']); 
      $count++;
      $counter++;
    }
    $objPHPExcel->getActiveSheet()->setTitle('CPD Report');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $counter);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(HOSTNAME . 'reports/temp_reports/excelReport.xls');
$objWriter->save('../reports/temp_reports/vendorList.xls');

echo '
  <br />
  <a href="' . HOSTNAME . 'reports/temp_reports/vendorList.xls">Click to download this report.</a>
  <br />
  <br />';

include '../footer.php';
?>
