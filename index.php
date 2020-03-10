<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php // include("includes/header.php"); ?>

<html>
<head>
<title>NTUST ONLINE LIBRARY</title>
<link href="stylesheets/public.css?<?php echo time(); ?>" media="all"
	rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="header">
		<h1>NTUST ONLINE LIBRARY</h1>
		<h1  id ="admin_head" ><a id= "login_link" href ="login.php" > Admin</a></h1>
		
		

	</div>
	
	<div id="main">

		<div id="main">

			<div id="navigation">

				<ul>
					<li id="nav_title">Categories </>
						<hr>
					
					<li><a href="index.php?subject=all"> All </a></li>

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

					<a href="index.php?subject=<?php echo 
					($subject["id"]); ?> "> <?php echo $subject ["subject_name"]; ?> </a>
					</li>

					<?php  } ?>
					<?php
					//release data
					mysqli_free_result($subject_result);
					?>
				</ul>
			</div>


			<div id="page">
		
				<ul>


				<?php
				
				if(isset($_GET["subject"])){

					// of a;; categorie is clicked
					
					if(($_GET["subject"] == "all")){
						$all_books = get_all_books();
						while($books = mysqli_fetch_assoc($all_books)){
							?>

					<table id="book_table">
						<tr>
							<td id='first_col'>
								<li><a id="title"
									href='download.php?name=read&ISBN=<?php echo $books["ISBN"]?>'>
									<?php echo "{$books['title']} (Ed.{$books['edition']})"; ?> </a>
							
							</td>

							<td id='second_col'><a id='read'
								href='download.php?name=read&ISBN=<?php echo $books["ISBN"] ?>'>
									Read </a> &nbsp;&nbsp; <a id='download'
								href='download.php?name=dbook&ISBN=<?php echo $books["ISBN"] ?>'>
									Download </a>
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
					<table id="book_table">
						<tr>
							<td id='first_col'>
								<li><a id="title"
									href='download.php?name=read&ISBN=<?php echo $books["ISBN"]?>'>
									<?php echo "{$books['title']} (Ed.{$books['edition']})"; ?> </a>
							</li>
							</td>

							<td id='second_col'><a id='read'
								href='download.php?name=read&ISBN=<?php echo $books["ISBN"] ?>'>
									Read </a> &nbsp;&nbsp; <a id='download'
								href='download.php?name=dbook&ISBN=<?php echo $books["ISBN"] ?>'>
									Download </a>
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