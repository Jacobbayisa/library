<?php session_start();?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php

if(isset($_POST['submit'])){
	global $connection;


	//process the form
	//Nb subject_id comes from value properties of options;
	$id = mysql_prep($_POST['subject_id']);
	$selected_book  =get_selected_subject_book($id);
	if(mysqli_num_rows($selected_book)>0){
		$_SESSION["message"] = "Can't delete a subject with books";
		redirect_to("admin.php");
	}
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
