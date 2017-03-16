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
	
	function printHeader()
	{
		$date = getDate();
		echo '
			<div class="ui fluid container">
				<h1 class="ui huge header">Jonathan Cates & Priyash Bista</h1>
				<h2>COMP 3512 - 001 | '.$date['month'].' '.$date['mday'].' '.$date['year'].'</h2>
				<h2>Site created for Mount Royal University, COMP 3512 taught by Randy Connolly</h2>
				<h5>Site is hypotheical</h5>
			</div>
		';
	}
	
?>
<body >
    
<?php 
	include "includes/header.php"; 
?>
 
<div class="ui secondary segment">
	<?php 
		printHeader(); 
	?>
</div>
   
<main>
	<div class="ui text container">
		<h3>Outside Resources</h3>
		<ul>
			<li>
				Semantic CSS
			</li>
			<li>
				All paintings, thumbnails and artist images
			</li>
			<li>
				MySQL artist database
			</li>
			<li>
				Layout for index.php and single-painting.php
			</li>
		</ul>
		<h3>Task Delegation</h3>
			<h4>Jonathan</h4>
				<ul>
					<li>
						All functionality related to favorites
					</li>
					<li>
						All functionality related to cart
					</li>
					<li>
						Base layout for cart page
					</li>
					<li>
						Search bar functionality
					</li>
					<li>
						Changes to single painting - correct links to cart & favorites, average reviews, subject links & labels
					</li>
					<li>
						Browse painting - correct links to cart and favorites
					</li>
					<li>
						Count of items in cart & favorites in header link location
					</li>
					<li>
						ASSIGNMENT 3: Cart Javascript
					</li>
					<li>
						ASSIGNMENT 3: Connected Browse Paintings to use JSON Object
					</li>
				</ul>
			<h4>Priyash</h4>
			<ul>
				<li>
					Gallery single and browse pages
				</li>
				<li>
					Subject single and browse pages
				</li>
				<li>
					Grids to Semantic UI
				</li>
				<li>
					Select * to regular statements
				</li>
				<li>
					Grids to Semantic UI
				</li>
				<li>
					Added favorites button
				</li>
				<li>
					Design elemets for favourites and cart pages
				</li>
				<li>
					ASSIGNMENT 3: Create JSON object
				</li>
				<li>
					ASSIGNMENT 3: Hover
				</li>
			</ul>
	</div>

</main>
</body>
</html>