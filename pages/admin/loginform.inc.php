<?php
$username=$password="";
$usernameEr = $passwordEr = "";
if(isset($_POST['username']) && isset($_POST['password'])) {
	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
		if(empty($username)) {
		$usernameEr = "Enter username";
		}
		if(empty($password)) {
		$passwordEr = "Enter Password";
		}
		if(!empty($username)&&!empty($password)) {
			$sql = "select username from adminlogin where username=? and password=?";
			$pds = $pdo->prepare($sql);
			$pds->execute(array($username,$password));
			if($row = $pds->fetch()) {
			session_start();
			$_SESSION['username'] = $username;
			header('location:welcome.php');
			}
			else {
			?><script type='text/javascript'>alert("Login failed. Check username or password")</script><?php
			}
			}
	}
function test_input($data) {
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
Username:<input type="text" name="username" value="<?php echo $username; ?>" />
<span class="error"><?php echo $usernameEr; ?></span><br /><br />
Password:<input type="text" name="password" value="<?php echo $password?>"/>
<span class="error"><?php echo $passwordEr; ?></span><br /><br />
<input type="submit" name="submit" value="Sign In">
</form>
</body>
</html>