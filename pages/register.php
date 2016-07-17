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
			?><script type='text/javascript'>alert("Register successful. Please Login..!")</script><?php
			header('location:login.php');
			} else {
			echo "Sorry! something went wrong. Please try again.";
			}
		  }
		}
	}
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Content Management System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .error {color: #FF0000;}
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <div class="form-group">
								<label>Username:</label>
                                    <input class="form-control" type="text" name="username" value="<?php echo $username; ?>"/>
                                    <span class="error"><?php echo $nameEr; ?></span>
									<span class="error"><?php echo $usernameExists; ?></span>
									<span class="error"><?php echo $usernameLen; ?></span>
                                </div>
                                <div class="form-group">
								<label>Name:</label>
                                    <input class="form-control" type="text" name="fullname" value="<?php echo $fullname; ?>"/>
                                    <span class="error"><?php echo $fullnameEr; ?></span>
                                </div>
								<div class="form-group">
								<label>Password:</label>
                                    <input class="form-control" type="password" name="password" value="<?php echo $password; ?>"/>
									<span class="error"><?php echo $passwordEr; ?></span>
									<span class="error"><?php echo $passwordLen; ?></span>
                                </div>
								<div>
								<label>Confirm Password:</label>
                                    <input class="form-control" type="password" name="confirm_password" value="<?php echo $confirm_password; ?>"/>
									<span class="error"><?php echo $confirm_passwordEr; ?></span>
									<span class="error"><?php echo $confirm_passwordErr; ?></span>
                                </div>
								<div>
								<label>Email:</label>
                                    <input class="form-control" type="text" name="email" value="<?php echo $email; ?>"/>
									<span class="error"><?php echo $emailEr; ?></span>
									<span class="error"><?php echo $invalidEmail; ?></span>
                                </div>
								<div>
								<label>Upload Pic:(max size 1mb)</label>
                                    <input type="file" name="file" value="<?php echo $file; ?>"/>
									<span class="error"><?php echo $fileEr; ?></span>
                                </div>
								<div>
								<label>More about you:(max 500 words)</label>
                                <input type="form-control" type="text" name="description" maxlength="500" value="<?php echo $description; ?>"/>
								<span class="error">Optional</span>
                                </div><br>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="submit" value="Register" class="btn btn-lg btn-success btn-block">
                            </fieldset>
                        </form>
						<a href="login.php">Login here..!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
