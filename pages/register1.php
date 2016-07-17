<?php
require 'connection.inc.php';
require 'core.inc.php';
$nameEr=$passwordEr=$emailEr=$confirm_passwordEr=$confirm_passwordErr=$usernameExists=$invalidEmail=$usernameLen=$passwordLen=$fullnameEr=$fileEr="";
$username=$password=$confirm_password=$email=$fullname=$file=$description="";
function test_input($data)
	{
	$data=trim($data);
	$data=stripslashes($data);
	$data=htmlspecialchars($data);
	return $data;
	}
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['email']) && isset($_POST['fullname']) && isset($_POST['description'])) {
	
	$username=test_input($_POST['username']);
	$password=test_input($_POST['password']);
	$password_hash=md5($password);
	$confirm_password=test_input($_POST['confirm_password']);
	$email=test_input($_POST['email']);
	$fullname=test_input($_POST['fullname']);
	$description=test_input($_POST['description']);
	$filename=$_FILES["file"]["name"];
	$target_dir = "userImages/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	//temp variable for valid image
	$uploadOk=1;
	if(!empty($_FILES["file"]["name"])) {
	$uploadOk = 1;
	} else {
		$uploadOk = 0;
		$fileEr = "Choose profile picture.";
	}
	
	if(!empty($_FILES["file"]["name"])) {
	 $check = getimagesize($_FILES["file"]["tmp_name"]);
	 if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
	// Check if file already exists
	if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
	}
	}
	
	// Check file size
	if ($_FILES["file"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
	}
	
	
	 if (empty($username)) {
	 $nameEr="Field can't be empty";
	 }
	 if (empty($password)) {
	 $passwordEr="Field can't be empty";
	 }
	 if (empty($confirm_password)) {
	 $confirm_passwordEr="Field can't be empty";
	 }
	 if (empty($email)) {
	 $emailEr="Field can't be empty";
	 }
	 if (empty($fullname)) {
	 $fullnameEr="Field can't be empty";
	 }
	 
	 if (!empty($password) && !empty($confirm_password)) {
	 if ($password!=$confirm_password){
	 $confirm_passwordErr="Password does not matched";
	 }}
	 
	 if (!empty($username) && strlen($username)<=3) {
	 $usernameLen="must contain 4 characters";
	 }
	 if (!empty($password) && strlen($password)<=5) {
	 $passwordLen="must contain 6 characters";
	 }
	 if (!filter_var($email,FILTER_VALIDATE_EMAIL) && !empty($email)) {
	 $invalidEmail = "Invalid email";
	 }
	 
	 if (!empty($username)&&!empty($password)&&!empty($confirm_password)&&!empty($email)&&!empty($fullname)) {
	   if ($password==$confirm_password && strlen($username)>=4 && strlen($password)>=6 && filter_var($email,FILTER_VALIDATE_EMAIL) && $uploadOk==1) {
			$sql_getuser='select user_id from users where username=?';
			$sql_getemail='select * from users where email=?';
			$sql_insert='insert into users(username,name,email,password,picture,description) values(?,?,?,?,?,?)';
			$pdsgetuser=$pdo->prepare($sql_getuser);
			$pdsgetuser->execute(array($username));
			$pdsgetemail=$pdo->prepare($sql_getemail);
			$pdsgetemail->execute(array($email));
			
			if(($pdsgetuser->fetch())>0)
			{
			$usernameExists="username already exists";
			}
			else if(($pdsgetemail->fetch())>0)
			{
			$usernameExists="email already exists";
			}
			else
			{
			$pdsinsert=$pdo->prepare($sql_insert);
			if($pdsinsert->execute(array($username,$fullname,$email,$password_hash,$filename,$description))) {
			mkdir("userImages/$username");
			move_uploaded_file($_FILES["file"]["tmp_name"], "userImages/$username/" . $_FILES["file"]["name"]);
			header('location:register_success.php');
			} else {
			echo "Sorry! something happened wrong. Please try again.";
			}
		  }
		}
	}
  }
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
                                   <td width="180" height="22" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                                   <td  id="menu" width="180" height="500" align="left" valign="top"><?php if(loggedin()) {
header('Location:welcome.php');
}
else {
include 'loginform.inc.php';
echo '<a href="register.php">Register</a>';
} ?>
                                              </td>
                            </tr>
                     </table></td>
              <td id="contents" width="540" height="522" align="left" valign="top">
                     <div class="heading">&nbsp;<p>Registration</div>
                     <div class="text">
					 <form method="post" action="register.php" enctype="multipart/form-data" >
Username:<input type="text" name="username" value="<?php echo $username; ?>"/>
<span class="error"><?php echo $nameEr; ?></span>
<span class="error"><?php echo $usernameExists; ?></span>
<span class="error"><?php echo $usernameLen; ?></span><br /><br />
Full Name:<input type="text" name="fullname" value="<?php echo $fullname; ?>"/>
<span class="error"><?php echo $fullnameEr; ?></span><br /><br />
Password:<input type="password" name="password" value="<?php echo $password; ?>"/>
<span class="error"><?php echo $passwordEr; ?></span>
<span class="error"><?php echo $passwordLen; ?></span><br /><br />
Confirm Password:<input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>"/>
<span class="error"><?php echo $confirm_passwordEr; ?></span>
<span class="error"><?php echo $confirm_passwordErr; ?></span><br /><br />
Email:<input type="text" name="email" value="<?php echo $email; ?>"/>
<span class="error"><?php echo $emailEr; ?></span>
<span class="error"><?php echo $invalidEmail; ?></span><br /><br />
Upload Picture<input type="file" name="file" value="<?php echo $file; ?>"/>
<span class="error"><?php echo $fileEr; ?></span><br /><br />
More about you:(max 500 words)<input type="text" name="description" maxlength="500" value="<?php echo $description; ?>"/>
<span class="error">Optional</span><br /><br />
<input type="submit" name="submit" value="Sign Up">
</form>

                     </div>
                     </td>
              <td id="right" width="180" height="522" valign="top">
                     <table width="180" height="522" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                   <td width="180" height="22" valign="top">
                                          <img src="images/title2.gif" width="180" height="22" alt=""></td>
                            </tr>
                            <tr>
                                   <td id="contents_right" width="180" height="500" align="left" valign="top"> </td>
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