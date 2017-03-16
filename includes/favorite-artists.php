<?php
    include_once "abstract-lists.php";
    
    class favArtists extends lists
    {
        function getSql($id)
        {
            return "SELECT FirstName, LastName FROM Artists WHERE ArtistID = $id";
        }
    }

?>