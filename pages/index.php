<?php
require 'connection.inc.php';
require 'core.inc.php';
if(!loggedin()) {
header('location:login.php');
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
                <a class="navbar-brand" href="index.php">Content Management System <?php echo 'Welcome '.$_SESSION['email'];?> </a>
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
echo '<div><h2>Posted By: '.$bb['name'].'</h2></div>';
echo '<div id="pic"><img src="userImages/'.$bb['username'].'/'.$bb['picture'].'" height=250 width=200></div>';
while($row=$pds->fetch()) {
echo '<div><h2>Title: '.$row['topic'].'</h2></div>';
echo '<div><h3>Description:</h3></div> <div>'.$row['description'].'</div>';
echo '<div><h3>Post:</h3></div><div>' .$row['data'].'</div>';
echo '<div><h3>Posted on:</h3></div><div>'.$row['time'].'</div>';
echo '<div><a href="index.php">Back</a></div>';
}}else {header('Location:index.php');}
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
echo '<div><h2>Title: <a href="index.php?id='.$row['blog_id'].'">'.$row['topic'].'</a></h2></div>';
echo '<div><h4>Description:</h4></div><div> '.$row['description'].'</div>';
echo '<div><h4>Posted on :</h4></div> <div>'.$row['time'].'</div>';
}

if( $page > 0 && $left_rec > $rec_limit)
{
$last = $page - 2;
echo "<a href=\"index.php?page=$last\">Last 10 Records</a> |";
echo "<a href=\"index.php?page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
echo "<a href=\"index.php?page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
$last = $page - 2;
echo "<a href=\"index.php?page=$last\">Last 10 Records</a>";
}
}?>

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
