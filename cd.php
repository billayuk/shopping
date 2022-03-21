<?php
class CD 
{
    var $album = "";
    var $artist = "";
    var $country = "";
    var $price = "";
    var $quantity = "";


    static function setCDfromString($cdDetails, $quantity)
    {
        $cd = new CD();
        $cdInfo = explode(",", $cdDetails);
        $cd -> album = trim($cdInfo[0]);
        $cd -> artist = trim($cdInfo[1]);
        $cd -> country = trim($cdInfo[2]);
        $cd -> price = trim($cdInfo[3]);
        $cd -> quantity = $quantity;

        return $cd;

    }

    static function setCD($album, $artist, $country, $price, $quantity)
    {
        $cd = new CD();
        $cd -> album = $album;
        $cd -> artist = $artist;
        $cd -> country = $country;
        $cd -> price = $price;
        $cd -> quantity = $quantity;

        return $cd;
    }

    // accessor method
    function getAlbum()
    {
        return $this -> album;
    }

    function getArtist()
    {
        return $this -> artist;
    }

    function getCountry()
    {
        return $this -> country;

    }

    function getPrice()
    {
        return $this -> price;
    }

    function getQuantity()
    {
        return $this-> quantity;
    }
    
}



?>