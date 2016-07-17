<?php
$emailid=$password1="";
$emailidEr = $password1Er = "";
if(isset($_POST['emailid']) && isset($_POST['password1'])) {
	$emailid = test_input1($_POST['emailid']);
	$password1 = test_input1($_POST['password1']);
	$password_hash = md5($password1);
		if(empty($emailid)) {
		$emailidEr = "Enter email";
		}
		if(empty($password1)) {
		$password1Er = "Enter Password";
		}
		if(!empty($emailid)&&!empty($password1)) {
			$sql = "select user_id from users where email=? and password=?";
			$pds = $pdo->prepare($sql);
			$pds->execute(array($emailid,$password_hash));
			if($row = $pds->fetch()) {
			session_start();
			$user_id = $row['user_id'];
			$_SESSION['user_id'] = $user_id;
			$_SESSION['email'] = $emailid;
			header('location:welcome.php');
			}
			else {
			?><script type='text/javascript'>alert("Login failed. Check email or password")</script><?php
			}
			}
	}
function test_input1($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}
?>
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<form action="<?php echo htmlspecialchars($current_file); ?>" method="POST">
Email:<input type="text" name="emailid" value="<?php echo $emailid; ?>" />
<span class="error"><?php echo $emailidEr; ?></span><br />
Password:<input type="password" name="password1" value="<?php echo $password1?>"/>
<span class="error"><?php echo $password1Er; ?></span><br />
<input type="submit" name="submit" value="Sign In">
</form>
</body>
</html>