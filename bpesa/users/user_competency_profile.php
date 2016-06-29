<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Competency';
require_once '../config.php';
require_once '../header.php';
//include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$compentencyProfileContentSql = "SELECT pageContent FROM userpages WHERE pageUrl = '" . $currentpage . "'";
$compentencyProfileContent = $dbconnect->getone($compentencyProfileContentSql);

echo '
<h1 class="page-title"><span class="current-page">Com</span>petency</h1>
    <p class="text-info">Please select the relevant competency profile</h1>

    <div class="row">
    <div class="col-lg-6">
      <div class="btn comp_btn"><a href="' . HOSTNAME . 'users/user_competency_profile_page.php?page=agent">Agent Competency<img src="' . HOSTNAME . 'images/arrow.png" class="arrow"></a></div>
      <div class="btn comp_btn"><a href="' . HOSTNAME . 'users/user_competency_profile_page.php?page=team">Team Leader Information Competency<img src="' . HOSTNAME . 'images/arrow.png" class="arrow"></a></div>
      <div class="btn comp_btn"><a href="' . HOSTNAME . 'users/user_competency_profile_page.php?page=quality">Quality Assurance Competency <img src="' . HOSTNAME . 'images/arrow.png" class="arrow"></a></div>
      <div class="btn comp_btn"><a href="' . HOSTNAME . 'users/user_competency_profile_page.php?page=workforce">Workforce Manager Competency <img src="' . HOSTNAME . 'images/arrow.png" class="arrow"></a></div>
    </div>

    <div class="col-lg-6">
      <div class="btn comp_btn"><a href="' . HOSTNAME . 'users/user_competency_profile_page.php?page=coach">Course Competency <img src="' . HOSTNAME . 'images/arrow.png" class="arrow"></a></div>
      <div class="btn comp_btn"><a href="' . HOSTNAME . 'users/user_competency_profile_page.php?page=management">Management Information Competency <img src="' . HOSTNAME . 'images/arrow.png" class="arrow"></a></div>
      <div class="btn comp_btn"><a href="' . HOSTNAME . 'users/user_competency_profile_page.php?page=trainer">Trainer Competency <img src="' . HOSTNAME . 'images/arrow.png" class="arrow"></a></div>
    </div>
  </div>';

include_once '../footer.php';
?>
