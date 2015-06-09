=== Plugin Name ===
Contributors: mrxthefifth
Tags: author, custom author, custom post author, any user author, user
Requires at least: 3.0.1
Tested up to: 4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin lets you assign non-authors as post author.

== Description ==

Do you have a blog/website with a lot of contributing authors but you do not want to give them the rights to publish
the articles themselves for whatever reason? In that case it would be nice when you are able to give them credit for
what they wrote anyway. Since WordPress cannot override the author with a non-author by default, this plugin overrides
the Author meta-box with a meta box that can select any user.

So whenever you want to place an article that was written by someone else, you just create a user with subscriber role
(if he/she hasn't already) and assign the article to that user!

== Installation ==

= Install via WordPress Admin =
1. Go to Admin > Plugins > Add New
2. Either search for Change Author or upload the zip file and click "Install"
3. After installation, activate it

= Install via FTP =
1. First unzip the plugin file
2. Using FTP go to your server's wp-content/plugins directory
3. Upload the unzipped plugin here
4. Once finished login into your WP Admin and go to Admin > Plugins
5. Look for Change Author and activate it


== Frequently Asked Questions ==

= Do I need to configure anything? =

No, this plugin does not need a settings page.

= I don't see the meta box, where is it? =

Click 'Screen Options' at the upper right corner and check the box next to 'Author'.

= Why can't I just type the name of the person I want to credit as author instead of having to use a user account? =

Well, some themes link the author name to the author archive and that needs a user account to work. So this plugin will not break such theme functions.


== Changelog ==

= 1.0 =
* Initial release

= 1.1 =
* Fixed translation
* Updated tags