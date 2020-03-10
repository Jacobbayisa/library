<?php session_start();?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php 

	$ISBN = $_GET["ISBN"];
	if(!$ISBN){
		$_SESSION["message"] = "Error!Book deletion failed";
		redirect_to("admin.php");

	}else {
	$_SESSION["message"] = "selected Book has been successfully deleted";
	delete_book($ISBN);
	redirect_to('admin.php');
	}
	
	
	
	if(isset($_POST['submit'])){
			global $connection;
			//process the form
			//Nb subject_id comes from value properties of options;
			$ISBN= mysql_prep($_POST['ISBN']);
			$query = "DELETE FROM subjects  WHERE id = {$id} LIMIT 1";
			$result = mysqli_query($connection, $query);
			if($result){
				$_SESSION['message'] ="Subject Deleted successfully";
				redirect_to("admin.php");
			}else {
				$_SESSION['message'] ="Subject deletion failed!!";
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