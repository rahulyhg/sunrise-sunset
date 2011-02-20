<?php
/*
Plugin Name: Sunrise Sunset
Plugin URI: http://rxnfx.com/ss-plugin
Description: Displays Sunrise and Sunset Times
Version: 0.1
Author: Rex Posadas (rexposadas@yahoo.com)
Author URI: http://www.rxnfx.com
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
        , 'description' => __('Displays Sunrise and Sunset Times', 'ss-plugin'));

        $this->WP_Widget('ss_widget_bio', __('Sunrise Sunset', 'ss-plugin'), $widget_ops);
    }

    function form($instance) {
        $defaults = array('title' => __('Sunrise Sunset Times', 'ss-plugin'));

        $instance = wp_parse_args((array) $instance, $defaults);
        $title = strip_tags($instance['title']);

        ?>
        <p><?php _e('Title', 'ss-plugin') ?>:
            <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>"
                   type="text" value="<?php echo esc_attr($title); ?>"/>
        </p>
        <?php

    }

    // save our widget
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

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


        $result = $this->ss_get_sunset();

        echo $today . "<br/>";
        echo "Sunrise:" . $result['sunrise'] . "<br/>";
        echo "Sunset:" . $result['sunset'];

        echo $after_widget;
    }


    function ss_get_sunset() {

        $myTZ = 'America/Los_Angeles'; // Pacific Time
        $time_format = 'h:i A T'; // 08:53 PM PDT

        // Set the latitude and longitude for your location
        $latitude = 46.36; //North
        $longitude = -124.02; //West

        $zenith = 90 + (50 / 60);

        // Set timezone in PHP5/PHP4 manner
        if (!function_exists('date_default_timezone_set')) {
            putenv("TZ=" . $myTZ);
        } else {
            date_default_timezone_set("$myTZ");
        }

        // find time offset in hours
        $tzoffset = date("Z") / 60 / 60;

        // determine sunrise time
        $sunrise = date_sunrise(time(), SUNFUNCS_RET_STRING, $latitude, $longitude, $zenith, $tzoffset);
        $sunrise_time = date($time_format, strtotime(date("Y-m-d") . ' ' . $sunrise));


        // determine sunset time
        $sunset = date_sunset(time(), SUNFUNCS_RET_STRING, $latitude, $longitude, $zenith, $tzoffset);
        $sunset_time = date($time_format, strtotime(date("Y-m-d") . ' ' . $sunset));

        return array('sunrise' => $sunrise_time, 'sunset' => $sunset_time);
    }
}


?>
