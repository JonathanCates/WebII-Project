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
	include "includes/favorite-artists.php";
	include "includes/favorite-paintings.php";

	$favoritePaintingsObject;
	$favoriteArtistsObject;
	function checkID()
	{
		global $favoritePaintingsObject;
		global $favoriteArtistsObject;
		$favoritePaintingsObject = unserialize($_SESSION['favPaintings']);
		$favoriteArtistsObject = unserialize($_SESSION['favArtists']);
		if(isset($_GET['id']) && isset($_GET['type']) && ($_GET['type'] == "painting"))
		{
			if(filter_var($_GET['id'], FILTER_VALIDATE_INT))
			{
				$favoritePaintingsObject->add($_GET['id'],false);
			}
		}
		else if(isset($_GET['id']) && isset($_GET['type']) && ($_GET['type'] == "artist"))
		{
			if(filter_var($_GET['id'], FILTER_VALIDATE_INT))
			{
				$favoriteArtistsObject->add($_GET['id'],false);
			}
		}
		else if(isset($_GET['remove']) && isset($_GET['type']) && ($_GET['type'] == "painting"))
		{
			if(filter_var($_GET['remove'], FILTER_VALIDATE_INT))
			{
				$favoritePaintingsObject->remove($_GET['id'],false);
			}
			else if($_GET['remove'] == "all")
			{
				$favoritePaintingsObject->removeAll();
			}
		}
		else if(isset($_GET['remove']) && isset($_GET['type']) && ($_GET['type'] == "artist"))
		{
			if(filter_var($_GET['remove'], FILTER_VALIDATE_INT))
			{
				$favoriteArtistsObject->remove($_GET['id'],false);
			}
			else if($_GET['remove'] == "all")
			{
				$favoriteArtistsObject->removeAll();
			}
		}
		$_SESSION['favArtists'] = serialize($favoriteArtistsObject);
		$_SESSION['favPaintings'] = serialize($favoritePaintingsObject);
	}
	
	function printHeader()
	{
		echo '
			<div class="fav-banner-container">
				<div class="ui inverted segment gallery-banner">
					<h1 class="ui huge header">Favorites</h1>
				</div>
			</div>
		';
	}
	
	function listArtists($pdo)
	{
		global $favoriteArtistsObject;
		$favArtists = $favoriteArtistsObject->getList();
		if(empty($favArtists))
		{
			echo'
				<div class = "ui column">
					<h2>No favorite artists!</h2>
				</div>
				
			';
		}
		else 
		{
			for($i = 0;$i < count($favArtists); $i++)
			{
				$sql = $favoriteArtistsObject->getSql($favArtists[$i]);
				$row = getRow($pdo, $sql);
				echo '
					<div class = "ui column">
						<div class = "ui card">
							<div class = "image">
							<a class="ui red left corner label" href="favorites.php?type=artist&remove='.$favArtists[$i].'">
    							 <i class="remove icon"></i>
    						</a>
							<a href="single-artist.php?id='.$favArtists[$i].'">
								<img class = "ui fluid image" src="images/art/artists/square-medium/'.$favArtists[$i].'.jpg">
							</a>
							</div>
							<div class = "content">
								<a class = "header" href="single-artist.php?id='.$favArtists[$i].'">'.$row["FirstName"].' '.$row["LastName"].'</a>
							</div>
						</div>
					</div>
				';
			}
		}
	}
	
	function listPaintings($pdo)
	{
		global $favoritePaintingsObject;
		$favPaintings = $favoritePaintingsObject->getList();
		if(empty($favPaintings))
		{
			echo'
				<div class = "column">
					<h2>No favorite paintings!</h2>
				</div>
			';
		}
		else 
		{
			
			for($i = 0;$i < count($favPaintings); $i++)
			{
				$sql = $favoritePaintingsObject->getSql($favPaintings[$i]);
				$row = getRow($pdo, $sql);
				echo '
					<div class = "ui column">
						<div class= "ui card">
							<div class = "image">
								<a class="ui red left corner label" href="favorites.php?type=painting&remove='.$favPaintings[$i].'">
    								<i class="remove icon"></i>
    							</a>
    							<a href="single-painting.php?id='.$favPaintings[$i].'">
									<img class = "ui fluid image" src="images/art/works/square-medium/'.$row['ImageFileName'].'.jpg">
								</a>
							</div>
							<div class = "content">
								<a class = "header" href="single-painting.php?id='.$favPaintings[$i].'">'.$row['Title'].'</a>
							</div>
						</div>
					</div>
				';
			}
			
		}
	}
	
	function removeArtistsButton()
	{
		global $favoriteArtistsObject;
		$favArtists = $favoriteArtistsObject->getList();
		if(count($favArtists) > 0)
		{
			echo '
			<a href="favorites.php?type=artist&remove=all">
				<button class="right floated ui red button">
					Remove all favorite artists
					<i class="remove icon"></i>
				</button>
			</a>
			';
			
		}
	}
	
	function removePaintingsButton()
	{
		global $favoritePaintingsObject;
		$favPaintings = $favoritePaintingsObject->getList();
		if(count($favPaintings) > 0)
		{
			echo '
			<a href="favorites.php?type=painting&remove=all">
				<button class="right floated ui red button">
					Remove all favorite paintings
					<i class="remove icon"></i>
				</button>
			</a>
			';
		}
	}
?>
<body >
    
<?php 
	$pdo = startConnection();
	session_start();
	checkID();
	include "includes/header.php";
	printHeader();
?>
   
<main>
	
	<div class = "ui container">
		<div class = "ui red segment">
			<h1>Favorite Artists
			<?php
				removeArtistsButton();
			?>
			</h1>
		</div>
				<div class = "ui stackable four column grid">
					<?php 
						listArtists($pdo);
					?>
				</div>
		<div class = "ui red segment">
			<h1>Favorite Paintings
			<?php
				removePaintingsButton();
			?>
			</h1>
		</div>
			<div class = "ui stackable four column grid">
				<?php
					listPaintings($pdo);
					killDBConnection($pdo);
					?>
		</div>
	</div>
</main>
</body>
</html>