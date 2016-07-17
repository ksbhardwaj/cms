<?php
require 'connection.inc.php';
require 'core.inc.php';

if(loggedin()) {
header('Location:welcome.php');
}
else {
include 'loginform.inc.php';
}
?>
