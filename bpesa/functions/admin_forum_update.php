<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
require_once '../config.php';

if(!empty($_POST['comment'])) {
$dbconnect = NEW DB_Class();
$comment = strip_word_html($_POST['comment']);

$editForumPostSql = 'UPDATE forum SET comment = "' . mysql_real_escape_string($comment) . '" WHERE id = ' . $_POST['forumId'] . '';
$editForumPost = $dbconnect->query($editForumPostSql);

 if($editForumPost) {
       header( 'Location: '. HOSTNAME. 'admin/admin_forum.php');
    }
} else {
    exit('There was no update to the forum');
}
?>