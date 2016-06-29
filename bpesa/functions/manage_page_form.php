<?php
//turn off deprecicated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
$page_title = 'BpeSA Skills Portal - Manage Pages';
require_once '../config.php';
require_once '../header.php';

$currentpage = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$pageType = $_REQUEST['pageType'];
$pageName = $_REQUEST['pageName'];

$dbconnect = NEW DB_Class();

if($_REQUEST['pageType'] == 'admin') {
  $managePageUrlsSql = "SELECT id, pageUrl, pageType, pageName, pageContent FROM adminpages WHERE visible='Y' AND pageName = '" . $pageName  . "' AND pageType = '" . $pageType . "'";
}
if($_REQUEST['pageType'] == 'providers') {
  $managePageUrlsSql = "SELECT id, pageUrl, pageType, pageName, pageContent FROM providerpages WHERE pageName = '" . $pageName  . "' AND pageType = '" . $pageType . "'";   
}
if($_REQUEST['pageType'] == 'users') {
  $managePageUrlsSql = "SELECT id, pageUrl, pageType, pageName, pageContent FROM userpages WHERE pageName = '" . $pageName  . "' AND pageType = '" . $pageType . "'";   
}
if($_REQUEST['pageType'] == 'operators') {
  $managePageUrlsSql = "SELECT id, pageUrl, pageType, pageName, pageContent FROM operatorpages WHERE pageName = '" . $pageName  . "' AND pageType = '" . $pageType . "'";   
}

$managePageUrls = $dbconnect->fetch($managePageUrlsSql);

echo '
<h1 class="page-title"><span class="current-page">Man</span>age Pages</h1>
<table class="table">
        <form action="manage_page_save.php" method="post">';
foreach($managePageUrls as $managePageUrl) {
    echo '<tr>
            <td>
              <label class="text-info">Page Name</label>
            </td>
            <td>
              <input type="text" class="form-control" name="pageName" value="' . $managePageUrl['pageName'] . '" />
              <input type="hidden" name="pageId" value="' . $managePageUrl['id'] . '" />
              <input type="hidden" name="originUrl" value="' . $currentpage . '" />
              <input type="hidden" name="pageType" value="' . $pageType . '" />
            </td>
          </tr>
          <tr>
            <td>
              <label class="text-info">Page Content</label>
            </td>
            <td>
              <textarea rows="4" cols="50" name="pageContent">
                ' . $managePageUrl['pageContent'] . '
              </textarea>
            </td>
          </tr>';
}
echo '
    <tr>
      <td colspan="2">
        &nbsp;
      </td>
    </tr>
    <tr>
        <td>
          &nbsp;
        </td>
        <td>
          <input type="submit" class="btn btn-primary" value="save changes" name="submit">
        </td>
      </tr>
      </form>
    </table>
    <br/>';

include '../footer.php';
?>
