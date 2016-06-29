<?php
require_once '../config.php';
require_once '../header.php';
include '../sessionTest.php';

echo '
  <form action="' . HOSTNAME . 'send_new_message.php" method="post" >
    Subject:<br />
    <input type="text" name="subject" value="" />
    <br />
    Message:
    <br />
    <textarea name="message"></textarea>
    <input type="hidden" name="senderId" value="' . $_SESSION['userId'] . '" />
    <input type="hidden" name="recipientId" value="' . $_GET['recipientId'] . '" />
    <br />
    <input type="submit" class="submit" value="SEND" />
  </form>
  <br/>';

include '../footer.php';
?>
