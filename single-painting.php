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
	include "includes/header.html";
	include "includes/db.php";
	include "includes/sql-statements.php";	
	
	$imageFileName;
	$title;
	$excerpt;
	$museum;
	$museumLink;
	$copyright;
	$description;
	$accessionNum;
	$width;
	$height;
	$medium;
	$googleLink;
	$googleText;
	$wikiLink;
	$year;
	$url;
	$artistID;
	$cost;
	$artist;
	$genres;
	$frames;
	$glass;
	$matts;
	$reviews;
	
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
	
	function getAllData()
	{	
		global $id;
	
		global $imageFileName;
		global $title;
		global $excerpt;
		global $museum;
		global $museumLink;
		global $copyright;
		global $description;
		global $accessionNum;
		global $width;
		global $height;
		global $medium;
		global $googleLink;
		global $googleText;
		global $wikiLink;
		global $year;
		global $url;
		global $artistID;
		global $cost;
		global $artist;
		global $genres;
		global $frames;
		global $glass;
		global $matts;
		global $reviews;
	
		$paintingQuery = fetchPainting($id);
		$row = getRow($paintingQuery);
		
		$imageFileName = $row['ImageFileName'];
		$title = $row['Title'];
		$excerpt = $row['Excerpt'];
		$museum = $row['GalleryID'];
		$museumLink = $row['MuseumLink'];
		$copyright = $row['CopyrightText'];
		$description = $row['Description'];
		$accessionNum = $row['AccessionNumber'];
		$width = $row['Width'];
		$height = $row['Height'];
		$medium = $row['Medium'];
		$googleLink = $row['GoogleLink'];
		$googleText = $row['GoogleDescription'];
		$wikiLink = $row['WikiLink'];
		$year = $row['YearOfWork'];
		$url = $row['MuseumLink'];
		$artistID = $row['ArtistID'];
			
		$paintingCost = fetchPaintingCost($id);
		$row = getRow($paintingCost);
		$cost = $row[0];
			
		$paintingArtist = fetchPaintingArtist($id);
		$row = getRow($paintingArtist);
		$artist = $row['FirstName'].' '.$row['LastName'];
			
		$paintingGenres = fetchPaintingGenres($id);
		$genres = getPDO($paintingGenres);
			
		$allFrames = fetchAllFrames();
		$frames = getPDO($allFrames);
			
		$allGlass = fetchAllGlass();
		$glass = getPDO($allGlass);
			
		$allMatts = fetchAllMatts();
		$matts = getPDO($allMatts);
			
		$paintingReviews = fetchPaintingReviews($id);
		$reviews = getPDO($paintingReviews);
	}
	
	function printImage($imageFileName)
	{
		echo '
		<div class="nine wide column">
			<img src="images/art/works/medium/'.$imageFileName.'.jpg" class = "ui huge image" alt="..." id="artwork">   
				<div class="ui fullscreen modal">
				<div class="image content">
					<img src="images/art/works/large/'.$imageFileName.'.jpg" alt="..." class="ui centered image" >
					<div class="description">
						<p></p>
					</div>
				</div>
			</div> 
		</div>
		'; 
	}

	function printMainInfo($title, $artist, $excerpt)
	{
		echo '
		<div class="item">
			<h2 class="header">'.$title.'</h2>
			<h3 >'.$artist.'</h3>
			<div class="meta">
				<p>
					<i class="orange star icon"></i>
					<i class="orange star icon"></i>
					<i class="orange star icon"></i>
					<i class="orange star icon"></i>
					<i class="empty star icon"></i>
				</p>
				<p>'.$excerpt.'</p>
			</div>
		</div>
		';
	}

	function printDetailsTab($artistID,$artist,$year,$medium,$width,$height)
	{
		echo '
		<div class="ui bottom attached active tab segment" data-tab="details">
			<table class="ui definition very basic collapsing celled table">
				<tbody>
					<tr>
						<td>
							Artist
						</td>
						<td>
							<a href="single-artist.php?id='.$artistID.'">'.$artist.'</a>
						</td>                       
					</tr>
					<tr>                       
						<td>
							Year
						</td>
						<td>
							'.$year.'
						</td>
					</tr>       
					<tr>
						<td>
							Medium
						</td>
						<td>
							'.$medium.'
						</td>
					</tr>  
					<tr>
						<td>
							Dimensions
						</td>
						<td>
							'.$width.'cm x '.$height.'cm
						</td>
					</tr>        
				</tbody>
			</table>
		</div>
		';
	}

	function printMuseumTab($museum,$accessionNum,$copyright,$url)
	{
		echo '
		<div class="ui bottom attached tab segment" data-tab="museum">
			<table class="ui definition very basic collapsing celled table">
				<tbody>
					<tr>
						<td>
							Museum
						</td>
						<td>
							'.$museum.'
						</td>
					</tr>       
					<tr>
						<td>
							Accession #
						</td>
						<td>
							'.$accessionNum.'
						</td>
					</tr>  
					<tr>
						<td>
							Copyright
						</td>
						<td>	
							'.$copyright.'
						</td>
					</tr>       
					<tr>
						<td>
							URL
						</td>
						<td>
							<a href="'.$url.'">View painting at museum site</a>
						</td>
					</tr>        
				</tbody>
			</table>    
		</div>     
		';
	}

	function printGenresTab($genres)
	{
		echo'
		<div class="ui bottom attached tab segment" data-tab="genres">
			<ul class="ui list">
		';
		while($row = $genres->fetch())
		{
			echo '<li class="item"><a href="single-genre.php?id='.$row['GenreID'].'">'.$row['GenreName'].'</a></li>';
		}
		echo'    
			</ul>
		</div>  
		';
	}

	function printCart($cost,$frame,$glass,$matt)
	{
		echo'
			<div class="ui segment">
				<div class="ui form">
					<div class="ui tiny statistic">
						<div class="value">
							$'.$cost.'
						</div>
					</div>
				<div class="four fields">
					<div class="three wide field">
						<label>Quantity</label>
						<input type="number">
					</div>                               
					<div class="four wide field">
						<label>Frame</label>
							<select id="frame" class="ui search dropdown">
		';
		populateDropdown($frame);
		echo'
							</select>
					</div>  
					<div class="four wide field">
						<label>Glass</label>
							<select id="glass" class="ui search dropdown">
		';
		populateDropdown($glass);
		echo'
							</select>
					</div>  
					<div class="four wide field">
						<label>Matt</label>
							<select id="matt" class="ui search dropdown">
		';
		populateDropdown($matt);
		echo'
							</select>
					</div>           
				</div>                     
			</div>                    
			<div class="ui divider"></div>
				<button class="ui labeled icon orange button">
					<i class="add to cart icon"></i>
						Add to Cart
				</button>
				<button class="ui right labeled icon button">
					<i class="heart icon"></i>
						Add to Favorites
				</button>        
			</div>  
		';
	}

	function populateDropdown($dropdown)
	{
		while($row = $dropdown->fetch())
		{
			echo'<option>'.$row["Title"].'</option>';
		}
	}

	function printDescriptionTab($description)
	{
		echo'
		<div class="ui bottom attached active tab segment" data-tab="first">
			'.$description.'
		</div>
		';
	}

	function printOnTheWebTab($wikiLink,$googleLink,$googleText)
	{
		echo'
		<div class="ui bottom attached tab segment" data-tab="second">
			<table class="ui definition very basic collapsing celled table">
				<tbody>
					<tr>
						<td>
							Wikipedia Link
						</td>
						<td>
							<a href="'.$wikiLink.'">View painting on Wikipedia</a>
						</td>                       
					</tr>                       
					<tr>
						<td>
							Google Link
						</td>
						<td>
							<a href="'.$googleLink.'">View painting on Google Art Project</a>
						</td>                       
					</tr>
					<tr>
						<td>
							Google Text
						</td>
						<td>
							'.$googleText.'
						</td>                       
						</tr>                      
				</tbody>
			</table>
		</div> 
		';
	}

	function printReviewsTab($reviews)
	{
		echo'
		<div class="ui bottom attached tab segment" data-tab="third">                
			<div class="ui feed">
		';
		$loopCount = 0;
		while($row = $reviews->fetch())
		{
			echo'
				<div class="event">
					<div class="content">
						<div class="date">'.$row[2].'</div>
						<div class="meta">
							<a class="like">
			';
	
			$count = 0;
			$ratings = $row[3];
			while($count < $ratings)
			{
				echo '<i class="star icon"></i>';
				$count++;
			}
			while($count < 5)
			{
				echo '<i class="empty star icon"></i>';
				$count++;
			}
			echo'
							</a>
						</div>                    
						<div class="summary">'.$row[4].'</div>       
					</div>
				</div>
			';
			if($loopCount < $reviews->rowCount()-1)
			{
				echo'<div class="ui divider"></div>';
			}
			$loopCount++;
		}
		echo'								
			</div>                                
		</div>
		';
	}
