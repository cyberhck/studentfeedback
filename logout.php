<?php 
if(isset($_COOKIE['password'])){
	setcookie("password","",time()-3600);
	header("location:adminlogin.php");
	die();
}
if(isset($_COOKIE['usn'])){
	setcookie("usn","",time()+3600);
	header("location:studentlogin.php");
}
?>