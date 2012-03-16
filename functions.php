<?php



function populateLatitude()
{
    //    $latitude = array('America/Chicago' => 41.51, 'America/Los_Angeles' => 34.30, 'America/New_York' => 40.47, 'US/Arizona' => 33.29);

    $latitude = array();

    global $CITIES;
    foreach ($CITIES as $city) {
        $latitude[$city->getTimezone] = $city->getLatitude();
    }
    return $latitude;

}

