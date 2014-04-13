<?php 
if(isset($_POST['submit']))
{
	if((!isset($_POST['usn'],$_POST['password'])) || $_POST['usn']=='' || $_POST['password']==''){
		header("location:studentlogin.php?error=emptyFields");
	}
	require_once("classes/info.class.php");
	$a=new getInfo($_POST['usn']);
	if(!($a->valid)){
		header("location:studentlogin.php?error=usnInvalid");
		die();
	}
	$usn=strtolower($_POST['usn']);
	$password=strtolower($_POST['password']);
	if($usn==$password){
		setcookie("sem",$_POST['sem'],time()+3600,"/");
		setcookie("sec",$_POST['sec'],time()+3600,"/");
		setcookie("usn", $usn, time()+35000, "/");
		require_once("required_files/config.php");
		$usn=mysql_real_escape_string($usn);
		$con=mysql_connect($db_host,$db_user,$db_pass);
		$sql="INSERT INTO `$db_name`.`usns` (id,usn) VALUES (NULL,$usn);";
		mysql_query($sql);
		header("location:feedback.php");
	}else{
		header("location:studentlogin.php?error=passwordMismatch");
	}
}else{
?>
<?php $title="Login Student";require_once('required_files/header.php'); ?>
	<div class="jumbotron">
		<p align="center" style="font-family:'acme'">Login using your University Serial Number</p>
		<?php if(isset($_GET['error'])){
		?>	
		<div class="alert alert-danger col-sm-6 col-sm-offset-3" align="center"><?php if($_GET['error']=="emptyFields"){
			echo "Form was not filled completely!";
			}elseif($_GET['error']=="usnInvalid"){echo "Usn you entered is invalid!";}else{echo "Username and password mismatch";
			} ?>
		</div>
		<?php
			} ?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
					<p><input type="text" id="usn" name="usn" onchange="setSem()" class="form-control" placeholder="University Seat Number" style="width:400px;"></p><p><input type="password" name="password" style="width:400px;" class="form-control" placeholder="Password"></p>
					<p>Semester:<select name="sem" id="semester" class="select form-control" style="width:400px;">
						<option>2</option>
						<option>4</option>
						<option>6</option>
						<option>8</option>
					</select></p>
					<p>Section:
						<select name="sec" id="sec" class="select form-control" style="width:400px;">
							<option value="A">A</option>
							<option value="B">B</option>
						</select>
					</p>
					<p>Branch:
						<select name="branch" id="branch" class="select form-control" disabled style="width:400px;">
							<option>ISE</option>
							<option>CSE</option>
							<option>ECE</option>
							<option>EEE</option>
							<option>CIV</option>
							<option>ME</option>
						</select>
					</p>
					<input type="submit" class="btn btn-default btn-login" value="Log me in!" name="submit">
				</form>
				</div>
			</div>
		</form>
	</div>
	<script>
	function setSem () {
		setBranch();
		$.ajax({
			url: 'ajax/getSem.php',
			type: 'GET',
			dataType: 'text',
			data: {usn: $("#usn")[0].value},
		})
		.done(function(e) {
			if(e!="fail"){
				$("#semester")[0].value=e;
			}else{
				return 0;
			}
		})
		.fail(function() {
			console.log("error");
		});
		
	}
		function setBranch () {
		$.ajax({
			url: 'ajax/getBranch.php',
			type: 'GET',
			dataType: 'text',
			data: {usn: $("#usn")[0].value},
		})
		.done(function(e) {
			if(e!="fail"){
				$("#branch")[0].value=e;
			}else{
				return 0;
			}
		});
		
	}
	</script>
<?php require_once('required_files/footer.php'); ?>
<?php
}
?>