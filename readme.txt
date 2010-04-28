=== Plugin Name ===
Contributors: Benoit "LeBen" Burgener
Donate link: http://www.benoitburgener.com/
Tags: like, love, post, rate, rating
Requires at least: 2.3
Tested up to: 2.8.5
Stable tag: 2.8.5.5

This plugin allows your visitors to simply like your posts instead of comment it.

== Installation ==

1. Upload the directory `/i-like-this/` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

1. The plugin doesn't work?
	* Make sure that you have only ONE time jQuery enabled in your theme (you can disable it under the preferences pane).
1. How can I put the counter wherever I want?
	* Place `<?php if(function_exists(getILikeThis)) getILikeThis('get'); ?>` wherever you want in your templates but don't forget to put it into the loop if the page display more than one post.
	* Disable "Automatic Display" under the preference pane.

== Screenshots ==

Some screenshots are available on the [plugin homepage](http://www.benoitburgener.com/blog/plugin-wordpress-i-like-this).

== Changelog ==

= 1.4b =
* You can now personalize the link to vote, image (+) or text (everything you want).
* Added a clean .pot file if you want to translate the plugin in your language.
* Deactivated automatic display on pages.

= 1.3b =
* Directory link bug for the ajax request fixed (really, this time)

= 1.2b =
* French translation
* Directory link bug for the ajax request fixed

= 1.1b =
* Preferences pane: enable/disable jQuery framework, enable/disable automatic display.

= 1.0b =
* This is the first version