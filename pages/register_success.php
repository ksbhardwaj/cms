<?php
require 'connection.inc.php';
require 'core.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title></title>
   <meta name="generator" content="HTML 4" />
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
   <meta name="description" content="" />
   <meta name="keywords" content="" />
   <meta name="author" content="" />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body bgcolor="#735b3d" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<table id="container" width="900" border="0" cellpadding="0" cellspacing="0">
       <tr>
              <td width="900" height="135" colspan="3">
                     <table id="up" width="900" height="135" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                   <td width="206" height="85">
                                          <img src="images/sitename.jpg" width="206" height="85" alt=""></td>
                                   <td width="275" height="85">
                                          <img src="images/image.jpg" width="275" height="85" alt=""></td>
                                   <td width="419" height="85" colspan="2">
                                          <img src="images/slogan.jpg" width="419" height="85" alt=""></td>
                            </tr>
                            <tr>
                                   <td width="900" height="10" colspan="4" bgcolor="#A8C1E5">
                                          <img src="images/spacer.gif" width="900" height="10" alt=""></td>
                            </tr>
                            <tr>
                                   <td width="206" height="24">
                                          <img src="images/bg_05.jpg" width="206" height="24" alt=""></td>
                                   <td width="275" height="24">
                                          <img src="images/bg_06.gif" width="275" height="24" alt=""></td>
                                   <td width="209" height="24">
                                          <img src="images/bg_07.gif" width="209" height="24" alt=""></td>
                                   <td width="210" height="24">
                                          <img src="images/bg_08.jpg" width="210" height="24" alt=""></td>
                            </tr>
                            <tr>
                                   <td width="900" height="16" colspan="4">
                                          <img src="images/spacer.gif" width="900" height="16" alt=""></td>
                            </tr>
                     </table></td>
       </tr>
       <tr>
              <td id="left" width="180" height="522" valign="top">
                     <table width="180" height="522" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                   <td width="180" height="22" valign="top">
                                          <img src="images/title1.jpg" width="180" height="22" alt=""></td>
                            </tr>
                            <tr>
                                   <td  id="menu" width="180" height="500" align="left" valign="top">
                                              <?php if(loggedin()) {
header('Location:welcome.php');
}
else {
include 'loginform.inc.php';
echo '<a href="register.php">Register</a>';
} ?></td>
                            </tr>
                     </table></td>
              <td id="contents" width="540" height="522" align="left" valign="top">
                     <div class="heading">&nbsp;<p>Posts By Users</div>
                     <div class="text">
					<h3>Registration Successful! Login Now...</h3>
					 </div>
                     </td>
              <td id="right" width="180" height="522" valign="top">
                     <table width="180" height="522" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                   <td width="180" height="22" valign="top">
                                          <img src="images/title2.gif" width="180" height="22" alt=""></td>
                            </tr>
                            <tr>
                                   <td id="contents_right" width="180" height="500" align="left" valign="top"></td>
                            </tr>
                     </table></td>
       </tr>
       <tr>
              <td width="180" height="13" bgcolor="#82CF74">
                     <img src="images/spacer.gif" width="180" height="13" alt=""></td>
              <td width="540" height="13">
                     <img src="images/spacer.gif" width="540" height="13" alt=""></td>
              <td width="180" height="13" bgcolor="#ECE45A">
                     <img src="images/bg_17.gif" width="180" height="13" alt=""></td>
       </tr>
       <tr>
              <td id="copyright" width="900" height="25" colspan="3" align="center" valign="middle">&nbsp;
                     </td>
       </tr>
</table>
</center>
</body>
</html>

			<center>&nbsp;</center>
<p><br>
		</p>