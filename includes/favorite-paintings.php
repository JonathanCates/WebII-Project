<?php
    include_once "abstract-lists.php";
    
    class favPaintings extends lists
    {
        function getSql($id)
        {
            return "SELECT ImageFileName, Title FROM Paintings WHERE PaintingID = $id";
        }
    }

?>