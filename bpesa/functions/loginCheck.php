<?php
//require_once '../config.php';
$userName = $_POST['userName'];
$password = $_POST['password'];
$originUrl = $_POST['originUrl'];

$loginChecker = login($userName, $password);

if($loginChecker) {
    //header( 'Location: http://localhost/BPeSA/index.php');
    header( 'Location: '  . HOSTNAME . 'home.php');
} else {
    header( 'Location: ' . HOSTNAME . 'login_fail.php');
}

function login($username, $password) {
require_once '../config.php';

$dbconnect = NEW DB_Class();

  $pageNamesQuery = "SELECT id, userName, realName, password, userType, userCompany FROM users WHERE username = '" . $username . "' AND password = '" . $password . "' AND active='Y'";
  $pageNames = $dbconnect->fetch($pageNamesQuery);
  if($pageNames) {
      $date = date('m/d/Y H:m:s');
      foreach($pageNames as $pageName) {
        $recordLogOnSql = 'INSERT INTO user_log (userId, loggedInDate) VALUES (' . $pageName['id'] . ',"' . $date . '")';
        $recordLogOn = $dbconnect->query($recordLogOnSql); 
        $updateLastLogonSql = 'UPDATE users SET lastLogIn="' . $date . '" WHERE id = ' . $pageName['id'];
        $updateLastLogon = $dbconnect->query($updateLastLogonSql);
        session_start();
        $_SESSION['userName'] = $pageName['userName'];
        $_SESSION['realName'] = $pageName['realName'];
        $_SESSION['userType'] = $pageName['userType'];
        $_SESSION['companyName'] = $pageName['userCompany'];
        $_SESSION['userId'] = $pageName['id'];
      }
      return true;
  
  } else {
      return false;
  }
}