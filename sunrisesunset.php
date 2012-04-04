<?php
/*
Plugin Name: Sunrise Sunset
Plugin URI: http://wordpress.org/extend/plugins/sunrise-sunset/
Description: Displays Sunrise and Sunset Times
Version:  1.1.1
Author: Rex Posadas (rexposadas@yahoo.com)
Author URI: http://www.rxnfx.com/ss-plugin
*/

/*  Copyright 2011  Rex Posadas  (email : rexposadas@yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


require_once "city.php";
require_once "functions.php";

add_action("widgets_init", "register_sunrise_sunset");
function register_sunrise_sunset()
{
    register_widget('sunrise_sunset');
}

class sunrise_sunset extends WP_Widget
{
    private $_cities;

    private function populateCities()
    {
        $lines = file(dirname(__FILE__) . '/cities.txt');
        foreach ($lines as $line) {
            $pieces = explode(":", $line);
            if ($pieces[0] == 'city') continue;
            $this->_cities[$pieces[0]] = new City($pieces[0], $pieces[1], $pieces[2], $pieces[3], $pieces[4]);
        }
    }


    function sunrise_sunset()
    {
        $widget_ops = array('classname' => 'sunrise_sunset_widget'
        , 'description' => 'Displays Sunrise and Sunset Times');

        $this->WP_Widget('ss_widget_bio', 'Sunrise Sunset', $widget_ops);

        $this->populateCities();
    }

    function form($instance)
    {
        $defaults = array(
            'title' => 'Sunrise Sunset Times',
            'ss-plugin');

        $instance = wp_parse_args((array)$instance, $defaults);
        $title = strip_tags($instance['title']);
        $showsunset = strip_tags($instance['showsunset']);
        $showsunrise = strip_tags($instance['showsunrise']);

        ?>
    <p><?php echo 'Title' ?>:
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"
               type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>

    <p><?php echo 'Cities'; ?>:

        <?php

        $select_box = sprintf('<select name="%s">', $this->get_field_name('city'));

        foreach ($this->_cities as $city) {
            if ($instance['city'] == $city->getName()) {
                $select_box .= sprintf('<option value="%s" selected="yes">%s</option>', $city->getName(), $city->getName());
            } else {
                $select_box .= sprintf('<option value="%s">%s</option>', $city->getName(), $city->getName());
            }
        }

        $select_box .= '</select>';
        echo $select_box;

        $field_sunset = $this->get_field_name('showsunset');
        $field_sunrise = $this->get_field_name('showsunrise');

        $showsunset_checkbox;
        $showsunrise_checkbox;

        if ($instance['showsunset']) {
            $showsunset_checkbox = sprintf('<input type="checkbox" name="%s" value="%s" checked/> Display Sunset Time', $field_sunset, $field_sunset);
        } else {
            $showsunset_checkbox = sprintf('<input type="checkbox" name="%s" value="%s"/> Display Sunset Time', $field_sunset, $field_sunset);
        }

        if ($instance['showsunrise']) {
            $showsunrise_checkbox = sprintf('<input type="checkbox" name="%s" value="%s" checked/> Display Sunrise Time', $field_sunrise, $field_sunrise);
        } else {
            $showsunrise_checkbox = sprintf('<input type="checkbox" name="%s" value="%s"/> Display Sunrise Time', $field_sunrise, $field_sunrise);
        }

        echo "<br/>" . $showsunset_checkbox;
        echo "<br/>" . $showsunrise_checkbox;

        ?>
    <p>
        <br/>

    </p>
    <?php

    }

    // save our widget
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['city'] = strip_tags($new_instance['city']);
        $instance['showsunset'] = strip_tags($new_instance['showsunset']);
        $instance['showsunrise'] = strip_tags($new_instance['showsunrise']);
        return $instance;
    }

    // display our widget
    function widget($args, $instance)
    {
        extract($args);

        $today = date("D M j Y");

        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }


        $result = $this->ss_get_times($instance);

        echo $today . "<br/>";
        if ($instance["showsunrise"]) {
            echo "Sunrise:" . $result['sunrise'] . "<br/>";
        }

        if ($instance["showsunset"]) {
            echo "Sunset:" . $result['sunset'];
        }

        echo $after_widget;
    }

    private function convertTimezone($timestamp, $city)
    {
        $newTimestamp = 0;
        $daylightSavingsTime = 0;
        $time_format = 'Y-m-d';


        $dstStart = '2012-03-11';
        $dstEnd = '2012-11-04';
        $today = date($time_format, $timestamp);

        if (( ( $today >= $dstStart ) && ( $today <= $dstEnd) )) {
            $daylightSavingsTime = 1;
        }

        switch ($city->getTimezone()) {
            case 'EST':
                $newTimestamp = $timestamp - ((5 - $daylightSavingsTime) * 60 * 60);
                break;
            case 'EDT':
                $newTimestamp = $timestamp - ((4 - $daylightSavingsTime) * 60 * 60);
                break;
            case 'MST':
                $newTimestamp = $timestamp - ((7 - $daylightSavingsTime) * 60 * 60);
                break;
            case 'CST':
                $newTimestamp = $timestamp - ((6 - $daylightSavingsTime) * 60 * 60);
                break;
            case 'CDT':
                $newTimestamp = $timestamp - ((5 - $daylightSavingsTime) * 60 * 60);
                break;
            case 'PST':
                $newTimestamp = $timestamp - ((8 - $daylightSavingsTime) * 60 * 60);
                break;
            case 'PDT':
                $newTimestamp = $timestamp - ((7 - $daylightSavingsTime) * 60 * 60);
                break;
        }


        $olddate = date($time_format, $timestamp);
        $newdate = date($time_format, $newTimestamp);


        return $newTimestamp;
    }


    function ss_get_times($instance)
    {
        $time_format = 'h:i A';
        $targetCity = $this->_cities[$instance['city']];

        $lat = $targetCity->getLatitude();
        $long = $targetCity->getLongitude();

        $suninfo = date_sun_info(time(), $lat, $long);

        $sunrise_time = date($time_format, $this->convertTimezone($suninfo['sunrise'], $targetCity));
        $sunset_time = date($time_format, $this->convertTimezone($suninfo['sunset'], $targetCity));

        return array('sunrise' => $sunrise_time, 'sunset' => $sunset_time);
    }
}


?>
