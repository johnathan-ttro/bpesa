<?php
  $currentpage = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div id="contentLogin">
  <form action="<?php echo HOSTNAME . 'functions/loginCheck.php'; ?>" method="post" name="form2" id="login" >           
  <table border="0" align="right" id="login-table">
  <tr>
    <td width="20%" align="left"><label>Username:</label></td>
    <td width="80%" align="left"><input type="text" class="text" name="userName" /></td>
    <td width="15%" rowspan="2" style="padding-top:24px;"  valign="middle"  align="right" >
        <input class="text" type="hidden" name="originUrl" value="<?php echo $currentpage ?>" />
        <input class="submit" type="submit" name="passwordSubmit" value="Login" /></td>
  </tr>
  <tr>
    <td align="left"><label>Password:</label></td>
    <td align="left"><input class="text" type="password" name="password" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><label><a href="<?php echo HOSTNAME . 'register.php'; ?>">Not a member yet? Register here.</a></label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td  align="left"><label><a href="<?php echo HOSTNAME . 'forgot_password.php'; ?>">Forgot password? Click here.</a></label></td>
    <td>&nbsp;</td>
  </tr>
</table> 
</form>

<div style="float: left; padding: 30px 0 10px 0;"></div>
<div style="clear: both;"></div>
</div>


