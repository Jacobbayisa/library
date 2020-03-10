<?php 
	function redirect_to($new_location){
		header("Location: ". $new_location);
		exit;
	}
	function confirm_query($result) {
	if(!$result){
			die("Database query failed. ");
		}
	}
	function get_all_subjects(){
		global $connection;
		//2.perform database query
		$query = "SELECT * ";
		$query .= "FROM subjects ";
		//$query .= "WHERE visible = 1 ";
		$query .= "ORDER BY subject_name ASC";
		$result = mysqli_query($connection,$query);
		confirm_query($result);
		
		
		return $result;
	}
	
	function get_all_books(){
		global $connection;
		//2.perform database query
		$query = "SELECT * ";
		$query .= "FROM books ";
		$query .= "ORDER BY Title ASC";
		$all_books = mysqli_query($connection,$query);
		confirm_query($all_books);
		
		
		return $all_books;
	}
	
	function get_selected_subject_book($selected_subject_id){
		global $connection;
		//perform database query
		$query = "SELECT * ";
		$query .= "FROM books ";
		$query .= "WHERE subject_id = {$selected_subject_id} ";
		$query .= "ORDER BY Title ASC";
		$book_result = mysqli_query($connection,$query);
		confirm_query($book_result);
		
		return $book_result;
	}
	
	// get books by ISBN
	function get_book_By_ISBN($ISBN){
			global $connection;
			//perform database query
			$query = "SELECT * ";
			$query .= "FROM books ";
			$query .= "WHERE ISBN = {$ISBN} ";
			$book_result = mysqli_query($connection,$query);
			confirm_query($book_result);
			
			return $book_result;
		}
	
		
	
	// delete book By ISBN
	function delete_book($ISBN){
		global $connection;
		// retrieve book path by ISBN
		$book_result = get_book_By_ISBN($ISBN);
		$book = mysqli_fetch_assoc($book_result);
		$path = $book["path"];
		
		// delete book by ISBN
		$query = "DELETE FROM books WHERE ISBN = {$ISBN} LIMIT 1";
		$result = mysqli_query($connection,$query);
		
		if($result && mysqli_affected_rows($connection) == 1) {
			//success and delete book also from folder
			
			if(!unlink($path)){
				echo "You have an error!";
			} else {
				echo "You have deleted book from  database and folder successfully";
			}
		} else {
			confirm_query($result);
		}
			
	}// end of function delete_book($ISBN)
	
	// preprocessing input
	function mysql_prep($string){
		global $connection;
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	//get_all_users
	
	function get_all_users(){
		global $connection;
		//2.perform database query
		$query = "SELECT * ";
		$query .= "FROM admin ";
		$query .= "ORDER BY username ASC";
		$result = mysqli_query($connection,$query);
		confirm_query($result);
		
		
		return $result;
	}
	
function delete_user($username){
		global $connection;
		
		$query = "DELETE FROM admin WHERE username = '{$username}' LIMIT 1";
		$result = mysqli_query($connection,$query);
		confirm_query($result);
}
	
?>