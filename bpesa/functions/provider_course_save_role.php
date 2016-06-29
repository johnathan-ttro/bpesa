<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

if(!empty($_POST)) {

    $dbconnect = NEW DB_Class();
    $insertRoleSql = 'INSERT INTO  course_roles_link (roleId, courseId) 
                            VALUES ("' .  $_POST['roleCompetency'] . '", "' . $_POST['courseId'] . '")';
    
    $insertRoleSave = $dbconnect->query($insertRoleSql);
    if($insertRoleSave) {
       header( 'Location: '. HOSTNAME . 'providers/' . $_POST['originUrl'] . '.php?courseid=' . $_POST['courseId'] . '');
    }
} elseif(!empty($_GET)) {

  $dbconnect = NEW DB_Class();
  $deleteRoleSql = 'DELETE FROM course_roles_link WHERE roleId = ' . $_GET['roleid'] . ' AND courseId = ' . $_GET['courseid'];
    
    $deleteRoleSave = $dbconnect->query($deleteRoleSql);
    if($deleteRoleSave) {
       header( 'Location: '. HOSTNAME . 'providers/' . $_GET['currentPage'] . '.php?courseid=' . $_GET['courseid'] . '');
    }
} else {
  exit('no data');  
}
?>