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
				<h1 class="ui huge header">Jonathan Cates</h1>
				<h2>COMP 3512 - 001 | '.$date['month'].' '.$date['mday'].' '.$date['year'].'</h2>
			</div>
		';
	}
	
?>
<body >
    
<?php 
	include "includes/header.html"; 
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
	</div>

</main>
</body>
</html>