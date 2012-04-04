=== SunriseSunset ===
Contributors: rxn
Tags: sunrise, sunset, widget
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.1.0
License: GPLv2

SunriseSunset(ss) displays sunrise and sunset times. The three major cities included are: New York, Chicago and Los Angeles.

== Description ==

This widget displays the sunrise and sunset times for select cities. You can set the location
using a drop down list.

To Add a city go to city.txt and add a line with the following format:
<city>:<latitude>:<longitude>:<timezone>:<summertimezone>

For example:
Miami, FL:25.82:-80.28:EST:EDT

Logitude is always negative for cities  in the United States.  This plugin should handle cities from different
countries, but it has not been tested.


Please email me if you have any questions or requests: rexposadas@yahoo.com

== Installation ==

You install this widget like any normal widget.

1. Upload the SunriseSunset plugin to the /wp-content directory.
2. Activate it.
3. Add it to your sidebar as a widget.


== Frequently Asked Questions ==

= Can I request other cities to be added to drop down list? =
Yes, you can. Simply email me and I'll try to accomodate your request : rexposadas@yahoo.com

= What updates are planned for this widget? =
Here are some:
# Adding more cities.
# Better design.
# The ability to use custom longitude and latitude.

= How do I add more cities to this list? =
Add a line in the cities.txt file with the following format:
<city>:<latitude>:<longitude>:<timezone>:<summertimezone>

For example:
Miami, FL:25.82:-80.28:EST:EDT


== Screenshots ==
1. The widget displays sunrise and sunset times.  
2. You can adjust the title and the city in the Dashboard. The widget uses local time.


== Changelog ==
= 1.1.0 =
* Taking into account DST

= 1.0.9 =
* Fixed times for most cities.

= 1.0.8 =
* Removed hacked code - reported to WordPress.org forums

= 1.0.6 =
* Improved README
* Updated screenshot

= 1.0.5 =
* Add more cities
* Can show to display on sunset/sunrise times
^ Cities are now on files.

= 1.0.4 =
* Bug Fixes

= 1.0.3 =
* Added Arizona

= 1.0.2 =
* Bug fixes

= 1.0.1 =
* Added screenshots.
* Better readme.

= 1.0 =
* Initial files.  New York, Los Angeles and Chicago.
