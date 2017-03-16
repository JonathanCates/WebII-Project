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
		$singleSubjectHeader = fetchSingleSubjectHeader($id);
		$result = getPDO($pdo,$singleSubjectHeader);
		$row = $result->fetch();
		
		echo '
			<img class = "ui left floated image" src="images/art/subjects/square-medium/'.$row['SubjectID'].'.jpg">
			<h1 class="ui huge header">'.$row['SubjectName'].'</h1>
			<p>This page contains all '.$row['SubjectName'].' paintings</p>
		';
	}
	
	
	function listPaintings($pdo)
	{
		global $id;
		$singleGenre = fetchAllSubjectPaintings($id);
		$result = getPDO($pdo,$singleGenre);
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
?>
 
<div class="ui secondary segment">
	<?php
		$pdo = startConnection();
		printHeader($pdo); 
	?>
</div>
   
<main>
	<div class="ui container">
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