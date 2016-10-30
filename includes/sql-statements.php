<?php 
	function fetchPainting($id)
	{
		return "SELECT * FROM Paintings INNER JOIN Galleries on Paintings.GalleryID = Galleries.GalleryID WHERE PaintingID = $id";
	}
	
	function fetchPaintingCost($id)
	{
		return "SELECT FLOOR(Cost) FROM Paintings WHERE PaintingID = $id";
	}
	
	function fetchPaintingGenres($id)
	{
		return "SELECT Genres.GenreName, Genres.GenreID from Paintings 
			INNER JOIN (Genres INNER JOIN PaintingGenres ON Genres.GenreID = PaintingGenres.GenreID) 
			ON Paintings.PaintingID = PaintingGenres.PaintingID WHERE Paintings.PaintingID = $id";
	}
	
	function fetchAllFrames()
	{
		return "SELECT * from TypesFrames";
	}
	
	function fetchAllGlass()
	{
		return "SELECT * from TypesGlass";
	}
	
	function fetchAllMatts()
	{
		return "SELECT * from TypesMatt";
	}
	
	function fetchAllArtistsByFirstName()
	{
		return "SELECT * FROM Artists ORDER BY FirstName";
	}
	
	function fetchAllMuseumsByName()
	{
		return "SELECT * FROM Galleries ORDER BY GalleryName";
	}
	
	function fetchAllShapesByName()
	{
		return "SELECT * FROM Shapes ORDER BY ShapeName";
	}
	
	function fetchPaintingReviews($id)
	{
		return "SELECT * from Reviews WHERE Reviews.PaintingID = $id";
	}
	
	function fetchPaintingArtist($id)
	{
		return "SELECT FirstName, LastName from Paintings INNER JOIN Artists on Paintings.ArtistID = Artists.ArtistID WHERE PaintingID = $id";
	}

	function fetchAllGenres()
	{
		return "SELECT Genres.GenreID, Genres.GenreName FROM Genres  ORDER BY Genres.EraID, Genres.GenreName";
	}
	
	function fetchSingleGenre($id)
	{
		return "SELECT Paintings.ImageFileName, Paintings.PaintingID 
						FROM Paintings INNER JOIN PaintingGenres on Paintings.PaintingID = PaintingGenres.PaintingID  
						WHERE PaintingGenres.GenreID = $id 
						ORDER BY Paintings.YearOfWork";
	}
	
	function fetchSingleGenreHeader($id)
	{
		return "SELECT GenreID, GenreName, Description FROM Genres WHERE GenreID = $id";
	}
	
	function fetchSingleArtistHeader($id)
	{
		return "SELECT ArtistID, FirstName, LastName, Nationality, YearOfBirth, YearOfDeath, Details FROM Artists WHERE ArtistID = $id";
	}
	
	function fetchSingleArtistPaintings($id)
	{
		return "SELECT ImageFileName, PaintingID, Title FROM Paintings WHERE Paintings.ArtistID = $id";
	}
	
	function filterByArtist($id)
	{
		return "SELECT * FROM Paintings INNER JOIN Artists on Paintings.ArtistID = Artists.ArtistID 
					WHERE Paintings.ArtistID = $id ORDER BY YearOfWork";
	}
	
	function filterByMuseum($id)
	{
		return "SELECT * FROM Galleries INNER JOIN(Artists INNER JOIN Paintings on Artists.ArtistID = Paintings.ArtistID) 
					ON Galleries.GalleryID = Paintings.GalleryID 
					WHERE Galleries.GalleryID = $id ORDER BY YearOfWork";
	}
	
	function filterByShape($id)
	{
		return "SELECT * FROM Shapes INNER JOIN(Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID)
					ON Shapes.ShapeID = Paintings.ShapeID 
					WHERE Shapes.ShapeID = $id ORDER BY YearOfWork";
	}
	
	function filterByArtistMuseum($aid,$mid)
	{
		return "SELECT * FROM Galleries INNER JOIN(Artists 
					INNER JOIN Paintings on Artists.ArtistID = Paintings.ArtistID) 
					ON Galleries.GalleryID = Paintings.GalleryID 
					WHERE Galleries.GalleryID = $museumID 
					AND Artists.ArtistID = $artistID 
					ORDER BY YearOfWork";
	}
	
	function filterByArtistShape($aid,$sid)
	{
		return "SELECT * FROM Shapes INNER JOIN(Artists 
					INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID)
					ON Shapes.ShapeID = Paintings.ShapeID 
					WHERE Shapes.ShapeID = $sid 
					AND Artists.ArtistID = $aid
					ORDER BY YearOfWork";
	}
	
	function filterByMuseumShape($mid,$sid)
	{
		return "SELECT * FROM Galleries INNER JOIN (Shapes 
					INNER JOIN(Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.PaintingID) 
					ON Shapes.ShapeID = Paintings.ShapeID) 
					ON Galleries.GalleryID = Paintings.GalleryID 
					WHERE Shapes.ShapeID = $sid
					AND Galleries.GalleryID = $mid
					ORDER BY YearOfWork";	}
	
	function filterByArtistMuseumShape($aid,$mid,$sid)
	{
		return "SELECT * FROM Galleries INNER JOIN (Shapes 
					INNER JOIN(Artists 
					INNER JOIN Paintings 
					ON Artists.ArtistID = Paintings.ArtistID) 
					ON Shapes.ShapeID = Paintings.ShapeID) 
					ON Galleries.GalleryID = Paintings.GalleryID 
					WHERE (Shapes.ShapeID = $shapeID 
					AND Galleries.GalleryID = $museumID) 
					AND Artists.ArtistID = $artistID 
					ORDER BY YearOfWork";
	}
	
	function filterByNothing()
	{
		return "SELECT * FROM Paintings INNER JOIN Artists on Paintings.ArtistID = Artists.ArtistID ORDER BY YearOfWork";
	}
	
	function filterBySearch($searchBy)
	{
		return "SELECT * FROM Paintings 
					INNER JOIN Artists on Paintings.ArtistID = Artists.ArtistID
					WHERE Title
					LIKE '%{$searchBy}%' 
					OR Description
					LIKE '%{$searchBy}%'
					ORDER BY YearOfWork";
	}
?>