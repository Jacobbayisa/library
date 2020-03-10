<?php require_once("includes/session.php");?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php 
if (!logged_in()) {
	redirect_to("login.php");
}
?>

<html>
	<head>
		<title>NTUST ONLINE LIBRARY</title>
		<link href="stylesheets/public.css?<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="header">
			<h1>NTUST ONLINE LIBRARY</h1>
			<h1 > <a href ="create_user.php ">Manage Admin </a></h1>
			<h1 > <a href="logout.php">Logout</a></h1>
			
		</div>
		<div id="main">


<div id="main">

	<div id="navigation">

		<ul>
			<li id="nav_title">Categories </>
				<hr>
			
			<li><a href="admin.php?subject=all"> All </a></li>

			<?php
			//3.use returned data(if any)
			$subject_result = get_all_subjects();
			$selected_subject_id = null;

			if(isset($_GET["subject"])){
				$selected_subject_id = $_GET["subject"];
			}

			while($subject = mysqli_fetch_assoc($subject_result)){
					
				?>
				<?php
				echo "<li ";
				if($subject["id"] == $selected_subject_id){
					echo "class =\"selected\"";
				};
				echo ">";
				?>

			<a href="admin.php?subject=<?php echo 
			($subject["id"]); ?> "> <?php echo $subject ["subject_name"]; ?> </a>
			</li>

			<?php  } ?>
			<?php
			//release data
			mysqli_free_result($subject_result);
			?>
		</ul>
		<!-- Display Message ********************* -->
		<p class= "message"> <?php message();?> <p>
		<!-- Create Subject *************** -->
		<form id="add_subject" action="create_subject.php" method="post">
			<label for="subject_name"> <span id="add_symbol">+</span> Add Subject
			</label> <input type='text' placeholder="Enter Subject Name"
				name="subject_name" id="subject_name" required> </input> <br>
			<button type="submit" name="submit" id="create_button">Create </button>
		
		</form>
		
		<!-- Create Subject *************** -->

		<form id="delete_subject" action="delete_subject.php" method="post">
			<label for="subject_id"> <span id="delete_symbol">-</span> Delete Subject </label>
				<select id ="subject_id" name="subject_id" >
						<?php
						//3.use returned data(if any)
						$subject_result = get_all_subjects();
						$selected_subject_id = null;

						if(isset($_GET["subject"])){
							$selected_subject_id = $_GET["subject"];
						}

						while($subject = mysqli_fetch_assoc($subject_result)){

							?>
							<option value="<?php echo $subject['id']?>">
							<?php echo $subject['subject_name']?>
							</option>

							<?php  } ?>
							<?php
							mysqli_free_result($subject_result);
							?>
					</select> <br>
			<button type="submit" name="submit" id="create_button" onclick ="return confirm('Are you you sure?')"> Delete </button>
		
		</form>
		
	
	

	</div>


	<div id="page">
		
		<!-- Upload books -->
		<form name="form1" method="post" action="admin.php?>"
			enctype="multipart/form-data">

			<table id="upload_table" style="float: right"; margin-right: 10px">
				<caption id="caption">Upload Book</caption>

				<tr>
					<td>Subject_name:</td>
					<td><select class="form_input" name="select1"
						id="subject_name_select">
						<?php
						//3.use returned data(if any)
						$subject_result = get_all_subjects();
						$selected_subject_id = null;

						if(isset($_GET["subject"])){
							$selected_subject_id = $_GET["subject"];
						}

						while($subject = mysqli_fetch_assoc($subject_result)){

							?>
							<option value="<?php echo $subject['id']?>">
							<?php echo $subject['subject_name']?>
							</option>

							<?php  } ?>
							<?php
							mysqli_free_result($subject_result);
							?>
					</select>
					</td>
				</tr>
				<tr>
					<td>ISBN</td>
					<td><input type="text" name="ISBN" required class="form_input" />
					</td>
				</tr>
				<tr>
					<td>Title:</td>
					<td><input type="text" name="title" required class="form_input" />
					</td>
				
				
				<tr>
				
				
				<tr>
					<td>Author:</td>
					<td><input type="text" name="author" required class="form_input" />
					</td>
				
				
				<tr>
				
				
				<tr>
					<td>Edition:</td>
					<td><input type="text" name="edition" required class="form_input" />
					</td>
				
				
				<tr>
				
				
				<tr>
					<td>Upload:</td>
					<td><input type="file" name="f" required />
					</td>
				
				
				<tr>
				
				
				<tr>
					<td><input type="submit" name="submit1" value="submit" required></td>
				
				
				<tr>
			
			</table>
			
			
			<?php



			if(isset($_POST["submit1"])){

				define ('SITE_ROOT', realpath(dirname(__FILE__)));
				$ISBN = mysql_prep($_POST['ISBN']);
				$subject_id = mysql_prep($_POST['select1']);
				$title = mysql_prep($_POST['title']);
				$author = mysql_prep($_POST['author']);
				$edition = mysql_prep($_POST['edition']);


				$fnm = $_FILES["f"]["name"];
				$dst = "./books/".$fnm;
				$tmp_location = $_FILES['f']['tmp_name'];
				if(move_uploaded_file($tmp_location,$dst)){

					$query ="INSERT INTO books(ISBN,subject_id,title,author,edition,path)values('$ISBN','$subject_id','$title','$author','$edition','$dst')";
					$query1 = mysqli_query($connection,$query);
					confirm_query($query1);
					if($query1== true){
						echo "<h1 style ='color:green'> File is inserted to database successfully !! </h1>";
					} else {
						unlink($path);
						echo "Data Entry Unsuccessfull";
					}
				} else {
					echo "<h1 style ='color:red'> File upload not successfull !! </h1>";
				}


			}

			?>

			<ul>


			<?php
			if(isset($_GET["subject"])){
					
				// of a;; categorie is clicked

				if(($_GET["subject"] == "all")){
					$all_books = get_all_books();
					while($books = mysqli_fetch_assoc($all_books)){
						?>

				<table id="admin_book_table">
					<tr>
						<td id='admin_first_col'>
							<li><a id="title"
								href='download.php?name=read&ISBN=<?php echo $books["ISBN"]?>'>
								<?php echo "{$books['title']} (Ed.{$books['edition']})"; ?> </a>
						
						</td>

						<td id='second_col'><a id='read'
							href='download.php?name=read&ISBN=<?php echo $books["ISBN"] ?>'>
								Read </a> &nbsp;&nbsp; <a id='download'
							href='download.php?name=dbook&ISBN=<?php echo $books["ISBN"] ?>'>
								Download </a> &nbsp;&nbsp;
								<a id ='delete_link' href='delete.php?ISBN=<?php echo $books["ISBN"]?>'> Delete </a>
							</li>
						</td>
					</tr>

				</table>
				
				<?php
					}
				} else {
					$selected_subject_id = $_GET["subject"];

					$book_result = get_selected_subject_book($selected_subject_id);
					while($books = mysqli_fetch_assoc($book_result)){
						?>
				<table id="admin_book_table">
					<tr>
						<td id='admin_first_col'>
							<li><a id="title"
								href='download.php?name=read&ISBN=<?php echo $books["ISBN"]?>'>
								<?php echo "{$books['title']} (Ed.{$books['edition']})"; ?> </a>
						
						</td>

						<td id='second_col'><a id='read'
								href='download.php?name=read&ISBN=<?php echo $books["ISBN"] ?>'>
								Read </a> &nbsp;&nbsp; 
								<a id='download' href='download.php?name=dbook&ISBN=<?php echo $books["ISBN"] ?>'>
								Download </a> &nbsp;&nbsp;
								<a id ='delete_link' href='delete.php?ISBN=<?php echo $books["ISBN"]?>'> Delete </a> </li>
						</td>
					</tr>

				</table>
				<?php
					}
				}
			} else {
				$selected_subject_id = null;
			}
			?>
			</ul>
			
	
	</div>
</div>
			<?php require("includes/footer.php"); ?>
