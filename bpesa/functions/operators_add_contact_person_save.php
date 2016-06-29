<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

$date = date('m/d/Y H:m:s');

if(!empty($_POST)) {

$dbconnect = NEW DB_Class();
    
$insertNewContactPersonSql = "INSERT INTO contact_person(
                                             userID,
                                             name,
                                             surName,
                                             contactNumber,
                                             email,
                                             date)
                                             VALUES (
                                             '" . $_POST['userId'] . "',
                                             '" . $_POST['name'] . "',
                                             '" . $_POST['surName'] . "',
                                             '" . $_POST['contactNumber'] . "',
                                             '" . $_POST['email'] . "',
                                             '" . $date . "')";
       
    $insertNewContactPerson = $dbconnect->query($insertNewContactPersonSql);
    if($insertNewContactPerson) {
       header( 'Location: '. HOSTNAME . 'operators/' . $_POST['originUrl'] . '.php');
    }
} elseif(!empty($_GET)) {
    $dbconnect = NEW DB_Class();

    $deleteContactPersonSql = 'DELETE FROM contact_person WHERE id = ' . $_GET['id'] . ' AND userID = ' . $_GET['userId'];
    
    $deleteContactPersonSave = $dbconnect->query($deleteContactPersonSql);
    if($deleteContactPersonSave) {
       header( 'Location: '. HOSTNAME . 'operators/' . $_GET['orginUrl'] . '.php');
    }
} else {
  exit('no data');  
}
?>
