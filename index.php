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
<body>
    
<?php
	include_once "includes/favorite-artists.php";
	include_once "includes/favorite-paintings.php";
	include_once "includes/cart-class.php";
	
	session_start();
	
	if(!isset($_SESSION['favArtists']))
	{
		$_SESSION['favArtists'] = serialize(new favArtists());
	}
	if(!isset($_SESSION['favPaintings']))
	{
		$_SESSION['favPaintings'] = serialize(new favPaintings());
	}
	if(!isset($_SESSION['cart']))
	{
		$_SESSION['cart'] = serialize(new shoppingCart());
	}
	
	include "includes/header.php"; 
	
	if(isset($_POST['frame0']))// check if a value exists in the post, meaning there's been an update to the cart
	{
		$cartObject = unserialize($_SESSION['cart']);
		$cart = $cartObject->getList();
		
		for($i = 0; $i < count($cart); $i++)
		{
			if($_POST['quantity'.$i] <= 0)
			{
				$cartObject->remove($cart[$i], true);
			}
			else 
			{
			$newValues = array(
				'frame' => $_POST['frame'.$i], 
				'glass' => $_POST['glass'.$i], 
				'matt' => $_POST['matt'.$i], 
				'quantity' => $_POST['quantity'.$i]);
				
				$cartObject->updateCart($newValues, $cart[$i], $i);
			}
		}
		$_SESSION['cart'] = serialize($cartObject);
	}
?>
 
<div class="hero-container">
    <div class="ui text container">
        <h1 class="ui huge header">Decorate your world</h1>
        <a href ="browse-paintings.php" class="ui huge orange button" >Shop Now</a>
    </div>  
</div>  
<h2 class="ui horizontal divider"><i class="tag icon"></i> Deals</h2>   
    
<main>
	<div class="ui container">
		<div class ="ui three cards">
			<div class="card">
				<div class="image">
					<img src="images/art/works/medium/107050.jpg">
				</div>
				<div class="content">
					<div class="description">
						Experience the sensuous pleasures of the French Rococco
					</div>
				</div>
				<div class="ui bottom attached button">
					<a href="single-genre.php?id=83">
						<i class="info circle icon large"></i>
						See More
					</a>
				</div>
			</div>
			<div class="card">
				<div class="image">
					<img class="ui medium image" src="images/art/works/medium/126010.jpg">
				</div>
				<div class="content">
					<div class="description">
						Appeciate the quiet beauty of the Dutch Golden Age
					</div>
				</div>
				<div class="ui bottom attached button">
					<a href="single-genre.php?id=87">
						<i class="info circle icon large"></i>
						See More
					</a>
				</div>
			</div>
			<div class="card">
				<div class="image">
					<img class="ui medium image" src="images/art/works/medium/100030.jpg">
				</div>
				<div class="content">
					<div class="description">
						Discover the glorious color of the Renaissance
					</div>
				</div>
				<div class="ui bottom attached button">
					<a href="single-genre.php?id=78">
						<i class="info circle icon large"></i>
						See More
					</a>
				</div>
			</div>
		</div>
    </div>
</main>
</body>
</html>