<?php
$database='blog';
	 $user='root';
	 $pass='';
	 $dns="mysql:host=localhost;dbname=$database";
		try
		{
		 $pdo=new PDO($dns,$user,$pass);
		}
		catch(PDOException $e)
		{
		die('Database Connection Failed');
		}
?>
