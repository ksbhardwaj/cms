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
                     </td>
                            </tr>
                     </table></td>
              <td id="contents" width="540" height="522" align="left" valign="top">
                     <div class="heading"><?php
					if(loggedin()) {
					echo 'Welcome '.$_SESSION['email'].'<br>';
					include 'menu.inc.php';
					}
					else {
					header('location:index.php');
					}
                    ?></div>
                     <div class="text">
                     <h3>All Posts</h3>
                     <?php
$rec_limit = 10;
if(isset($_GET['id'])) {
$id = $_GET['id'];
$sql1 = 'SELECT user_id FROM blogs WHERE blog_id=?';
$pds1=$pdo->prepare($sql1);
$pds1->execute(array($id));
$aa = $pds1->fetch();
$user_id = $aa['user_id'];
$sql = 'select * from blogs where blog_id=? and status=1';
$pds = $pdo->prepare($sql);
$pds->execute(array($id));
$count=$pds->rowCount();
	 if ($count>=1) {
	$sql2='SELECT * FROM users WHERE user_id=?';
	$pds2=$pdo->prepare($sql2);
	$pds2->execute(array($user_id));
	$bb = $pds2->fetch();
	echo '<p id="txt">'.'<div class="txt">Posted By: '.$bb['name'];
	echo '<div id="pic"><img src="userImages/'.$bb['username'].'/'.$bb['picture'].'" height=70 width=70></div>';
	echo'<br />Description:</div> '.$bb['description'];
	while($row=$pds->fetch()) {
	echo '<br /><br /><div class="txt">'.$row['topic'].'</div><br />';
	echo '<div class="txt">Description:</div> '.$row['description'].'<br />';
	echo '<div class="txt">Post:</div>' .$row['data'].'<br />';
	echo '<div class="txt">Keywords:</div> '.$row['keywords'].'<br />';
	echo '<div class="txt">Posted on:</div> '.$row['time'].'<br />';
	echo '<p id="data"><a href="welcome.php">Back</a></p>'.'</p>';
	}}else {header('Location:welcome.php');}
} else {
$sql = 'select * from blogs where status=1';
$pds = $pdo->prepare($sql);
$pds->execute();
$rec_count=$pds->rowCount();
if( isset($_GET{'page'} ) )
{
   $page = $_GET{'page'} + 1;
   $offset = $rec_limit * $page ;
}
else
{
   $page = 0;
   $offset = 0;
}
$left_rec = $rec_count - ($page * $rec_limit);
$sql1 = "SELECT * ".
       "FROM blogs WHERE status=1 ".
       "LIMIT $offset, $rec_limit";
	   $pds1 = $pdo->prepare($sql1);
	   $retval = $pds1->execute();
	while($row=$pds1->fetch($retval,PDO::FETCH_ASSOC)) {
	echo '<br /><p id="data"><a href="welcome.php?id='.$row['blog_id'].'">'.$row['topic'].'</a><br />';
	echo '<div class="txt">Description:</div> '.$row['description'].'<br />';
	echo '<div class="txt">Keywords:</div> '.$row['keywords'].'<br />';
	echo '<div class="txt">Posted on :</div> '.$row['time'].'</p>';
	}
	
	if( $page > 0 && $left_rec > $rec_limit)
{
   $last = $page - 2;
   echo "<a href=\"welcome.php?page=$last\">Last 10 Records</a> |";
   echo "<a href=\"welcome.php?page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"welcome.php?page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"welcome.php?page=$last\">Last 10 Records</a>";
}
}?>
					</div>
                     </td>
              <td id="right" width="180" height="522" valign="top">
                     <table width="180" height="522" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                   <td width="180" height="22" valign="top">
                                          <img src="images/title2.gif" width="180" height="22" alt=""></td>
                            </tr>
                            <tr>
                                   <td id="contents_right" width="180" height="500" align="left" valign="top">&nbsp;</td>
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