?>
    
<main>
    <!-- Main section about painting -->
	<?php 
		setID();
		startConnection();
		getAllData();
	?>
	<section class="ui segment grey100">
		<div class="ui doubling stackable grid container">
			<?php printImage($imageFileName);?>
				<div class="seven wide column">	
					<?php printMainInfo($title,$artist,$excerpt); ?>                
					<!-- Tabs For Details, Museum, Genre, Subjects -->
					<div class="ui top attached tabular menu ">
						<a class="active item" data-tab="details"><i class="image icon"></i>Details</a>
						<a class="item" data-tab="museum"><i class="university icon"></i>Museum</a>
						<a class="item" data-tab="genres"><i class="theme icon"></i>Genres</a>
						<a class="item" data-tab="subjects"><i class="cube icon"></i>Subjects</a>    
					</div>
					<?php
						printDetailsTab($artistID,$artist,$year,$medium,$width,$height);
						printMuseumTab($museum,$accessionNum,$copyright,$url);
						printGenresTab($genres);
					?>
					<div class="ui bottom attached tab segment" data-tab="subjects">
						<ul class="ui list">
							<li class="item"><a href="#">People</a></li>
							<li class="item"><a href="#">Science</a></li>
						</ul> 
					</div>		
				<?php printCart($cost, $frames, $glass, $matts); ?> 					
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
				printDescriptionTab($description);
				printOnTheWebTab($wikiLink,$googleLink,$googleText);
				printReviewsTab($reviews);  
				killDBConnection();
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