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
	
	function printGalleries($pdo)
	{
		$browseGalleries = fetchAllGalleries();
		$result = getPDO($pdo, $browseGalleries);
		while($row = $result->fetch())
		{
			echo'
				<div class = "ui column">
					<a href="single-gallery.php?id='.$row["GalleryID"].'">
						<div class = "ui card">
							<div class="content">
								<i class="right floated university icon"></i>
								<div class="header">'.$row['GalleryName'].'</div>
								<div class="meta"> '.$row['Latitude'].', '.$row['Longitude'].'</div>
								<div class="paragraph">'.$row['GalleryCity'].', '.$row['GalleryCountry'].' </div>
							</div>
						</div>
					</a>
				</div>
			';
		}
	}
?>
    
<?php 	include "includes/header.php"; ?>
 
<div class="alt-banner-container">
	<div class="ui inverted segment gallery-banner">
		<h1 class="ui huge header">Galleries</h1>
	</div>
</div>  

<main>
	<div class="ui container">
		<div class="ui stackable four column grid">
			<?php 
				$pdo = startConnection();
				printGalleries($pdo);
				killDBConnection($pdo);
			?>
		</div>
	</div>
</main>
</body>
</html>