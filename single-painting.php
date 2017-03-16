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
<body >
    
<?php 
	include "includes/header.php"; 
	include "includes/db.php";
	include "includes/sql-statements.php";	
	include "includes/single-painting-functions.php";
?>
    
<main>
    <!-- Main section about painting -->
	<?php 
		setID();
		$pdo = startConnection();
		getAllSinglePaintingData($pdo);
	?>
	<section class="ui segment grey100">
		<div class="ui doubling stackable grid container">
			<?php printImage($pdo, $imageFileName);?>
				<div class="seven wide column">	
					<?php printMainInfo($pdo, $title,$artistID,$artist,$excerpt,$averageStars); ?>                
					<!-- Tabs For Details, Museum, Genre, Subjects -->
					<div class="ui top attached tabular menu ">
						<a class="active item" data-tab="details"><i class="image icon"></i>Details</a>
						<a class="item" data-tab="museum"><i class="university icon"></i>Museum</a>
						<a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a>
						<a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a>    
					</div>
					<?php
						printDetailsTab($pdo, $artistID,$artist,$year,$medium,$width,$height);
						printMuseumTab($pdo, $galleryID,$museum,$accessionNum,$copyright,$url);
						printGenresTab($pdo, $genres);
						printSubjectsTab($pdo, $subjects);
						printCart($pdo, $cost, $frames, $glass, $matts, $id); 
					?> 					
				</div>	<!-- END RIGHT data Column --> 
		</div>		<!-- END Grid --> 
	</section>		<!-- END Main Section --> 
    
	<!-- Tabs for Description, On the Web, Reviews -->
	<section class="ui doubling stackable grid container">
		<div class="sixteen wide column">
			<div class="ui top attached tabular menu ">
				<a class="active item" data-tab="first">Description</a>
				<a class="item" data-tab="second">On the Web</a>
				<a class="item" data-tab="third">Reviews</a>
			</div>	
			<?php
				printDescriptionTab($pdo, $description);
				printOnTheWebTab($pdo, $wikiLink,$googleLink,$googleText);
				printReviewsTab($pdo, $reviews);  
				killDBConnection($pdo);
			?>
		</div>        
	</section> <!-- END Description, On the Web, Reviews Tabs --> 
</main>    
    <!-- Related Images ... will implement this in assignment 2 -->    
    <section class="ui container">
    <h3 class="ui dividing header">Related Works</h3>        
	</section> 

    
  <footer class="ui black inverted segment">
      <div class="ui container">footer</div>
  </footer>
</body>
</html>