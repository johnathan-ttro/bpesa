<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Search';
require_once '../config.php';
require_once '../header.php';
//include_once '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$userSearchPageContentSql = "SELECT pageContent FROM userpages WHERE pageUrl = '" . $currentpage . "'";
$userSearchPageContent = $dbconnect->getone($userSearchPageContentSql);
// echo $userSearchPageContent;

$roleCriteriaListsSql = "SELECT id, roleName FROM course_roles ORDER BY roleName";
$roleCriteriaLists = $dbconnect->fetch($roleCriteriaListsSql);

$competencyCriteriaListsSql = "SELECT id, competencyName FROM compentencies ORDER BY competencyName";
$competencyCriteriaLists = $dbconnect->fetch($competencyCriteriaListsSql);


echo '<h1 class="page-title"><span class="current-page">Sea</span>rch</h1>';

echo '
<form name="searchForm" action="' . HOSTNAME . 'users/user_search_results.php" method="post" onsubmit="return validateSearchForm()">
<p class="text-info">Select your search requirements and click on search to filter results</p>
<br />
<table class="table1">
  <th>Competencies</th>
  <th>Roles</th>
  <tr>
    <td>
      <!--competencey Search-->';
      foreach($competencyCriteriaLists as $competencyCriteriaList){
      echo '
        <input type="checkbox" name="competencyName[]" value="' . $competencyCriteriaList['id'] . '"> ' . $competencyCriteriaList['competencyName'] . '<br />';
      } 
      echo '
    </td>
    <td valign="top">';
      foreach($roleCriteriaLists as $roleCriteriaList) {
        echo '
        <input type="checkbox" name="roleName[]" value="' . $roleCriteriaList['id'] . '"> ' . $roleCriteriaList['roleName'] . '<br />';  
      }
    echo '
    </td>
  </tr>
  </table>
  <br>
  <input type="submit" name="submit" class="btn btn-primary" value="Search">
  </form>
  <br>';

include '../footer.php';
?>
