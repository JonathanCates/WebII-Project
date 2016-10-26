<!DOCTYPE html>
<html lang=en>
<head>
<meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
    <script src="js/misc.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">
</head>
<?php
	include "includes/db.php";
	include "includes/sql-statements.php";
	
	$id;		
	function setID()
	{
		global $id;
		if(isset($_GET['id']))
		{
			if(filter_var($_GET['id'], FILTER_VALIDATE_INT))
			{
				$id = $_GET['id'];
			}
			else
			{
				//set default if no query string or error in query string
				$id = 1;	
			}
		}
			else
		{
			//set default if no query string or error in query string
			$id = 1;	
		}
	}
	
	function printHeader()
	{
		global $id;
		$singleGenreHeader = fetchSingleGenreHeader($id);
		$result = getPDO($singleGenreHeader);
		$row = $result->fetch();
		
		echo '
			<img class = "ui left floated image" src="images/art/genres/square-medium/'.$row['GenreID'].'.jpg">
			<h1 class="ui huge header">'.$row['GenreName'].'</h1>
			<p>'.$row['Description'].'</p>
		';
	}
	
	
	function listPaintings()
	{
		global $id;
		$singleGenre = fetchSingleGenre($id);
		$result = getPDO($singleGenre);
		while($row = $result->fetch())
		{
			echo'
				<div class = "column">
					<div class = "ui segment noimgpad">
						<a href="single-painting.php?id='.$row["PaintingID"].'">
							<img class = "ui fluid image" src="images/art/works/square-medium/'.$row['ImageFileName'].'.jpg">
						</a>	
					</div>
				</div>
			';
		}
	}
?>
<body >
    
<?php 
	include "includes/header.html"; 
	setID();
?>
 
<div class="ui secondary segment">
	<?php
		startConnection();
		printHeader(); 
	?>
</div>
   
<main>
	<div class="ui stackable six column grid">
	<div class="row">
		<div class="sixteen wide column">
			<h2 class="ui dividing header"> Paintings </h2>
		</div>
	</div>
		<?php
			
			listPaintings();
			killDBConnection();
		?>
	</div>
</main>
</body>
</html>