<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>


<?php include("includes/header.php"); ?>
<div id="main">
	<div id="navigation"></div>


	<div id="page">
		<form name="form1" method="post" action="upload.php"
			enctype="multipart/form-data">

			<table id="upload_table">
				<caption id="caption">Upload Book</caption>
				<tr>
					<td>ISBN</td>
					<td><input type="text" name="ISBN" required class="form_input" />
					</td>
				</tr>
				<tr>
					<td>Subject_name:</td>
					<td><select class="form_input"  name="select1" id="subject_name_select">
					<?php
					//3.use returned data(if any)
					$subject_result = get_all_subjects();
					$selected_subject_id = null;

					if(isset($_GET["subject"])){
						$selected_subject_id = $_GET["subject"];
					}

					while($subject = mysqli_fetch_assoc($subject_result)){
						
						?>
						<option value="<?php echo $subject['id']?>"> <?php echo $subject['subject_name']?> </option>
						    
							<?php  } ?>
							<?php
							mysqli_free_result($subject_result);
							?>
					</select>
					</td>
				
				
				<tr>
				
				
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
						echo "<h1 style ='color:green'> File uploaded to server successfully !! </h1>";
					} else {
						unlink($path);
						echo "Data Entry Unsuccessfull";
					}
				} else {
					echo "<h1 style ='color:red'> File upload not successfull !! </h1>";
				}


			}

			?>
	
	</div>
</div>
<?php require("includes/footer.php"); ?>
