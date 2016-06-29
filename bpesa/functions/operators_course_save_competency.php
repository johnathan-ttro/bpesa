<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

if(!empty($_POST)) {
$dbconnect = NEW DB_Class();

    $insertCompetencySql = 'INSERT INTO compentencies_link (competencyId, courseId) 
                            VALUES ("' .  $_POST['courseCompetency'] . '", "' . $_POST['courseId'] . '")';
    
    $insertCompetencySave = $dbconnect->query($insertCompetencySql);
    if($insertCompetencySave) {
       header( 'Location: '. HOSTNAME . 'operators/' . $_POST['originUrl'] . '.php?courseid=' . $_POST['courseId'] . '');
    }
} elseif(!empty($_GET)) {

    $dbconnect = NEW DB_Class();
    $deleteCompetencySql = 'DELETE FROM compentencies_link WHERE competencyId = ' . $_GET['competencyid'] . ' AND courseId = ' . $_GET['courseid'];
    
    $deleteCompetencySave = $dbconnect->query($deleteCompetencySql);
    if($deleteCompetencySave) {
       header( 'Location: '. HOSTNAME . 'operators/' . $_GET['currentPage'] . '.php?courseid=' . $_GET['courseid'] . '');
    }
} else {
  exit('no data');  
}
?>
