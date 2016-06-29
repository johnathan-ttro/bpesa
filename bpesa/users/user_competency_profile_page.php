<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Competency';
require_once '../config.php';
require_once '../header.php';
//include '../sessionTest.php';


$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$competencyCriteriaListsSql = "SELECT id, competencyName FROM compentencies ORDER BY competencyName";
$competencyCriteriaLists = $dbconnect->fetch($competencyCriteriaListsSql);

if($_GET['page']=='agent') {  
  echo '
  <h1 class="page-title"><span class="current-page">Com</span>petency - Agent Competency Profile</h1>';
}
if($_GET['page']=='team') {
   echo '<h1 class="page-title"><span class="current-page">Com</span>petency - Team Leader Competency Profile</h1>';
}
if($_GET['page']=='quality') {
  echo '<h1 class="page-title"><span class="current-page">Com</span>petency - Quality Assurance Competency Profile</h1>';
}
if($_GET['page']=='workforce') {
  echo '<h1 class="page-title"><span class="current-page">Com</span>petency - Workforce Manager Competency Profile</h1>';
}
if($_GET['page']=='coach') {
  echo '<h1 class="page-title"><span class="current-page">Com</span>petency - Coach Competency Profile</h1>';
}
if($_GET['page']=='management') {
  echo '<h1 class="page-title"><span class="current-page">Com</span>petency - Management Information Competency Profile</h1>';
}
if($_GET['page']=='trainer') {
  echo '<h1 class="page-title"><span class="current-page">Com</span>petency - Trainer Competency Profile</h1>';
}

echo '
<form action="' . HOSTNAME . 'users/user_search_results.php" method="post">
  <table class="table1">
  <tr>
    <td><input type="submit" name="submit"  class="btn btn-primary" value="Search"></td>
  </tr>
  <tr>
    <td>';
  foreach($competencyCriteriaLists as $competencyCriteriaList){
   echo '
   <input type="checkbox" name="competencyName[]" value="' . $competencyCriteriaList['id'] . '"> ' . $competencyCriteriaList['competencyName'] . ' <br />';
   }
echo '
    </td>
  </tr>
  <tr>
    <td><input type="submit" name="submit"  class="btn btn-primary" value="Search"></td>
  </tr>
  </table>
  </form>
  <br/>';

include_once '../footer.php';
?>