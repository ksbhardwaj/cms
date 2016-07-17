<?php
require 'connection.inc.php';
require 'core.inc.php';
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
			$username = $row['username'];
			$_SESSION['user_id'] = $user_id;
			$_SESSION['email'] = $emailid;
			$_SESSION['username']= $username;
			header('location:index.php');
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
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="emailid" value="<?php echo $emailid; ?>"  type="email" autofocus>
                                    <span class="error"><?php echo $emailidEr; ?></span><br />
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password1" type="password" value="<?php echo $password1?>">
                                    <span class="error"><?php echo $password1Er; ?></span><br />
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="submit" value="Login" class="btn btn-lg btn-success btn-block">
                            </fieldset>
                        </form>
						<a href="register.php">Register</a>
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
