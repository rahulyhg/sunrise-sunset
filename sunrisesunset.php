<?php
/*
Plugin Name: Sunrise Sunset
Plugin URI: http://wordpress.org/extend/plugins/sunrise-sunset/
Description: Displays Sunrise and Sunset Times
Version: 1.0.5
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
    private $_latitude;
    private $_longitude;

    private function populateCities()
    {
        $lines = file(dirname(__FILE__) . '/cities.txt');
        foreach ($lines as $line) {
            $pieces = explode(":", $line);
            $this->_cities[] = new City($pieces[0], $pieces[1], $pieces[2], $pieces[3]);
        }
    }


    private function populateLatLong()
    {
        foreach ($this->_cities as $city) {
            $this->_latitude[$city->getTimezone()] = $city->getLatitude();
            $this->_longitude[$city->getTimezone()] = $city->getLongitude();
        }

    }

    function sunrise_sunset()
    {
        $widget_ops = array('classname' => 'sunrise_sunset_widget'
        , 'description' => 'Displays Sunrise and Sunset Times');

        $this->WP_Widget('ss_widget_bio', 'Sunrise Sunset', $widget_ops);

        $this->populateCities();
        $this->populateLatLong();
    }

    function form($instance)
    {
        $defaults = array(
            'title' => 'Sunrise Sunset Times',
            'timezone' => 'Time Zone', 'ss-plugin');

        $instance = wp_parse_args((array)$instance, $defaults);
        $title = strip_tags($instance['title']);
        $timezone = strip_tags($instance['timezone']);
        $showsunset = strip_tags($instance['showsunset']);
        $showsunrise = strip_tags($instance['showsunrise']);

        ?>
    <p><?php echo 'Title' ?>:
        <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"
               type="text" value="<?php echo esc_attr($title); ?>"/>
    </p>

    <p><?php echo 'Cities'; ?>:

        <?php

        $select_box = sprintf('<select name="%s">', $this->get_field_name('timezone'));

        foreach ($this->_cities as $city) {
            if ($instance['timezone'] == $city->getName()) {
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
        $instance['timezone'] = strip_tags($new_instance['timezone']);
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


        $result = $this->ss_get_sunset($instance);

        echo $today . "<br/>";
        if ($instance["showsunrise"]) {
            echo "Sunrise:" . $result['sunrise'] . "<br/>";
        }

        if ($instance["showsunset"]) {
            echo "Sunset:" . $result['sunset'];
        }

        //        echo print_r(DateTimeZone::listAbbreviations());

        echo $after_widget;
    }


    function ss_get_sunset($instance)
    {
        $target_time_zone = $instance['timezone'];
        $time_format = 'h:i A T'; // 08:53 PM PDT

        $zenith = 90 + (50 / 60);

        // Set timezone in PHP5/PHP4 manner
        if (!function_exists('date_default_timezone_set')) {
            putenv("TZ=" . $target_time_zone);
        } else {
            date_default_timezone_set("$target_time_zone");
        }

        // find time offset in hours
        $tzoffset = date("Z") / 60 / 60;

        // determine sunrise time
        $sunrise = date_sunrise(time(), SUNFUNCS_RET_STRING, $this->_latitude[$target_time_zone], $this->_longitude[$target_time_zone], $zenith, $tzoffset);
        $sunrise_time = date($time_format, strtotime(date("Y-m-d") . ' ' . $sunrise));


        // determine sunset time
        $sunset = date_sunset(time(), SUNFUNCS_RET_STRING, $this->_latitude[$target_time_zone], $this->_longitude[$target_time_zone], $zenith, $tzoffset);
        $sunset_time = date($time_format, strtotime(date("Y-m-d") . ' ' . $sunset));

        return array('sunrise' => $sunrise_time, 'sunset' => $sunset_time);
    }
}


?>
