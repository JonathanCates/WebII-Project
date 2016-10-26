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
	
	function printGenres()
	{
		$browseGenres = fetchAllGenres();
		$result = getPDO($browseGenres);
		while($row = $result->fetch())
		{
			echo'
				<div class = "column">
					<div class = "ui segment noimgpad">
						<a href="single-genre.php?id='.$row["GenreID"].'">
							<img class = "ui fluid image" src="images/art/genres/square-medium/'.$row['GenreID'].'.jpg">
							<h3>'.$row['GenreName'].'</h3>
						</a>	
					</div>
				</div>
			';
		}
	}
?>
<body>
    
<?php include "includes/header.html"; ?>
 
<div class="genre-banner">
	<h1 class="ui huge header">Genres</h1>
</div>  
    
<main>
	<div class="ui stackable six column grid">
		<?php 
			startConnection();
			printGenres();
			killDBConnection();
		?>
	</div>
</main>
</body>
</html>