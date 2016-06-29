<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Search results';
require_once '../config.php';
require_once '../header.php';

$dbconnect = NEW DB_Class();

if(!empty($_POST['competencyName']) || !empty($_POST['roleName'])) {
  $compentencySearchLists = $_POST['competencyName'];
  $roleSearchLists = $_POST['roleName'];
  
  if(!empty($_POST['competencyName'])) {
    $compentencyList = '';
    foreach($compentencySearchLists as $compentencySearchList) {
      $compentencyList.= $compentencySearchList . ',';
    }
    $compentencyList = rtrim($compentencyList, ",");
  }

  if(!empty($_POST['roleName'])) {
    $roleList = '';
    foreach($roleSearchLists as $roleSearchList) {
      $roleList.= $roleSearchList;
    }
    $roleList = rtrim($roleList, ",");
  }
  //Choose the sql query based on what was posted by the user.  Competency or roles or both
  //Competency Search
  if(!empty($_POST['competencyName']) && empty($_POST['roleName'])) {
    $searchResultsSql = "SELECT 
                         courses.id, 
                         courses.courseName,
                         providers.companyName,
                         courses.providerId
                         FROM courses
                         INNER JOIN compentencies_link ON courses.id = compentencies_link.courseId
                         INNER JOIN providers ON courses.providerId = providers.userID
		                     WHERE compentencies_link.competencyId IN ('" . $compentencyList . "')
                         AND courses.status = 'Y'
                         AND courses.venueBooked='Y'
                         AND courses.archived != 'Y'";                
  } 
  //Both Searches have values
  if(!empty($_POST['competencyName']) && !empty($_POST['roleName'])) {
    $searchResultsSql = "SELECT 
                         DISTINCT
                         courses.id, 
                         courses.courseName,
                         providers.companyName,
                         courses.providerId
                         FROM courses
                         INNER JOIN course_roles_link ON courses.id = course_roles_link.courseId
                         INNER JOIN compentencies_link ON courses.id = compentencies_link.courseId
                         INNER JOIN providers ON courses.providerId = providers.userID
		                     WHERE course_roles_link.roleId IN ('" . $roleList . "')
                         OR compentencies_link.competencyId IN ('" . $compentencyList . "')
                         AND courses.status = 'Y'
                         AND courses.venueBooked='Y'
                         AND courses.archived != 'Y' ";                
  }
  //Role Search
  if(empty($_POST['competencyName']) && !empty($_POST['roleName'])) {

    $searchResultsSql = "SELECT 
                         courses.id, 
                         courses.courseName,
                         providers.companyName,
                         courses.providerId
                         FROM courses
                         INNER JOIN course_roles_link ON courses.id = course_roles_link.courseId
                         INNER JOIN providers ON courses.providerId = providers.userID
		                     WHERE course_roles_link.roleId IN (" . $roleList . ")
                         AND courses.status = 'Y'
                         AND courses.venueBooked='Y'
                         AND courses.archived != 'Y'";    
  }

$searchResults = $dbconnect->fetch($searchResultsSql);


  echo '
  <h1 class="page-title"><span class="current-page">Sea</span>rch</h1>';
    if($searchResults) {
      echo '
      <table class="table1">
        <th>Course</th>
        <th>Offered By Company</th>';
        foreach($searchResults as $searchResult) {
          echo '
          <tr>
            <td><a href="' . HOSTNAME . 'users/user_book_course.php?courseId=' . $searchResult['id']  . '">' . $searchResult['courseName'] . '</a></td>
            <td><a href="' . HOSTNAME . 'users/user_view_provider.php?providerId=' . $searchResult['providerId']  . '">' . $searchResult['companyName'] . '</a></td>
          </tr>';
        }
      echo '
      </table>';
    } else {
      echo '<h4>There are no search results with the criteria that you have suggested, please expand your search criteria</h4>
		    <h2><a href="' . HOSTNAME . 'users/user_competency_profile.php" class="selectors">Back</a></h2>';
    }
}
echo '<br />';
include_once '../footer.php';
