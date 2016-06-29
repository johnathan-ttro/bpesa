<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Add Role';
require_once '../config.php';
require_once '../header.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$dbconnect = NEW DB_Class();

$courseRoleListSql = "SELECT 
                      course_roles.id, 
                      course_roles.roleName 
                      FROM course_roles 
                      INNER JOIN course_roles_link ON course_roles.id = course_roles_link.roleId 
                      WHERE course_roles_link.courseid = " . $_GET['courseid'];

$courseRoles = $dbconnect->fetch($courseRoleListSql);
$rolesToExclude = '';
foreach($courseRoles as $courseRole) {
    $rolesToExclude .= $courseRole['id'] . ',';
}

$rolesToExclude = rtrim($rolesToExclude, ",");
if($rolesToExclude != '') {
  $roleListSql = "SELECT id, roleName FROM course_roles WHERE id NOT IN(" . $rolesToExclude . ")";
} else {
  $roleListSql = "SELECT id, roleName FROM course_roles"; 
}

$roleLists = $dbconnect->fetch($roleListSql);

echo '
 <h1 class="page-title"><span class="current-page">Cou</span>rse Roles</h1>
    <table class="table1">
    <tr>
      <th>Role</th>
      <th>Remove Role</th>
    </tr>';
  if(!empty($courseRoles)){

    foreach($courseRoles as $courseRoles) {
    echo '
      <tr>
        <td>' . $courseRoles['roleName'] . '</td>
        <td>
          <a href="' . HOSTNAME . 'functions/provider_course_save_role.php?roleid=' . $courseRoles['id'] . '&courseid=' . $_GET['courseid'] .'&currentPage=' . $currentpage . '">
            <img src=' . HOSTNAME . 'images/cross.jpg width=15px />
          </a>
         </td>
      </tr>';
    }

  }else{
    echo '<tr><td colspan="2">There is currently no roles</td></tr>';
  }
echo '</table>';
?>
<br />
Add a Role:
<br />
<form action="<?php echo HOSTNAME . 'functions/provider_course_save_role.php'; ?>" method="post">
  <input type="hidden" name="courseId" value="<?php echo $_GET['courseid'] ?>" />
  <input type="hidden" name="originUrl" value="<?php echo $currentpage ?>" />
  <div id = "selectDiv">
    <select name="roleCompetency">
    <?php
    foreach($roleLists as $roleList) {
      echo '<option value="' . $roleList['id'] . '">' . $roleList['roleName'] . '</option>';
    }
    ?>
    </select>
  </div>
  <br />
  <input type="submit" class="btn btn-primary" name="submit" value="Add Role" />
</form>
<br/>
<form action="<?php echo HOSTNAME . 'providers/providers_courses.php'; ?>" method="post">
<input type="submit" class="btn btn-primary" name="submit" value="Back" />
</form>
<br/>
<?php include '../footer.php'; ?>