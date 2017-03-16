<?php
    include_once "abstract-lists.php";

    class shoppingCart extends lists
    {
        function getSql($id)
        {
            return "SELECT MSRP, Title, PaintingID, ImageFileName FROM Paintings WHERE PaintingID = $id";
        }
        
        function getShipping($subTotal, $totalQuantity)
        {
            $standard;
            $express;
            if($subTotal > 1500)
            {
                $standard = 'FREE';
                $sValue = 0;
                if($subTotal > 2500)
                {
                    $express = 'FREE';
                    $eValue = 0;
                }
                else
                {
                    $express = '$'. 50 * $totalQuantity;   
                    $eValue = 50 * $totalQuantity;
                }
            }
            else
            {
                $standard = '$'. 25 * $totalQuantity;
                $sValue = 25 * $totalQuantity;
                $express = '$'. 50 * $totalQuantity;
                $eValue = 50 * $totalQuantity;
            }
            return array('standard' => $standard, 'express' => $express, 'sValue' => $sValue, 'eValue' => $eValue);
        }
        
        function updateCart($newValues, $id, $cartIndex)
        {
            $cart = parent::getList();
            $item = $cart[$cartIndex];
            $change = false;
            if($newValues['frame'] != $item['frame'])
            {
                $item['frame'] = $newValues['frame'];
                $change = true;
            }
            if($newValues['glass'] != $item['glass'])
            {
                $item['glass'] = $newValues['glass'];
                $change = true;
            }
            if($newValues['matt'] != $item['matt'])
            {
                $item['matt'] = $newValues['matt'];
                $change = true;
            }
            if($newValues['quantity'] != $item['quantity'])
            {
                $item['quantity'] = $newValues['quantity'];
                $change = true;
            }
            if($change = true)
            {
                parent::update($item, $cartIndex);
            }
        }
    }

?>