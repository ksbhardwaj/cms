<?php
require 'connection.inc.php';
require 'core.inc.php';
if(!loggedin()) {
header('location:login.php');
}

$topic = $des = $data = "";
$topicEr = $desEr = $dataEr = "";
function test_input($data1) {
	$data1 = trim($data1);
	$data1 = stripslashes($data1);
	$data1 = htmlspecialchars($data1);
	return $data1;
	}
	if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$user_id = $_SESSION['user_id'];
	$_SESSION['blog_id']=$id;
	$sql = 'select * from blogs where user_id=? and blog_id=?';
	$pds = $pdo->prepare($sql);
	$pds->execute(array($user_id,$id));
	if($rows = $pds->fetch()) {
	$topic = $rows['topic'];
	$des = $rows['description'];
	$data = $rows['data'];
	}else {
	header('Location:viewblogs.php');
	}
} else if($_SERVER["REQUEST_METHOD"]=="POST") { 

if(isset($_POST['topic']) && isset($_POST['des']) && isset($_POST['data'])) {
$topic = test_input($_POST['topic']);
$des = test_input($_POST['des']);
$data = test_input($_POST['data']);
$blog_id=$_SESSION['blog_id'];
	if(empty($topic)) {
	$topicEr = "Field can't be empty";
	}
	if(empty($des)) {
	$desEr = "Field can't be empty";
	}
	if(empty($data)) {
	$dataEr = "Field can't be empty";
	}
		if(!empty($topic) && !empty($des) && !empty($data)) {
		$sql="UPDATE `blogs` SET `topic`=?,`description`=?,`data`=? WHERE `blog_id`=?";
		$pds=$pdo->prepare($sql);
		$pds->execute(array($topic,$des,$data,$blog_id));
		unset($_SESSION['blog_id']);
		header('Location:viewblogs.php?id='.$blog_id);
		}
}

} else {header('Location:viewblogs.php');}
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
					<form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
						<div class="form-group">
							<label>Title:</label>
								<input class="form-control" type="text" name="topic" value="<?php echo $topic; ?>">
						<span class="error">*<?php echo $topicEr; ?></span>
						</div>
						<div class="form-group">
							<label>Short Description:</label>
								<input class="form-control" type="text" name="des" value="<?php echo $des; ?>">
							<span class="error">*<?php echo $desEr; ?></span>
						</div>
						<div class="form-group">
							<label>Your Blog:</label>
								<textarea class="form-control" name="data" rows="15" cols="15"><?php echo $data; ?></textarea>
						<span class="error">*<?php echo $dataEr; ?></span>
						</div>
							<input class="btn btn-default" type="submit" name="submit" value="Submit">
					</form>	
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
