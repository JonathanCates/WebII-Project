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

	function printFilters()
	{
		$allArtists = fetchAllArtistsByFirstName();
		$artists = getPDO($allArtists);
		
		$allMuseums = fetchAllMuseumsByName();
		$galleries = getPDO($allMuseums);
		
		$allShapes = fetchAllShapesByName();
		$shapes = getPDO($allShapes);
		
		echo'
		<div class="field">
			<label>Artist</label>
			<select class="ui search dropdown" name ="artist">
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
			<select class="ui search dropdown" name="museum">
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
			<select class="ui search dropdown" name="shape">
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
	
	function printPaintings()
	{	
		echo'<h2 class="ui sub header">';	
		if(isset($_GET['searchBy']))
		{
			$searchBy = $_GET['searchBy'];
			$sql = filterBySearch($searchBy);
			$pdo = getPDO($sql);
			$row = getNext($pdo);
			echo'Searched for titles and descriptions containing: '.$searchBy;		
		}
		else if(isset($_GET['artist']))
		{
			$artistID = $_GET['artist'];
			$museumID = $_GET['museum'];
			$shapeID = $_GET['shape'];

			//Didn't read the spec close enough, all combinations of filters are here AND ARE STAYING
			if($artistID != 0 && $museumID == 0 && $shapeID == 0) //filter by artist only
			{
				$sql=filterByArtist($artistID);
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'Artist = '.$row['FirstName'].' '.$row['LastName'];				
			}
			else if($artistID == 0 && $museumID != 0 && $shapeID == 0) //museum only
			{
				$sql=filterByMuseum($museumID);
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'Museum = '.$row['GalleryName'];
			}
			else if($artistID == 0 && $museumID == 0 && $shapeID != 0) //shape only
			{
				$sql=filterByShape($shapeID);
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'Shape = '.$row['ShapeName'];
			}
			else if($artistID == 0 && $museumID != 0 && $shapeID != 0) //museum and shape
			{
				$sql=filterByMuseumShape($museumID,$shapeID);
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'Museum = '.$row['GalleryName'].' | ';
				echo'Shape = '.$row['ShapeName'];
			}
			else if($artistID != 0 && $museumID == 0 && $shapeID != 0) //artist and shape
			{
				$sql=filterByArtistShape($artistID, $shapeID);
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'Artist = '.$row['FirstName'].' '.$row['LastName'].' | ';	
				echo'Shape = '.$row['ShapeName'];
			}
			else if($artistID != 0 && $museumID != 0 && $shapeID == 0) //artist and museum
			{
				$sql=filterByArtistMuseum($artistID, $museumID);
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'Artist = '.$row['FirstName'].' '.$row['LastName'].' | ';	
				echo'Museum = '.$row['GalleryName'];
			}
			else if($artistID == 0 && $museumID == 0 && $shapeID == 0) //if user pressed filter with no values set
			{
				$sql=filterByNothing();
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'ALL PAINTINGS [TOP 20]';
			}
			else
			{
				$sql=filterByArtistMuseumShape($aritstID,$museumID,$shapeID); //filter by all		
				$pdo = getPDO($sql);
				$row = getNext($pdo);
				echo'Artist = '.$row['FirstName'].' '.$row['LastName'].' | ';	
				echo'Museum = '.$row['GalleryName'].' | ';
				echo'Shape = '.$row['ShapeName'];
			}
		}
		else
		{
			$sql=filterByNothing(); //<- what that says
			$pdo = getPDO($sql);
			$row = getNext($pdo);
			echo'ALL PAINTINGS [TOP 20]';
		}	
		echo '</h2>';
		
		$dataCount = $pdo->rowCount();
		$maxPaintings = 19;
		$loopCount = 0;
		echo'
			<table class="ui very basic table">
			<tbody>
		';
			while($loopCount <= $maxPaintings && $loopCount < $dataCount)
			{
				echo'
				<tr>
					<td>
						<a href="single-painting.php?id='.$row['PaintingID'].'">
							<img src="images/art/works/square-medium/'.$row['ImageFileName'].'.jpg" alt="..." id="artwork">
						</a>							
					</td>
					<td>
						<h3 class="ui large header">'.$row['Title'].'</h3>
						<h2 class="ui sub header">
							'.$row['FirstName'].' '.$row['LastName'].'
						</h2>
						<p>'.$row['Description'].'</p>
						<p>$'.floor($row['MSRP']).'</p>
						<button class="ui orange button"><i class="shop icon"></i></button>
						<button class="ui button"><i class="heart icon"></i></button>
					</td>
				</tr>';
				$loopCount++;
				$row = getNext($pdo);
			}
	}
?>
<body >    
<?php 
	include "includes/header.html";	
	startConnection();
?>
<main>
<div class = "ui container segment">
	<div class="ui grid">
		<div class="left floated four wide column">
			<h3 class="ui dividing header">Filters</h1>
			<form class ="ui form" action="browse-paintings.php" method="GET">
			<?php printFilters();?>
				<button class="ui orange button" type="submit"><i class="filter icon"></i>Filter</button>
			</form>
		</div>
		<div class="left floated ten wide column">
			<div class="ui huge header">Paintings</div>
			<?php 
				printPaintings(); 
				killDBConnection();
			?>
			</div>
		</div>		
	</div>
</div>
</main>
</body>
</html>