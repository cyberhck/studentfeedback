<?php
	require_once("../required_files/config.php");
	require_once("../classes/auth.class.php");
	if(isset($_COOKIE['username'],$_COOKIE['password'])){
	authenticate::$db_host=$db_host;
	authenticate::$db_user=$db_user;
	authenticate::$db_pass=$db_pass;
	authenticate::$db_name=$db_name;
	authenticate::$username=$_COOKIE['username'];
	authenticate::$password=$_COOKIE['password'];
	$a=authenticate::check();
	if($a!=true){
		header("location:index.php?error=notLoggedIn");
		die();
	}
}else{
	header("location:/admin");
}
?>
<?php $title="Login Admin"; require_once('../required_files/header.php'); ?>
	<div align="center">
		<a href="admin.php" >Part A</a> | <a href="collegeResult.php" >Part B</a> | <a href="studentfeedbacks.php">Student's Comments</a> | <a href="report.php">Report</a>
	</div>
	<div class="jumbotron">
		<div class="row">
		<form action="report.php" id="myForm" method="get">
				<label>I want clean format <input id="format" type="checkbox" name="format" checked></label>
				<p>
				<select name="department" class="form-control" style="width:300px;">
					<option value="ise">ISE</option>
					<option value="cse">CSE</option>
					<option value="eee">EEE</option>
					<option value="ece">ECE</option>
					<option value="civ">CV</option>
					<option value="me">ME</option>
					<option value="bs">BS</option>
					<option value="mtcs">MTCS</option>
					<option value="mtec">MTEC</option>
					<option value="mtcv">MTCV</option>
					<option value="mtme">MTME</option>
				</select>
				<p>
					<select name="sem" class="form-control" style="width:300px;">
						<option value="1">1</option>
						<option value="3">3</option>
						<option value="5">5</option>
						<option value="7">7</option>
					</select>
				<p>
					<select name="section" class="form-control" style="width:300px;">
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="C">C</option>
						<option value="D">D</option>
						<option value="E">E</option>
						<option value="F">F</option>
						<option value="G">G</option>
					</select>
				<p><input name="submit" type="submit" onclick="myFunc();" class="btn btn-login" value="View those!"></p>
		</form>
		</div>
	</div>
<?php require_once('../required_files/footer.php'); ?>
