<!DOCTYPE html>
<html lang=en>
<head>
<meta charset=utf-8>
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="css/semantic.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/cartFunctionality.js"></script>
    
    <link href="css/semantic.css" rel="stylesheet" >
    <link href="css/icon.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet">

</head>
<?php
	include "includes/db.php";
	include "includes/sql-statements.php";
	include "includes/cart-class.php";
	$cartObject;
	$browsePaintingAddExist = false;
	$addZeroOrNegativeQuantity = false;
	
	function checkValues()
	{
		global $cartObject;
		$cartObject = unserialize($_SESSION['cart']);
		if(isset($_GET['id']) && isset($_POST['frame']) && isset($_POST['matt']) && isset($_POST['glass']) && isset($_POST['quantity']))
		{
			if(filter_var($_GET['id'], FILTER_VALIDATE_INT))
			{
				$paintingID = $_GET['id'];
				$item = array(
						'id' => $paintingID, 
						'frame' => $_POST['frame'], 
						'glass' => $_POST['glass'], 
						'matt' => $_POST['matt'],
						'quantity' => $_POST['quantity']);
						
				if($item['quantity'] < 1)
				{
					global $addZeroOrNegativeQuantity;
					$addZeroOrNegativeQuantity = true;
				}
				else 
				{
					$cartObject->add($item, true);
				}
			}
		}
		
		else if(isset($_GET['remove']))
		{
			if(isset($_GET['id']))
			{
				if(filter_var($_GET['id'], FILTER_VALIDATE_INT) && ($_GET['remove'] == 'one'))
				{
					$cart = $cartObject->getList();
					for($i = 0; $i < count($cart); $i++)
					{ 
						if(in_array($_GET['id'], $cart[$i]))
						{
							$cartObject->remove($cart[$i], true);
						}
					}
				}
			}
			else if($_GET['remove'] == 'all')
			{
				$cartObject->removeAll();
			}
		}
		else if(isset($_GET['from']) && ($_GET['from'] == 'browse'))
		{
			if(filter_var($_GET['id'], FILTER_VALIDATE_INT))
			{
				$paintingID = $_GET['id'];
				$cart = $cartObject->getList();
				global $browsePaintingAddExist;
				for($i = 0; $i < count($cart); $i++)
					{ 
						if(in_array($_GET['id'], $cart[$i]))
						{
							$browsePaintingAddExist = true;
						}
					}
				if(!$browsePaintingAddExist)
				{
					$item = array(
							'id' => $paintingID, 
							'frame' => 18, //key value for [none]
							'glass' => 5, //key value for [none]
							'matt' => 35, //key value for [none]
							'quantity' => 1);
							
					$cartObject->add($item, true);
				}
			}	
		}
		$_SESSION['cart'] = serialize($cartObject);
	}
	
	function printCart($pdo)
	{
		global $cartObject;
		global $browsePaintingAddExist;
		global $addZeroOrNegativeQuantity;
		$totalQuantity = 0;
		$subTotal = 0;
		
		$cartList = $cartObject->getList();
		if(count($cartList) == 0)
		{
			echo'
			<tr>
				<td colspan="7">
					<h3 class="ui center aligned large header">No Items In Cart!</h3>
				</td>
			</tr>
			<tr>
				<td colspan="7">
					<a href="index.php">
						<button class="fluid ui button">
							<i class="shop icon"></i>Continue Shopping
						</button>
					</a>
				</td>
			</tr>';
			
		}
		else 
		{
			if($browsePaintingAddExist)
			{
				echo'
				<tr>
					<td colspan="8">
						<h3 class="center aligned ui medium header">
							Painting already exists in cart, cart has not changed.
						</h3>
					</td>
				</tr>
				';
			}
			if($addZeroOrNegativeQuantity)
			{
				echo'
				<tr>
					<td colspan="8">
						<h3 class="center aligned ui medium header">
							Quantity was negative or 0, painting not added to cart or changed.
						</h3>
					</td>
				</tr>
				';
			}
			for($i = 0; $i < count($cartList); $i++)
			{
				$frames = getPDO($pdo, fetchAllFrames());
				$glasses = getPDO($pdo, fetchAllGlass());
				$matts = getPDO($pdo, fetchAllMatts());
				
				$cartItem = $cartList[$i];
				$paintingSql = $cartObject->getSql($cartItem['id']);
				$paintingInfo = getRow($pdo, $paintingSql);
				
				$baseCost = $paintingInfo['MSRP'];
				
				echo'
				<tr itemNum="'.$i.'">
					<td>
						<a href="cart.php?remove=one&id='.$paintingInfo['PaintingID'].'">
							<button type="button" class="circular ui red icon button">
								<i class="remove circle icon"></i>
							</button>
						</a>
					</td>
					<td>
						<a href="single-painting.php?id='.$paintingInfo['PaintingID'].'">
							<img src="images/art/works/square-medium/'.$paintingInfo['ImageFileName'].'.jpg" alt="..." id="artwork">
						</a>	
					</td>
					<td>
						<h4 class="ui medium header" itemNum="'.$i.'" price="'.$baseCost.'" id="painting'.$i.'">'.$paintingInfo['Title'].'</h4>
					</td>
				';
				echo'
					<td>
						<div class="three wide field">
							<label>Quantity</label>
							<input name="quantity'.$i.'" itemNum="'.$i.'" id="quantity'.$i.'" type="number" value="'.$cartItem['quantity'].'" />
						</div> 
					</td>
					<td>
						<div class="four wide field">
							<label>Frame</label>
								<select name="frame'.$i.'" itemNum="'.$i.'" id="frame'.$i.'" class="ui search dropdown">
				';
				$frameCost = populateFrameAndGetCost($frames, $cartItem);
				echo'
								</select>
						</div>
					</td>
					<td>
						<div class="four wide field">
							<label>Glass</label>
								<select name="glass'.$i.'" itemNum="'.$i.'" id="glass'.$i.'" class="ui search dropdown">
				';
				$glassCost = populateGlassAndGetCost($glasses, $cartItem);
				echo'
								</select>
						</div>  
					</td>
					<td>
						<div class="four wide field">
							<label>Matt</label>
								<select name="matt'.$i.'" itemNum="'.$i.'" id="matt'.$i.'" class="ui search dropdown">
				';
				$mattCost = populateMattAndGetCost($matts, $cartItem);
				$paintingCost = ($baseCost + $frameCost + $glassCost + $mattCost) * $cartItem['quantity'];
				$totalQuantity += $cartItem['quantity'];
				echo'
								</select>
						</div>    
					</td>
					<td>
						<h4 class = "ui medium header" name="itemCost" itemNum="'.$i.'" id="itemTotal'.$i.'" value="'.$paintingCost.'">$'
						.$paintingCost.'
						</h4>
					</td>
				</tr>
				';
				$subTotal +=  $paintingCost;
			}
			echo '
			<tr>
				<td colspan="6">
					<h4 class = "right floated ui medium header">Subtotal</h4>
				</td>
				<td colspan="2">
					<h4 class = "right floated ui medium header" id="subTotal" value="'.$subTotal.'">$'.$subTotal.'</h4>
				</td>
			</tr>';
			$shippingCosts = $cartObject->getShipping($subTotal, $totalQuantity);
			echo'
			<tr>
				<td colspan="6">
					<h4 class="right floated ui medium header">Shipping</h4>
				</td>
				<td colspan="2">
					<input type="radio" class="right floated ui radio checkbox" id="standardShipping" name="shipping" value="'.$shippingCosts['sValue'].'" checked>
						<span id="standardShippingMessage">Standard Shipping Cost: '.$shippingCosts['standard'].'</span>
					</input></br>
					<input type="radio" class="right floated ui radio checkbox" id="expressShipping" name="shipping" value="'.$shippingCosts['eValue'].'">
						<span id="expressShippingMessage">Express Shipping Cost: '.$shippingCosts['express'].'</span>
					</input>
				</td>
			</tr>';
			$grandTotal = $subTotal + $shippingCosts['sValue'];
			echo '
			<tr>
				<td colspan="6">
					<h4 class = "right floated ui medium header">Grand Total</h4>
				</td>
				<td colspan="2">
					<h4 class = "right floated ui medium header" id="grandTotal" value="'.$grandTotal.'" >$'.$grandTotal.'</h4>
				</td>
			</tr>
			';
		}
	}
	
	function populateFrameAndGetCost($dropdown, $cartItem)
	{
		$cost;
		while($row = $dropdown->fetch())
		{
			if($row['FrameID'] == $cartItem['frame'])
			{
				echo'<option value="'.$row["FrameID"].'" price="'.$row['Price'].'" selected="selected">'.$row["Title"].'</option>';
				$cost = $row['Price'];
			}
			else
			{
				echo'<option value="'.$row["FrameID"].'" price="'.$row['Price'].'">'.$row["Title"].'</option>';
			}
		}
		return $cost;
	}
	
	function populateGlassAndGetCost($dropdown, $cartItem)
	{
		$cost;
		while($row = $dropdown->fetch())
		{
			if($row['GlassID'] == $cartItem['glass'])
			{
				$cost = $row['Price'];
				echo'<option value="'.$row["GlassID"].'" price="'.$cost.'" selected="selected">'.$row["Title"].'</option>';
			}
			else
			{
				echo'<option value="'.$row["GlassID"].'" price="'.$row['Price'].'">'.$row["Title"].'</option>';
			}
		}
		return $cost;
	}
	
	function populateMattAndGetCost($dropdown, $cartItem)
	{
		$cost;
		while($row = $dropdown->fetch())
		{
			if($row['MattID'] == $cartItem['matt'])
			{
				echo'<option value="'.$row["MattID"].'" selected="selected">'.$row["Title"].'</option>';
				if($row['MattID'] = 35)//id for [none] matt
				{
					$cost = 0;
				}
				else 
				{
					$cost = 10;
				}
			}
			else
			{
				echo'<option value="'.$row["MattID"].'">'.$row["Title"].'</option>';
			}
		}
		return $cost;
	}

?>
<body >    
<?php 
	session_start();
	$pdo = startConnection();
	checkValues();
	include "includes/header.php";	
?>
	<div class="fav-banner-container">
		<div class="ui inverted segment gallery-banner">
			<h1 class="ui huge header">Shopping Cart</h1>
		</div>
	</div>
<main>
<div class = "ui container segment">
	<table class="ui very basic table">
		<tbody>
			<form action="index.php" method="POST" class="ui form">
			<?php 
				printCart($pdo);
				killDBConnection($pdo);
			?>
			<tr>
				<td colspan="2">
					<a href="cart.php?remove=all">
						<button type="button" class="left floated ui red button">
							<i class="remove circle icon"></i>Clear Cart
						</button>
					</a>
				</td>
				<td colspan="3">
					<button type="submit" class="right floated ui button">
						<i class="shop icon"></i>Save and Continue Shopping
					</button>
				</td>
				<td colspan="3">
					<button type="button" class="right floated ui orange button">
						<i class="shipping icon"></i>Order
					</button>
				</td>
			</tr>
			</form>
		</tbody>
	</table>
</div>
</main>
</body>
</html>