<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>


<?php include("includes/header.php"); ?>
	<div id = "main">
	<div id = "navigation">
		
		
	</div>
	<div id= "page">

<?php 
	$ISBN = $_GET["ISBN"];
	
	if(isset($ISBN)){
		
		$query1 = get_book_By_ISBN($ISBN);
		while($ros = mysqli_fetch_assoc($query1)){
			$path = $ros['path'];
			$name =$_GET["name"];
			if($name == "read"){
				header('Content-type:application/pdf');
				header('Content-Disposition:inline;filename="'.$path. '"');
				header('Content-Transfer-Encoding:binary');
				header('Accept-Ranges:bytes');
				@readfile($path);
			} else if ($name == "dbook"){
			
				header('content-Disposition: attachment; filename = '.$path.'');
				header('content-type:application/octet-stream');
				header('content-length='.filesize($path));
				readfile($path);
			}
		}
	}
?>

</div>
	</div>
<?php require("includes/footer.php"); ?>
