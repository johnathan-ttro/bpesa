<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Add Competency';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

//calendar login
$dbconnect = NEW DB_Class();

$courseCompetencyListSql = "SELECT 
                            compentencies.id, 
                            compentencies.competencyName 
                            FROM compentencies 
                            INNER JOIN compentencies_link ON compentencies.id = compentencies_link.competencyId 
                            WHERE compentencies_link.courseid = " . $_GET['courseid'];
$courseLists = $dbconnect->fetch($courseCompetencyListSql);
$competencyToExclude = '';
foreach($courseLists as $courseList) {
  $competencyToExclude.=  $courseList['id'] . ',';
}
$competencyToExclude = rtrim($competencyToExclude, ",");

if($competencyToExclude != '') {
  $competencyListSql = "SELECT id, competencyName FROM compentencies WHERE id NOT IN (" . $competencyToExclude . ")";
} else {
  $competencyListSql = "SELECT id, competencyName FROM compentencies";  
}
$competencyLists = $dbconnect->fetch($competencyListSql);

echo '
<h1 class="page-title"><span class="current-page">Cou</span>rse Competency</h1>
    <table class="table1">
    <tr>
      <th>Competency</th>
      <th>Remove Competency</th>
    </tr>';
  if(!empty($courseLists)){
  foreach($courseLists as $courseList) {
      echo '
        <tr>
          <td>' . $courseList['competencyName'] . '</td>
          <td>
            <a href="' . HOSTNAME . 'functions/provider_course_save_competency.php?competencyid=' . $courseList['id'] . '&courseid=' . $_GET['courseid'] .'&currentPage=' . $currentpage . '">
              <img src=' . HOSTNAME . 'images/cross.jpg width=15px />
            </a>
           </td>
        </tr>';
  }
}else{
    echo '<tr><td colspan="2">There is currently no competency</td></tr>';
  }
echo '</table>';
?>
<br />
Add a competency:
<br />
<form action="<?php echo HOSTNAME . 'functions/provider_course_save_competency.php'; ?>" method="post">
  <input type="hidden" name="courseId" value="<?php echo $_GET['courseid'] ?>" />
  <input type="hidden" name="originUrl" value="<?php echo $currentpage ?>" />
  <div id = "selectDiv">
    <select name="courseCompetency">
    <?php
    foreach($competencyLists as $competencyList) {
      echo '<option value="' . $competencyList['id'] . '">' . $competencyList['competencyName'] . '</option>';
    }
    ?>
    </select>
  </div>
  <br />
  <input type="submit" name="submit" class="btn btn-primary" value="Add" />
</form>
<br/>
<form action="<?php echo HOSTNAME . 'providers/providers_courses.php'; ?>" method="post">
<input type="submit" class="btn btn-primary" name="submit" value="Back" />
</form>
<br/>
<?php include '../footer.php'; ?>