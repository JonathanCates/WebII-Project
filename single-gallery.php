<!DOCTYPE html>
<html lang=en>
<head>
<meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/imageHover.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">
</head>
<?php

	function getMap($lat, $long)
	{
		echo '
		<div id="wrapper">
			<div id="map"></div>
	
			<script>
			  function initMap() {
			    var uluru = {lat: '.$lat.', lng: '.$long.'};
			    var map = new google.maps.Map(document.getElementById("map"), {
			      zoom: 17,
			      center: uluru
			    });
			    var marker = new google.maps.Marker({
			      position: uluru,
			      map: map
			    });
			    map.setOptions({draggable: false, zoomControl: false, scrollwheel: false, disableDoubleClickZoom: true, disableDefaultUI: true});
			  }
			</script>
			
			<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUoDoNpV1bvj-tlyroYWVENOeTRJw9D0w&callback=initMap">
			</script>';
	}
	
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
	
	function printHeader($pdo)
	{
		global $id;
		$singleGalleryHeader = fetchSingleGalleryHeader($id);
		$result = getPDO($pdo,$singleGalleryHeader);
		$row = $result->fetch();
		
		$lat=$row["Latitude"];
		$long=$row["Longitude"];
		
		echo getMap($lat, $long);
		echo '
			<div id="over_map">
				<a href="'.$row["GalleryWebSite"].'">
					<div class="ui inverted segment">
						<div class="ui huge header">'.$row['GalleryName'].'</div>
						<div class="meta">'.$row['GalleryCity'].", ".$row['GalleryCountry'].'</div>
					</div>
				</a>
			</div>
		</div>
		';
	}
	
	function listPaintings($pdo)
	{
		global $id;
		$singleGallery = fetchSingleGallery($id);
		$result = getPDO($pdo,$singleGallery);
		while($row = $result->fetch())
		{
			echo'
				<div class = "ui column">
					<div class = "ui card">
						<a href="single-painting.php?id='.$row["PaintingID"].'">
							<img class = "ui fluid image" name="painting" src="images/art/works/square-medium/'.$row['ImageFileName'].'.jpg">
						</a>
						<a href="favorites.php?type=painting&id='.$row['PaintingID'].'">
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
<body >
    
<?php 
	include "includes/header.php"; 
	setID();
	$pdo = startConnection();
	printHeader($pdo); 
?>
   
<main><br>
	<div class="ui container">
		<div class="ui stackable six column grid">
		<div class="row">
			<div class="sixteen wide column">
				<h2 class="ui dividing header"> Paintings</h2>
			</div>
		</div>
			<?php
				
				listPaintings($pdo);
				killDBConnection($pdo);
			?>
		</div>
	</div>
</main>
</body>
</html>