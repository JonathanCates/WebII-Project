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
	
	function printArtists($pdo)
	{
		$browseArtists = fetchAllArtists();
		$result = getPDO($pdo, $browseArtists);
		while($row = $result->fetch())
		{
			echo'
				<div class = "ui column">
					<div class = "ui card">
						<a href="single-artist.php?id='.$row["ArtistID"].'">
							<img class = "ui fluid image" src="images/art/artists/square-medium/'.$row['ArtistID'].'.jpg">
						</a>
						<div class = "content">
							<a class = "header" href="single-artist.php?id='.$row["ArtistID"].'">'.$row['FirstName'].' '.$row['LastName'].'</a>
						</div>
						<a href="favorites.php?type=artist&id='.$row['ArtistID'].'">
							<button class="fluid ui button">
								<i class="heart icon"></i>
							</button>
						</a>
					</div>
				</div>
			';
		}
	}
?>
<body>
    
<?php include "includes/header.php"; ?>

<div class="banner-container">
	<div class="ui inverted segment artist-banner">
		<h1 class="ui huge header">Artists</h1>
	</div>  
</div>
    
<main>
	<div class="ui container">	
		<div class="ui stackable six column grid">
			<?php 
				$pdo = startConnection();
				printArtists($pdo);
				killDBConnection($pdo);
			?>
		</div>
	</div>
</main>
</body>
</html>