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
		$singleArtistHeader = fetchSingleArtistHeader($id);
		$result = getPDO($pdo, $singleArtistHeader);
		$row = $result->fetch();
		
		echo '
			<img class = "ui left floated image" src="images/art/artists/square-medium/'.$row['ArtistID'].'.jpg">
			
			<div class="ui fluid container">
				<h1 class="ui huge header">'.$row['FirstName'].' '.$row['LastName'].'</h1>
				<a href="favorites.php?type=artist&id='.$row['ArtistID'].'">
					<button class="ui  button">
						<i class="heart icon"></i>
					</button>
				</a>
				<h2>'.$row['YearOfBirth'].' - '.$row['YearOfDeath'].' | '.$row['Nationality'].'</h2>
				<p>'.$row['Details'].'</p>
			</div>
			';
	}
	
	
	function listPaintings($pdo)
	{
		global $id;
		$singleAtistPaintings = fetchSingleArtistPaintings($id);
		$result = getPDO($pdo, $singleAtistPaintings);
		while($row = $result->fetch())
		{
			echo'
				<div class = "ui column">
					<div class = "ui card">
						<a href="single-painting.php?id='.$row["PaintingID"].'">
							<img class = "ui fluid image" name="painting" src="images/art/works/square-medium/'.$row['ImageFileName'].'.jpg">
						</a>
						<div class = "content">
							<a class = "header" href="single-painting.php?id='.$row["PaintingID"].'">'.$row['Title'].'</a>
						</div>	
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
?>
 
<div class="ui secondary segment">
	<?php 
		$pdo = startConnection();
		printHeader($pdo); 
	?>
</div>
   
<main>
	<div class = "ui container">
		<div class="ui stackable six column grid">
		<div class="row">
			<div class="sixteen wide column">
				<h2 class="ui dividing header"> Paintings </h2>
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