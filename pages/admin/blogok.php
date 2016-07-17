<?php
require 'connection.inc.php';
require 'core.inc.php';
	if(loggedin()) {
if(isset($_GET['id'])) {
$id = $_GET['id'];
$sql = 'UPDATE blogs SET status=1 WHERE blog_id=?';
$pds = $pdo->prepare($sql);
$pds->execute(array($id));
header('Location:approveblogs.php');
} else {
header('Location:approveblogs.php');
 }
}
else {
header('Location:index.php');
}
?>
