<?php session_start();?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php 
	
		if(isset($_POST['submit'])){
			global $connection;
			//process the form
			$subject_name = mysql_prep($_POST['subject_name']);
			$query = "INSERT INTO subjects (";
			$query .= " subject_name";
			$query .= ") VALUES (";
			$query .= " '{$subject_name}'";
			$query .= ")";
			$result = mysqli_query($connection, $query);
			if($result){
				$_SESSION['message'] ="subject created sucessfully";
				redirect_to("admin.php");
			}else {
				$_SESSION['message'] ="subject creation failed";
				redirect_to("admin.php");
			}
			
		}else {
			//riderect it may be probably get request
		}
	
	
?>

<?php
	// 5. Close connection
	if(isset($connection)){
		mysqli_close($connection);
	}
?>
