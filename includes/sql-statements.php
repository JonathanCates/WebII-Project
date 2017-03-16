<?php
	function fetchPainting($id)
	{
		return "SELECT * FROM Paintings INNER JOIN Galleries on Paintings.GalleryID = Galleries.GalleryID WHERE PaintingID = $id";
	}
	
	function fetchPaintingCost($id)
	{
		return "SELECT FLOOR(MSRP) FROM Paintings WHERE PaintingID = $id";
	}
	
	function fetchPaintingGenres($id)
	{
		return "SELECT Genres.GenreName, Genres.GenreID from Paintings 
			INNER JOIN (Genres INNER JOIN PaintingGenres ON Genres.GenreID = PaintingGenres.GenreID) 
			ON Paintings.PaintingID = PaintingGenres.PaintingID WHERE Paintings.PaintingID = $id";
	}
	
	function fetchAllFrames()
	{
		return "SELECT FrameID, Title, Price from TypesFrames ORDER BY Title DESC";
	}

	function fetchAllGlass()
	{
		return "SELECT GlassID, Title, Price from TypesGlass ORDER BY Title DESC";
	}
	
	function fetchAllMatts()
	{
		return "SELECT MattID, Title from TypesMatt ORDER BY Title DESC";
	}
	
	function fetchAllArtistsByLastName()
	{
		return "SELECT ArtistID, FirstName, LastName FROM Artists ORDER BY LastName";
	}
	
	function fetchAllMuseumsByName()
	{
		return "SELECT * FROM Galleries ORDER BY GalleryName";
	}
	
	function fetchAllShapesByName()
	{
		return "SELECT ShapeID, ShapeName FROM Shapes ORDER BY ShapeName";
	}
	
	function fetchPaintingReviews($id)
	{
		return "SELECT RatingID, PaintingID, ReviewDate, Rating, Comment FROM Reviews WHERE Reviews.PaintingID = $id";
	}
	
	function fetchPaintingArtist($id)
	{
		return "SELECT FirstName, LastName from Paintings INNER JOIN Artists on Paintings.ArtistID = Artists.ArtistID WHERE PaintingID = $id";
	}

	function fetchAllGenres()
	{
		return "SELECT Genres.GenreID, Genres.GenreName FROM Genres  ORDER BY Genres.EraID, Genres.GenreName";
	}
	
	function fetchAllArtists()
	{
		return "SELECT Artists.ArtistID, Artists.FirstName, Artists.LastName FROM Artists ORDER BY LastName, FirstName, ArtistID";
	}
	
	function fetchAllSubjects()
	{
		return "SELECT Paintings.Title, Paintings.ImageFileName, PaintingSubjects.SubjectID, PaintingSubjects.PaintingID, Subjects.SubjectID, Subjects.SubjectName 
					FROM PaintingSubjects 
					JOIN Subjects 
					ON Subjects.SubjectID=PaintingSubjects.SubjectID
					JOIN Paintings
					ON Paintings.PaintingID=PaintingSubjects.PaintingID
					GROUP BY Subjects.SubjectName";
	}
	
	function fetchAllSubjectPaintings($id)
	{
		return "SELECT Paintings.PaintingID, Paintings.ImageFileName, Subjects.SubjectName, Subjects.SubjectID FROM Paintings 
						INNER JOIN (Subjects INNER JOIN PaintingSubjects ON Subjects.SubjectID = PaintingSubjects.SubjectID)
					    ON Paintings.PaintingID = PaintingSubjects.PaintingID WHERE PaintingSubjects.SubjectID = $id";
	}
	
	function fetchAllGalleries()
	{
		return "SELECT GalleryName, GalleryCity, GalleryCountry, GalleryID, Latitude, Longitude FROM Galleries ORDER BY GalleryName";
	}
	
	function getSubjectPainting()
	{
		return "SELECT SubjectID.Subjects, PaintingSubjectID.PaintingSubjects, PaintingID.Paintings";
	}
	
	function fetchPaintingSubjects($id)
	{
		return "SELECT Paintings.PaintingID, Subjects.SubjectName, Subjects.SubjectID FROM Paintings 
						INNER JOIN (Subjects INNER JOIN PaintingSubjects ON Subjects.SubjectID = PaintingSubjects.SubjectID)
					    ON Paintings.PaintingID = PaintingSubjects.PaintingID WHERE Paintings.PaintingID = $id";
	}
	
	function fetchSingleGenre($id)
	{
		return "SELECT Paintings.ImageFileName, Paintings.PaintingID 
						FROM Paintings INNER JOIN PaintingGenres on Paintings.PaintingID = PaintingGenres.PaintingID  
						WHERE PaintingGenres.GenreID = $id 
						ORDER BY Paintings.YearOfWork";
	}
	
	function fetchSingleGallery($id)
	{
		return "SELECT Paintings.ImageFileName, Paintings.PaintingID 
						FROM Paintings INNER JOIN Galleries on Paintings.GalleryID = Galleries.GalleryID  
						WHERE Galleries.GalleryID = $id 
						ORDER BY Paintings.YearOfWork";
	}
	
	function fetchSingleGenreHeader($id)
	{
		return "SELECT GenreID, GenreName, Description FROM Genres WHERE GenreID = $id";
	}
	
	function fetchSingleGalleryHeader($id)
	{
		return "SELECT GalleryID, GalleryName, GalleryCity, GalleryCountry, Latitude, Longitude, GalleryWebSite FROM Galleries WHERE GalleryID = $id";
	}
	
	function fetchSingleSubjectHeader($id)
	{
		return "SELECT Paintings.ImageFileName, Subjects.SubjectName, Subjects.SubjectID FROM Paintings 
						INNER JOIN (Subjects INNER JOIN PaintingSubjects ON Subjects.SubjectID = PaintingSubjects.SubjectID)
					    ON Paintings.PaintingID = PaintingSubjects.PaintingID WHERE PaintingSubjects.SubjectID = $id";
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
					WHERE Paintings.ArtistID = $id ORDER BY YearOfWork ASC LIMIT 20";
	}
	
	function filterByMuseum($id)
	{
		return "SELECT * FROM Galleries INNER JOIN(Artists INNER JOIN Paintings on Artists.ArtistID = Paintings.ArtistID) 
					ON Galleries.GalleryID = Paintings.GalleryID 
					WHERE Galleries.GalleryID = $id ORDER BY YearOfWork ASC LIMIT 20";
	}
	
	function filterByShape($id)
	{
		return "SELECT * FROM Shapes INNER JOIN(Artists INNER JOIN Paintings ON Artists.ArtistID = Paintings.ArtistID)
					ON Shapes.ShapeID = Paintings.ShapeID 
					WHERE Shapes.ShapeID = $id ORDER BY Paintings.YearOfWork ASC LIMIT 20";
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
		return "SELECT Shapes.ShapeID, Shapes.ShapeName FROM Shapes INNER JOIN(Artists 
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
		return "SELECT * FROM Paintings INNER JOIN Artists on Paintings.ArtistID = Artists.ArtistID ORDER BY Paintings.YearOfWork ASC LIMIT 20";
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
	
	function fetchReviewRatings($id)
	{
		return "SELECT Rating from Reviews WHERE Reviews.PaintingID = $id";	
	}
?>