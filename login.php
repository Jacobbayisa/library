<?php require_once("includes/connection.php"); ?>
<?php include_once("includes/functions.php"); ?>
<?php require_once("includes/session.php");?>
<?php require_once ("includes/form_functions.php");?>


<?php
if (logged_in()) {
	redirect_to("admin.php");
}



// START FORM PROCESSING
if (isset($_POST['submit'])) { // Form has been submitted.
	$errors = array();

	// perform validations on the form data
	$required_fields = array('username', 'password');
	$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

	$fields_with_lengths = array('username' => 30, 'password' => 30);
	$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

	$username = trim(mysql_prep($_POST['username']));
	$password = trim(mysql_prep($_POST['password']));
	
	if ( empty($errors) ) {
		// Check database to see if username and the hashed password exist there.
		$query = "SELECT id, username ";
		$query .= "FROM admin ";
		$query .= "WHERE username = '{$username}' ";
		$query .= "AND hashed_password = '{$password}' ";
		$query .= "LIMIT 1";
		$result_set = mysqli_query($connection,$query);
		confirm_query($result_set);
		if (mysqli_num_rows($result_set) == 1) {
			// username/password authenticated
			// and only 1 match
			$found_user = mysqli_fetch_array($result_set);
			$_SESSION['user_id'] = $found_user['id'];
			$_SESSION['username'] = $found_user['username'];

			redirect_to("admin.php");
		} else {
			// username/password combo was not found in the database
			$message = "Username/password combination incorrect.<br />";
		}
	} else {
		if (count($errors) == 1) {
			$message = "There was 1 error in the form.";
		} else {
			$message = "There were " . count($errors) . " errors in the form.";
		}
	}

} else { // Form has not been submitted.
	if (isset($_GET['logout']) && $_GET['logout'] == 1) {
		$message = "You are now logged out.";
	}
	$username = "";
	$password = "";
}
?>

<?php include("includes/header.php"); ?>
<div id="main">

	<div id="navigation">
		<h2> </h2><a id ="home_link" href="index.php">HOME</a> </h2>
	
	</div>

	<div id="page">

		<h1 style ="color:brown">Staff Login</h1>
		<?php if (!empty($message)) {echo "<h1 class=\"login_message\">" . $message . "</h1>";} ?>
		<?php if (!empty($errors)) { display_errors($errors); } ?>
		
		<form action="login.php" method="post">
			<table id="login_table">
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="30"
						value="<?php echo htmlentities($username); ?>" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" maxlength="30"
						value="<?php echo htmlentities($password); ?>" /></td>
				</tr>
				<tr>
					<td colspan="2" ><input type="submit" name="submit" value="Login" style ="width:200px"/>
					</td>
				</tr>
			</table>
		</form>
		</td>
		</tr>
		</table>

	</div>


	<?php require("includes/footer.php"); ?>