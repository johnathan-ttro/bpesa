<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

$currentpage = basename($_SERVER['PHP_SELF']); 
$currentpage = substr($currentpage, 0, -4);

$forumTopicsSql = "SELECT id, topic FROM forum_topics";
$forumTopics = $dbconnect->fetch($forumTopicsSql);

echo '
  <form action="operators_forum.php" method="post">
    <span id="hideSelectOption">
    <div id="selectDiv" style="float:left;">
      <select name="formFilter">';
      foreach($forumTopics as $forumTopic){
        echo '<option name="' . $forumTopic['topic'] . '">' . $forumTopic['topic'] . '</option>';
      }  
echo '</select>
  </div>
  <div style="clear:both;"></div>
  </span>
  <br />
  <input type="submit" class="submit" value="filter">
  </form>
  <br />
  <br />';

if(!empty($_POST)) {
  $forumMessageSelectsSql = 'SELECT 
                             forum.comment,
                             forum.dateAdded,
                             forum.topic,
                             users.realName,
                             users.userCompany,
                             forum_topics.topic,
                             forum_topics.id
                             FROM forum
                             INNER JOIN users ON forum.userId = users.id
                             INNER JOIN forum_topics ON forum.topic = forum_topics.id
                             WHERE forum_topics.topic = "' . $_POST['formFilter'] . '"
                             AND forum.status="Y"
                             ORDER BY forum.id DESC';
} else {
  $forumMessageSelectsSql = 'SELECT 
                             forum.comment,
                             forum.dateAdded,
                             forum.topic,
                             users.realName,
                             users.userCompany,
                             forum_topics.topic,
                             forum_topics.id
                             FROM forum
                             INNER JOIN users ON forum.userId = users.id
                             INNER JOIN forum_topics ON forum.topic = forum_topics.id
                             AND forum.status="Y"
                             ORDER BY forum.id DESC';
}
$forumMessageSelects = $dbconnect->fetch($forumMessageSelectsSql);
foreach($forumMessageSelects as $forumMessageSelect) {
  $date = strtotime($forumMessageSelect['dateAdded']);
  $date = date('d-M-Y');
  echo '  
  <table width="900px" cellspacing=3 cellpadding=3 class="table1" >
  <th class="typeface-js" colspan="2">' . $forumMessageSelect['topic'] . '</th>
  <tr>  
    <td colspan="2">' . $forumMessageSelect['comment'] . '</td>
  </tr>
  <tr>
    <td>Posted by: ' . $forumMessageSelect['userCompany'] . '</td>
    <td>Added: ' . $date . '</td>
  </tr>
  </table>
  <br />
  <br />';
}
echo '
<div id="showCommentButton"><h2><span class="selectors">Add Comment</span></h2></div>
<br />
<div id="showCommentForm" style="display:none;">
  <form action="' . HOSTNAME . 'functions/add_forum_comment.php" method="post">
    <span id="hideSelectOption">
      <div id="selectDiv" style="float:left;">
        <select name="topic">';
          foreach($forumTopics as $forumTopic) {
            echo '<option value="' . $forumTopic['id'] . '">' . $forumTopic['topic'] . '</option>';
          } 
    echo'
        </select>
      </div>
    </span>
    <br />
    <br />
    <input type="hidden" name="userId" value="' . $_SESSION['userId'] . '">
    <input type="hidden" name="pageType" value="operators">
    <input type="hidden" name="originUrl" value="' . $currentpage . '">   
    <textarea name="comment">Add you comment</textarea>
    <br />
    <input type="submit" class="submit" value="Comment" />
    <br />
  </form>
</div>';
include '../footer.php';
?>
