<?php

class City
{

    private $name;
    private $timezone;
    private $latitude;
    private $longitude;

    function __construct($name, $timezone, $latitude, $longitude)
    {
        $this->name = $name;
        $this->timezone = $timezone;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }


    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }
}
