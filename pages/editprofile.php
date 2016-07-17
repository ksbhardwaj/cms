<?php
require 'connection.inc.php';
require 'core.inc.php';
if(!loggedin()) {
header('location:login.php');
}
$fullnameEr=$fileEr="";
$fullname=$description="";
function test_input($data1)
	{
	$data1=trim($data1);
	$data1=stripslashes($data1);
	$data1=htmlspecialchars($data1);
	return $data1;
	}
if(!isset($_POST['submit'])) {
$user_id=$_SESSION['user_id'];
$sql = 'SELECT * FROM users WHERE user_id=?';
	$pds = $pdo->prepare($sql);
	$pds->execute(array($user_id));
	if($rows = $pds->fetch()) {
	$fullname = $rows['name'];
	$description = $rows['description'];
	$aa=$rows['username'];
	$_SESSION['username']=$aa;
	}}
	else if(isset($_POST['submit'])) { 
 if(isset($_POST['description']) && isset($_POST['fullname'])) {
    
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
    echo "Sorry, your file can't be more than 5mb.";
    $uploadOk = 0;
	}
	if (empty($fullname)) {
	 $fullnameEr="Field can't be empty";
	 }
		if (!empty($fullname) && $uploadOk==1) {
		$username=$_SESSION['username'];
		$user_id=$_SESSION['user_id'];
		$sql="UPDATE `users` SET `name`=?,`description`=?,`picture`=? WHERE `user_id`=?";
		$pds=$pdo->prepare($sql);
		$pds->execute(array($fullname,$description,$filename,$user_id));
		move_uploaded_file($_FILES["file"]["tmp_name"], "userImages/$username/" . $_FILES["file"]["name"]);
		unset($_SESSION['username']);
		echo 'OK';
		header('Location:index.php');
		} 
 }
}else{header('Location:index.php');}
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

    <!-- Timeline CSS -->
    <link href="../dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Content Management System</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="editprofile.php"><i class="fa fa-user fa-fw"></i> Edit Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="addblog.php"><i class="fa fa-edit fa-fw"></i> Add New Post</a>
                        </li>
                        <li>
                            <a href="viewblogs.php"><i class="fa fa-sitemap fa-fw"></i> View Posts</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">All Posts</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-lg-8">
					<h3>Edit Profile</h3>
					<form role="form" method="post" action="" enctype="multipart/form-data" >
					<div class="form-group">
					<label>Full Name:</label>
					<input class="form-control" type="text" name="fullname" value="<?php echo $fullname; ?>"/>
					<span class="error"><?php echo $fullnameEr; ?></span>
					</div>
					<div class="form-group">
					<label>Upload Picture</label>
					<input type="file" name="file"/>
					<span class="error"><?php echo $fileEr; ?></span>
					</div>
					<div class="form-group">
					<label>More about you:(max 500 words)</label>
					<input class="form-control" type="text" name="description" maxlength="500" value="<?php echo $description; ?>"/>
					<span class="error">Optional</span>
					</div>
					<input type="submit" name="submit" value="Update">
					</form>
					<a href="index.php">Cancel</a></div>   
				</div>
            </div>
             <!-- /.col-lg-8 -->
                <div class="col-lg-4">

                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

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
