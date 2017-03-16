<?php 
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
	$galleryID;
	$cost;
	$artist;
	$genres;
	$subjects;
	$frames;
	$glass;
	$matts;
	$reviews;
	$averageStars;
	
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
				$id = 441;	
			}
		}
		else
		{
			//set default if no query string or error in query string
			$id = 441;	
		}
	}
	
	function getAllSinglePaintingData($pdo)
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
		global $galleryID;
		global $cost;
		global $artist;
		global $genres;
		global $subjects;
		global $frames;
		global $glass;
		global $matts;
		global $reviews;
		global $averageStars;
	
		$paintingQuery = fetchPainting($id);
		$row = getRow($pdo, $paintingQuery);
		
		$imageFileName = $row['ImageFileName'];
		$title = $row['Title'];
		$excerpt = $row['Excerpt'];
		$museum = $row['GalleryName'];
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
		$galleryID = $row['GalleryID'];
			
		$paintingCost = fetchPaintingCost($id);
		$row = getRow($pdo, $paintingCost);
		$cost = $row[0];
			
		$paintingArtist = fetchPaintingArtist($id);
		$row = getRow($pdo, $paintingArtist);
		$artist = $row['FirstName'].' '.$row['LastName'];
			
		$paintingGenres = fetchPaintingGenres($id);
		$genres = getPDO($pdo, $paintingGenres);
			
		$allFrames = fetchAllFrames();
		$frames = getPDO($pdo, $allFrames);
			
		$allGlass = fetchAllGlass();
		$glass = getPDO($pdo, $allGlass);
			
		$allMatts = fetchAllMatts();
		$matts = getPDO($pdo, $allMatts);
		
		$paintingSubjects = fetchPaintingSubjects($id);
		$subjects = getPDO($pdo, $paintingSubjects);
			
		$paintingReviews = fetchPaintingReviews($id);
		$reviews = getPDO($pdo, $paintingReviews);
		
		$reviewRatings = fetchReviewRatings($id);
		$ratings = getPDO($pdo, $reviewRatings);
		$amountOfRatings = $ratings->rowCount();
		if($amountOfRatings != 0)
		{
			while($row = $ratings->fetch())
			{
			$averageStars += $row[0];
			}
			$averageStars = ceil($averageStars / $amountOfRatings);
		}
		else 
		{
			$averageStars = 0;
		}
		
	}
	
	function printImage($pdo, $imageFileName)
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

	function printMainInfo($pdo, $title, $artistID, $artist, $excerpt, $averageStars)
	{
		echo '
		<div class="item">
			<h2 class="header">'.$title.'</h2>
			<h3 ><a href="single-artist.php?id='.$artistID.'">'.$artist.'</a></h3>
			<div class="meta">
				<p>
					'.printReviewStars($averageStars).'
				</p>
				<p>'.$excerpt.'</p>
			</div>
		</div>
		';
	}

	function printDetailsTab($pdo, $artistID,$artist,$year,$medium,$width,$height)
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

	function printMuseumTab($pdo, $galleryID,$museum,$accessionNum,$copyright,$url)
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
							<a href="single-gallery.php?id='.$galleryID.'">'.$museum.'</a>
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

	function printGenresTab($pdo, $genres)
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
	
	function printSubjectsTab($pdo, $subjects)
	{
		echo '
		<div class="ui bottom attached tab segment" data-tab="subjects">
			<ul class="ui list">
		';
		while($row = $subjects->fetch())
		{
			echo '<li class="item"><a href="single-subject.php?id='.$row['SubjectID'].'">'.$row['SubjectName'].'</a></li>';
		}
		echo'    
			</ul>
		</div>  
		';
	}

	function printCart($pdo,$cost,$frame,$glass,$matt,$id)
	{
		echo'
		<div class="ui segment">
			<form action="cart.php?id='.$id.'" method="post" class="ui form">
				<div class="ui form">
					<div class="ui tiny statistic">
						<div class="value">
							$'.$cost.'
						</div>
					</div>
				<div class="four fields">
					<div class="three wide field">
						<label>Quantity</label>
						<input name="quantity" type="number" value="1">
					</div>                               
					<div class="four wide field">
						<label>Frame</label>
							<select name="frame" id="frame" class="ui search dropdown">
		';
		populateFrameDropdown($frame);
		echo'
							</select>
					</div>  
					<div class="four wide field">
						<label>Glass</label>
							<select name="glass" id="glass" class="ui search dropdown">
		';
		populateGlassDropdown($glass);
		echo'
							</select>
					</div>  
					<div class="four wide field">
						<label>Matt</label>
							<select name="matt" id="matt" class="ui search dropdown">
		';
		populateMattDropdown($matt);
		echo'
							</select>
					</div>           
				</div>                     
			</div>                    
			<div class="ui divider"></div>
				<button type="submit" class="ui labeled icon orange button">
					<i class="add to cart icon"></i>
						Add to Cart
				</button>
				<a href="favorites.php?type=painting&id='.$id.'">
					<button type="button" class="ui right labeled icon button">
						<i class="heart icon"></i>
							Add to Favorites
					</button>  
				</a>
				</form>
				
			</div>  
		';
	}

	function populateFrameDropdown($dropdown)
	{
		while($row = $dropdown->fetch())
		{
			echo'<option value="'.$row["FrameID"].'">'.$row["Title"].'</option>';
		}
	}
	
	function populateGlassDropdown($dropdown)
	{
		while($row = $dropdown->fetch())
		{
			echo'<option value="'.$row["GlassID"].'">'.$row["Title"].'</option>';
		}
	}
	
	function populateMattDropdown($dropdown)
	{
		while($row = $dropdown->fetch())
		{
			echo'<option value="'.$row["MattID"].'">'.$row["Title"].'</option>';
		}
	}

	function printDescriptionTab($pdo, $description)
	{
		echo'
		<div class="ui bottom attached active tab segment" data-tab="first">
			'.$description.'
		</div>
		';
	}

	function printOnTheWebTab($pdo, $wikiLink,$googleLink,$googleText)
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

	function printReviewsTab($pdo, $reviews)
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
	
	function printReviewStars($averageStars)
	{
		$count = 0;
		while($count < $averageStars)
		{
			echo '<i class="orange star icon"></i>';
			$count++;
		}
		while($count < 5)
		{
			echo '<i class="empty star icon"></i>';
			$count++;
		}
	}
?>