<?php
require 'connection.inc.php';
require 'core.inc.php';

if(loggedin()) {
include 'menu.inc.php';
}
else {
header('location:index.php');
}
?>
