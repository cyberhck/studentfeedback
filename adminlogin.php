<?php
	require_once("required_files/config.php");
	require_once("classes/auth.class.php");
	if(isset($_COOKIE['username'],$_COOKIE['password'])){
	authenticate::$db_host=$db_host;
	authenticate::$db_user=$db_user;
	authenticate::$db_pass=$db_pass;
	authenticate::$db_name=$db_name;
	authenticate::$username=$_COOKIE['username'];
	authenticate::$password=$_COOKIE['password'];
	$a=authenticate::check();
	if($a==true){
		header("location:admin.php");
	}
}
?>
<?php 
if(isset($_POST['submit']))
{
	if((!isset($_POST['username'],$_POST['password'])) || $_POST['username']=='' || $_POST['password']==''){
		header("location:studentlogin.php?error=emptyFields");
	}
	//login logic.
	$username=$_POST['username'];
	$password=$_POST['password'];
	require_once("required_files/config.php");
	$con=mysql_connect($db_host,$db_user,$db_pass);
	$username=mysql_real_escape_string($username);
	$sql="SELECT * FROM `$db_name`.`admin` WHERE `username`='$username' LIMIT 1";
	$query=mysql_query($sql);
	$num=mysql_num_rows($query);
	if($num!=1){
		header("location:adminlogin.php?error=noUser");
		die();
	}
	$data=mysql_fetch_object($query);
	$passdb=$data->password;
	$password=crypt($password,$salt);
	if($password==$passdb){
		//set to cookie
		setcookie("username",$_POST['username'],time()+3600,"/");
		setcookie("password",$passdb,time()+3600,"/");
		header("location:admin.php");
	}else{
		header("location:adminlogin.php?error=passwordMismatch");
	}

}else{
?>
<?php $title="Login Admin"; require_once('required_files/header.php'); ?>
	<div class="jumbotron">
		<?php if(isset($_GET['error'])){
			$error=$_GET['error'];

		?>	
		<div class="alert alert-danger col-sm-6 col-sm-offset-3" align="center">
		<?php 
			switch ($error) {
				case 'emptyFields':
					echo "Form was not filled completely!";
					break;
				case 'noUser':
					echo "No such user is registered";
					break;
				case 'passwordMismatch':
					echo "Sorry, we don't recognize the credentials";
					break;
				case 'notLoggedIn':
					echo "You might wanna login first before you view admin page.";
					break;
				default:
					echo "Some Error occured! Please try again";
					break;
			}

 ?>
		</div>
		<?php
			} ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<p><input type="text" name="username" class="form-control" placeholder="Username" style="width:400px;"></p><p><input type="password" name="password" style="width:400px;" class="form-control" placeholder="Password"></p>
					<input type="submit" class="btn btn-default btn-login" name="submit">
				</form>
				</div>
			</div>
		</form>
	</div>
<?php require_once('required_files/footer.php'); ?>
<?php
}
?>