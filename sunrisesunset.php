<?php
/*
Plugin Name: Sunrise Sunset
Plugin URI: http://wordpress.org/extend/plugins/sunrise-sunset/
Description: Displays Sunrise and Sunset Times
Version: 1.0.2
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

add_action("widgets_init", "register_sunrise_sunset");
function register_sunrise_sunset() {
    register_widget('sunrise_sunset');
}


class sunrise_sunset extends WP_Widget {


    function sunrise_sunset() {

        $widget_ops = array('classname' => 'sunrise_sunset_widget'
        , 'description' => 'Displays Sunrise and Sunset Times');

        $this->WP_Widget('ss_widget_bio', 'Sunrise Sunset', $widget_ops);
    }

    function form($instance) {
        $defaults = array(
            'title' => 'Sunrise Sunset Times',
            'timezone' => 'Time Zone', 'ss-plugin');

        $instance = wp_parse_args((array) $instance, $defaults);
        $title = strip_tags($instance['title']);
        $timezone = strip_tags($instance['timezone']);

        ?>
        <p><?php echo 'Title' ?>:
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"
                   type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>

        <p><?php echo 'Time Zone'; ?>:

        <?php

        $select_box = sprintf('<select name="%s">', $this->get_field_name('timezone'));

        if ($instance['timezone'] == 'America/Chicago') {
            $select_box .= sprintf('<option value="%s" selected="yes">%s</option>', 'America/Chicago', 'Chicago');
        } else {
            $select_box .= sprintf('<option value="%s">%s</option>', 'America/Chicago', 'Chicago');
        }

        if ($instance['timezone'] == 'America/New_York') {
            $select_box .= sprintf('<option value="%s" selected="yes">%s</option>', 'America/New_York', 'New_York');
        } else {
            $select_box .= sprintf('<option value="%s">%s</option>', 'America/New_York', 'New_York');
        }

        if ($instance['timezone'] == 'America/Los_Angeles') {
            $select_box .= sprintf('<option value="%s" selected="yes">%s</option>', 'America/Los_Angeles', 'Los_Angeles');
        } else {
            $select_box .= sprintf('<option value="%s">%s</option>', 'America/Los_Angeles', 'Los_Angeles');
        }

        if ($instance['timezone'] == 'US/Arizona') {
            $select_box .= sprintf('<option value="%s" selected="yes">%s</option>', 'US/Arizona', 'Arizona');
        } else {
            $select_box .= sprintf('<option value="%s">%s</option>', 'US/Arizona', 'Arizona');
        }
        // add arizona here

        $select_box .= '</select>';
        echo $select_box;
    }

    // save our widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['timezone'] = strip_tags($new_instance['timezone']);
        return $instance;
    }

    // display our widget
    function widget($args, $instance) {
        extract($args);

        $today = date("D M j Y");

        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);

        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        }


        $result = $this->ss_get_sunset($instance);

        echo $today . "<br/>";
        echo "Sunrise:" . $result['sunrise'] . "<br/>";
        echo "Sunset:" . $result['sunset'];

        echo $after_widget;
    }


    function ss_get_sunset($instance) {

//        add arizona here
        $latitude = array('America/Chicago' => 41.51, 'America/Los_Angeles' => 34.30, 'America/New_York' => 40.47, 'US/Arizona' => 33.29);
        $longitude = array('America/Chicago' => -87.39, 'America/Los_Angeles' => -118.15, 'America/New_York' => -73.58, 'US/Arizona' => -122.04);



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
        $sunrise = date_sunrise(time(), SUNFUNCS_RET_STRING, $latitude[$target_time_zone], $longitude[$target_time_zone], $zenith, $tzoffset);
        $sunrise_time = date($time_format, strtotime(date("Y-m-d") . ' ' . $sunrise));


        // determine sunset time
        $sunset = date_sunset(time(), SUNFUNCS_RET_STRING, $latitude[$target_time_zone], $longitude[$target_time_zone], $zenith, $tzoffset);
        $sunset_time = date($time_format, strtotime(date("Y-m-d") . ' ' . $sunset));

        return array('sunrise' => $sunrise_time, 'sunset' => $sunset_time);
    }
}


?>
