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
		<a href="collegeResult.php" >Part B</a> | <a href="studentfeedbacks.php">Student's Comments</a>
	</div>
	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
			<?php $sql="SELECT parameter,SUM(value) AS score,(COUNT(parameter)*5) AS total,((SUM(value)/(COUNT(parameter)*5))*100) AS percentage FROM `$db_name`.`collegeRating` GROUP BY parameter;";
				$connection=mysql_connect($db_host,$db_user,$db_pass);
				$query=mysql_query($sql);
				$a="<table class='table'><tr> <th>Parameter</th> <th>Secured Score</th> <th>Total</th> <th>Percentage</th> </tr>";
				while($data=mysql_fetch_object($query)){
					$a=$a."<tr><th>$data->parameter</th><td>$data->score</td><td>$data->total</td><td>$data->percentage %</td></tr>";
				}
				$a=$a."</table>";
				echo $a;
			 ?>
			</div>
		</div>
	</div>
<?php require_once('../required_files/footer.php'); ?>