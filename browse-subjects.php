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
	
	function printSubjects($pdo)
	{
		$browseSubjects = fetchAllSubjects();
		$result = getPDO($pdo,$browseSubjects);
		while($row = $result->fetch())
		{
			echo'
				<div class = "ui column">
					<div class = "ui card">
						<a href="single-subject.php?id='.$row["SubjectID"].'">
							<img class = "ui fluid image" src="images/art/subjects/square-medium/'.$row['SubjectID'].'.jpg">
						</a>
						<div class = "content">
							<a class = "header" href="single-subject.php?id='.$row["SubjectID"].'">'.$row['SubjectName'].'</a>	
						</div>
					</div>
				</div>
			';
		}
	}
?>
<body>
    
<?php include "includes/header.php"; ?>
 
<div class="banner-container">
	<div class="ui inverted segment subject-banner">
		<h1 class="ui huge header">Subjects</h1>
	</div>
</div>  
    
<main>
	<div class="ui container">
		<div class="ui stackable six column grid">
			<?php 
				$pdo = startConnection();
				printSubjects($pdo);
				killDBConnection($pdo);
			?>
		</div>
	</div>
</main>
</body>
</html>