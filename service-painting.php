<?php
include "includes/db.php";
include "includes/sql-statements.php";

header("Content-type: application/json");

function outputJSON($pdo)
{
    if(isset($_GET['ArtistID']))
    {
        $id = $_GET['ArtistID'];
        $sql = filterByArtist($id);
    }
    else if(isset($_GET['GalleryID']))
    {
        $id = $_GET['GalleryID'];
        $sql = filterByMuseum($id);
    }
    else if(isset($_GET['ShapeID']))
    {
        $id = $_GET['ShapeID'];
        $sql = filterByShape($id);
    }
    else if(isset($_GET['Name']))
	{
		$sql = 'SELECT Title, PaintingID FROM Paintings';
	}
	else
	{
		$sql = filterByNothing();
	}
	
    $paintingPdo = getPDO($pdo, $sql);
    $array = array();
    
    while($row = $paintingPdo->fetch())
    {
        $item = array(
					'PaintingID' => $row['PaintingID'], 
					'ImageFileName' => $row['ImageFileName'], 
					'FirstName' => $row['FirstName'], 
					'LastName' => $row['LastName'],
					'Description' => $row['Description'],
					'Title' => $row['Title'],
					'ArtistID' => $row['ArtistID'],
					'MSRP' => $row['MSRP']);
					
		$array[] = $item;
    }
    
    $json = json_encode($array);
    return $json;
}
$pdo = startConnection();
echo outputJSON($pdo);
killDBConnection($pdo);
?>
