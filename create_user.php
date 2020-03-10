<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php");?>
<?php require_once ("includes/form_functions.php");?>

<?php

if (!logged_in()) {
	redirect_to("login.php");
}

?>



<?php

		if(isset($_POST['submit'])){
			$username = mysql_prep($_POST['username']);
			$password = mysql_prep($_POST['password']);
			

			create_user($username,$password);
		} else {


			//redirect_to('index.php');
		}

		?>

		<?php
		function create_user($username,$password){
			global $connection;
			$query = "INSERT INTO admin (";
			$query .= " username, hashed_password) ";
			$query .= "VALUES ( '{$username}', '{$password}' )";
			$admin_set = mysqli_query($connection,$query);
			confirm_query($admin_set);

			if($admin_set){
				$_SESSION['message'] = "user successfully created !!";
			} else {
				$_SESSION['message'] = "User Creation Failed !!";
			}
			
			
		}
		
		?>
	
<?php 
// delete username
	if(isset($_POST['submit1'])){
			$username = trim(mysql_prep($_POST['user']));
			
	$query = "DELETE FROM admin WHERE username = '{$username}' LIMIT 1";
		$result = mysqli_query($connection,$query);
		if (mysqli_affected_rows($connection) == 1) {
			$_SESSION['message'] = "user deleted successfully!!";
		} else {
			$_SESSION['message'] = "user deletion failed!!";
		}
	}
?>




<?php include("includes/header.php"); ?>
<div id="main">

	<div id="navigation">	
		<h2> </h2><a id ="home_link" href="admin.php">Admin</a> </h2>
		<br/>
		<br/>
		<br/>
	
		<p class= "message"> <?php message();?> <p>
		
	
	</div>

	<div id="page">

		
		&nbsp;&nbsp;&nbsp;
		<form id="create_user_form" action="create_user.php" method="post">
			<h2>CREATE USER</h2>
			<table>
			<tr>

				<td>User Name: </td>
				<td><input claa=type ="text" required name="username"> </br> </td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password" required> </br> </td>
			</tr>
			<tr>
				<td> <input type="submit" name="submit" value="submit"> </td>
			</tr>
			</table>
		</form>
		
		
		<form id="delete_user" action="create_user.php" method="post">
			<h2> Delete USER</h2>
			<table>
			<tr>

				<td>User Name: </td>
				<td><input claa=type ="text"  name="user" required> </br> </td>
			</tr>
			<tr>
				
			</tr>
			<tr>
				<td> <button type ="submit" value ="submit" name ="submit1" > Delete </button></td>
			</tr>
			</table>
		</form>
		
		<!-- List of users ***************************************** -->
		<br>
		<br>
		<br>
		<ul>
					
					
					
					<p id="user_list">List of available users </p>
						
			
					

					<?php
					//3.use returned data(if any)
					$user_result = get_all_users();
					
					while($user = mysqli_fetch_assoc($user_result)){
							
						echo "<li id='user_li'>";
						echo $user['username'];
						echo "</li>";
						
				 } 
				 ?>
					<?php
					//release data
					mysqli_free_result($user_result);
					?>
				</ul>
				


		
	</div>


	<?php require("includes/footer.php"); ?>