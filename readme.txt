=== WordPress PHP Logger - Simple PHP Logging for WordPress ===
Contributors: Ryan Novotny
Tags: php, logging, wordpress, debug, debugging
Author URI: https://ryanmnovotny.com
Plugin URI: https://ryanmnovotny.com/wp-php-log
Requires at least: 4.0
Tested up to: 4.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 1.0.0

WordPress PHP Logger - Quickly and easily log PHP variables to help debug plugins and themes

== Description ==
Want to determine what a value in PHP is during execution?  See what gets returned from your REST API call?  Instead of logging to a file, where you have to create a directory just to see a value, do it all with a simple PHP function all inside WordPress!

One simple function:  wp_php_log( $my_variable, "my variable").  Just set the first parameter to whatever you want to see the value of, and the second parameter (optional) to set a friendly name for your variable.  Run the code, and check the PHP Logs page on the admin to view the result.

= WordPress PHP Logger Features =
Use the function  wp_php_log( $my_variable ) where ever you need to view the contents of the variable.  The log will show up on the WordPress admin screen, on the PHP Logs menu.


== Installation ==

1. Upload the plugin file to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In your sidebar, click PHP Logs to view the logs of the  wp_php_log() function

== Frequently Asked Questions ==
= How do I use this plugin? =
Install the plugin, and whever you wish to view the contents of a variable in your plugin or theme add the code
`wp_php_log( $my_variable, "my variable" )` where $my_variable is the actual variable, and the optional parameter "my variable" to display as a heading the log for the variable.  If "my variable" is not set, it will default to a time stamp for when the variable was read.

== Screenshots ==



== Changelog ==

= WordPress PHP Logger 1.0.0 =
* Initial release
