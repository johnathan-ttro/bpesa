<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA skills Portal - Forum';
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$forumTopicsSql = "SELECT id, topic FROM forum_topics";
$forumTopics = $dbconnect->fetch($forumTopicsSql);
echo '
  <h1 class="page-title"><span class="current-page">For</span>um</h1>
  <br />
  <form action="admin_forum.php" method="post">
    <span id="hideSelectOption">
    <div id="selectDiv" style="float:left;">
      <select name="formFilter">
      <option value="null">All</option>';
      foreach($forumTopics as $forumTopic){
        echo '<option value="' . $forumTopic['topic'] . '">' . $forumTopic['topic'] . '</option>';
      }  
echo '</select>
  </div>
  <div style="clear:both;"></div>
  </span>
  <br />
  <input type="submit" class="btn btn-primary" value="Filter">
  </form>
  <br />
  <br />';

if(!empty($_POST) && $_POST['formFilter'] != 'null') {
  $forumMessageSelectsSql = 'SELECT 
                             forum.comment,
                             forum.dateAdded,
                             forum.topic,
                             users.realName,
                             users.id,
                             forum_topics.topic,
                             forum.id AS forumId
                             FROM forum
                             INNER JOIN users ON forum.userId = users.id
                             INNER JOIN forum_topics ON forum.topic = forum_topics.id
                             WHERE forum_topics.topic = "' . $_POST['formFilter'] . '"
                             AND forum.status="Y"
                             ORDER BY forum.id ASC';
} else {
  $forumMessageSelectsSql = 'SELECT 
                             forum.comment,
                             forum.dateAdded,
                             forum.topic,
                             users.realName,
                             users.id,
                             forum_topics.topic,
                             forum.id AS forumId
                             FROM forum
                             INNER JOIN users ON forum.userId = users.id
                             INNER JOIN forum_topics ON forum.topic = forum_topics.id
                             AND forum.status="Y"
                             ORDER BY forum.id ASC';
}
$forumMessageSelects = $dbconnect->fetch($forumMessageSelectsSql);

foreach($forumMessageSelects as $forumMessageSelect) {
  echo '  
  <table class="table1">
  <form action="' . HOSTNAME . 'functions/admin_forum_update.php" method="post" >
  <input type="hidden" name="forumId" value="' . $forumMessageSelect['forumId'] . '">    
  <tr>  
    <td color="#FF0000" colspan="2">' . $forumMessageSelect['topic'] . '</td>
  </tr>    
  <tr>  
    <td colspan="2"><textarea name="comment">' . $forumMessageSelect['comment'] . '</textarea></td>
  </tr>
  <tr>
    <td>' . $forumMessageSelect['realName'] . '</td>
    <td>Added: ' . $forumMessageSelect['dateAdded'] . '</td>
  </tr>
  <tr>
    <td><input type="submit" class="btn btn-primary" value="Edit"></td>
    <td><a href="' . HOSTNAME . 'functions/forum_remove_post.php?forumId=' . $forumMessageSelect['forumId'] . '&originUrl=' . $currentpage . '&userId=' . $forumMessageSelect['id']  . '">Offensive Post - Remove</a></td>
  </tr>
  </form>
  </table>
  <br />
  <br />';
}

include '../footer.php';
?>
