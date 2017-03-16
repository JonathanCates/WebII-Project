<!DOCTYPE html>
<html lang=en>
<head>
<meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/service-helper.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">

</head>
<?php
	include "includes/db.php";
	include "includes/sql-statements.php";

	function printFilters($pdo)
	{
		$allArtists = fetchAllArtistsByLastName();
		$artists = getPDO($pdo, $allArtists);
		
		$allMuseums = fetchAllMuseumsByName();
		$galleries = getPDO($pdo, $allMuseums);
		
		$allShapes = fetchAllShapesByName();
		$shapes = getPDO($pdo, $allShapes);
		
		echo'
		<div class="field">
			<label>Artist</label>
			<select class="ui search dropdown" id="artists" name ="artist">
			<option name="artist" value="0">Select Artist</option>
		';
		while($row = $artists->fetch())
		{
			echo'<option name="artist" value="'.$row["ArtistID"].'">'.$row["FirstName"].' '.$row["LastName"].'</option>';
		}
		echo'
			</select>
		</div>
		<div class="field">
			<label>Museum</label>
			<select class="ui search dropdown" id="museums" name="museum">
				<option name="museum" value="0">Select Museum</option>
		';
		while($row = $galleries->fetch())
		{
			echo'<option name="museum" value="'.$row["GalleryID"].'">'.$row["GalleryName"].'</option>';
		}
		echo'					
			</select>
		</div>
		<div class="field">
			<label>Shape</label>
			<select class="ui search dropdown" id="shapes" name="shape">
				<option name="shape" value="0">Select Shape</option>
		';
		while($row = $shapes->fetch())
		{
			echo'<option name="shape" value="'.$row["ShapeID"].'">'.$row["ShapeName"].'</option>';
		}
		echo'
			</select>
		</div>
		';
	}
	
?>
<body >    
<?php 
	$pdo = startConnection();
	include "includes/header.php"; 
?>
<main>
<div class = "ui container segment">
	<div class="ui grid">
		<div class="left floated four wide column">
			<h3 class="ui dividing header">Filters</h1>
			<form class ="ui form">
			<?php 
				printFilters($pdo);
				killDBConnection($pdo);
			?>
			</form>
		</div>
		<div class="left floated ten wide column">
			<div class="ui huge header" id="paintingTitle">Paintings</div>
			<div id="paintings">
			</div>
		</div>		
	</div>
</div>
</main>
</body>
</html>