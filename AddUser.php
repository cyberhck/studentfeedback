<?php
	require_once("required_files/config.php");
	require_once("classes/auth.class.php");
	if(!isset($_COOKIE['username'],$_COOKIE['password'])){
		header("location:adminlogin.php?error=notLoggedIn");
		die();
	}
	authenticate::$db_host=$db_host;
	authenticate::$db_user=$db_user;
	authenticate::$db_pass=$db_pass;
	authenticate::$db_name=$db_name;
	authenticate::$username=$_COOKIE['username'];
	authenticate::$password=$_COOKIE['password'];
	$a=authenticate::check();
	if($a!=true){
		header("location:adminlogin.php?error=notLoggedIn");
		die();
	}else{?>
	<?php $title="Admin >> Add or Delete Member"; require_once("required_files/header.php"); ?>
	<div class="container">
		<?php 
	$form = '<tr><td><input type="text" id="name" name="name" class="form-control" style="width:250px;"></td>
	<td><input type="text" name="usn" class="form-control" style="width:150px;"></td>
	<td><input type="text" name="sem" class="form-control" style="width:150px;"></td>
	<td><input type="text" name="section" class="form-control" style="width:150px;"></td>
	<td><input type="text" name="department" class="form-control" style="width:150px;"></td>
	<td><input type="submit" id="addMember" name="submit" class="btn btn-primary" value="Add"></td></tr>';
	 ?>
		<?php
			$connection=mysql_connect($db_host,$db_user,$db_pass);
			$sql="SELECT * FROM `$db_name`.`students`";
			$query=mysql_query($sql,$connection);
			if(mysql_num_rows($query)==0){
				echo "<p class='text-danger'>No students added. Try adding some.</p>";
			}else{
		?>
		<div><a href="changePasswd.php">Change Password</a> | <a href="addAdmin.php">Add Admin</a> | <a href="edclass.php">Enable / Disable Group</a> | <a href="logout.php">Logout</a> | <a href="AddUser.php"></a></div>
		<table class="table">
			<tr><th>Name</th> <th>USN</th> <th>Semester</th> <th>Section</th> <th>Department</th><th></th> </tr>
			<?php while($data=mysql_fetch_object($query)){
			?>
			<tr><td><?php echo $data->name;?></td><td><?php echo $data->usn; ?></td><td><?php echo $data->semester; ?></td> <td><?php echo $data->section; ?></td> <td><?php echo $data->department; ?></td> <td><span style="cursor:pointer;" data-id="<?php echo $data->id; ?>" class="glyphicon glyphicon-trash text-info delete"> Delete</span></td></tr>
			<?php
				}
			?>
		</table>
					<?php
				}
			 ?>
			 <table class="table">
			 	<tr><th>Name</th><td>USN</td><th>Semester</th> <th>Section</th> <th>Department</th><th></th> </tr>
			 	<form action="ajax/addmember.php" id="membershipForm" method="post">
					<?php echo $form; ?>
				</form>
			 </table>

	</div>
	<script type="text/javascript" language="javascript" src="user.js"></script>
	<?php require_once("required_files/footer.php"); ?>
	<?php
	}

?>