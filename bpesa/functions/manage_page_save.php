<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$currentPage = $_POST['originUrl'];

if(!empty($_POST)) {

$dbconnect = NEW DB_Class();

    $contentPage = strip_word_html($_POST['pageContent'], '<b><i><sup><sub><em><strong><u><br><br /><p></p>');
    if($_POST['pageType'] == 'admin') {
      $updatepagesSql = 'UPDATE adminpages SET pageName="' . $_POST['pageName'] . '", pageContent="' . mysql_real_escape_string($contentPage) . '"
                         WHERE id="' . $_POST['pageId'] . '"';
    }
    if($_POST['pageType'] == 'providers') {
      $updatepagesSql = 'UPDATE providerpages SET pageName="' . $_POST['pageName'] . '", pageContent="' . mysql_real_escape_string($contentPage) . '"
                         WHERE id="' . $_POST['pageId'] . '"';
    }
    if($_POST['pageType'] == 'users') {
      $updatepagesSql = 'UPDATE userpages SET pageName="' . $_POST['pageName'] . '", pageContent="' . mysql_real_escape_string($contentPage) . '"
                         WHERE id="' . $_POST['pageId'] . '"';
    }
    
    if($_POST['pageType'] == 'operators') {
      $updatepagesSql = 'UPDATE operatorpages SET pageName="' . $_POST['pageName'] . '", pageContent="' . mysql_real_escape_string($contentPage) . '"
                         WHERE id="' . $_POST['pageId'] . '"';
    }
    
    $updatepagesSave = $dbconnect->query($updatepagesSql);
    if($updatepagesSave) {
       header( 'Location: '. $currentPage);
    }
} else {
     exit('no posted data');
}
?>
