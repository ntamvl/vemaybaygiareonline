=== Advanced Featured Post Widget ===
Contributors: tepelstreel
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4P2ACVGPHY7WU
Tags: sidebar, widget, post, newspaper, feature, featured, image, post type
Requires at least: 2.9
Tested up to: 4.1
Stable tag: 3.4.1

With the Advanced Featured Post Widget you can put a certain post (or post type) in the focus and style it differently.

== Description ==

The Advanced Featured Post Widget does, what the [Featured Post Widget](http://wordpress.org/extend/plugins/post-feature-widget) is doing also; it's a customizable multi-widget, that displays a single post in the widget area. You can decide, whether or not the post thumbnail is displayed, whether the post title is above or beneath the thumbnail and a couple of more things. And of course, you can style the widget individually.

So far that is the same as my Featured Post Widget does also. Not every theme has the possibility to hide certain sidebars on different pages. That's where the advanced of our plugin comes in. In the AFPW you can determine, where exactly the widget is showing and in the settings you can customize the links of your widget(s).

== Installation ==

1. Upload the `advanced-featured-post` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place and customize your widgets
4. Define the style of the links in the settings section

== Frequently Asked Questions ==

= The Widget doesn't show on my site =

Look at the source code of your site. If it says at one point,

'Advanced Featured Post Widget is not setup for this view.'

you can change the visibility of the widget in the widget's settings according to your choices.

= Version 2.4 and 2.5 of the plugin destroy the widget page in the admin area =

I'm terribly sorry that this seems to happen with a couple of updates. The Advanced Featured Post Widget seems to really block the widgets.php from further loading. There was a big mixup while updating the plugin. With version 2.6 this should not happen anymore. 

= I styled the widget container myself and i looks bad. What do I do? =

The styling of the widget requires some knowledge of css. If you are not familiar with that, try adding

`padding: 10px;
margin-bottom: 10px;`
 
to the style section.

= My widget should have rounded corners, how do I do that? =

Add something like

`-webkit-border-top-left-radius: 5px;
-webkit-border-top-right-radius: 5px;
-moz-border-radius-topleft: 5px;
-moz-border-radius-topright: 5px;
border-top-left-radius: 5px;
border-top-right-radius: 5px;`
 
to the widget style. This is not supported by all browsers yet, but should work in almost all of them.

= My widget should have a shadow, how do I do that? =

Add something like

`-moz-box-shadow: 10px 10px 5px #888888;
-webkit-box-shadow: 10px 10px 5px #888888;
box-shadow: 10px 10px 5px #888888;`
 
to the widget style to get a nice shadow down right of the container. This is not supported by all browsers yet, but should work in almost all of them.

= I styled the links of the widget differently, but the changes don't show, what now? =

Most of the time you will have to use the styles like that:

'font-weight: bold !important;
color: #0000dd !important;'

Since the stylesheet of the theme will have a higher priority, you will have to make your styles more important in the hierarchy.

== Screenshots ==

1. The plugin's work on our testing site
2. The widget's settings section
3. The plugin's settings section

== Changelog ==

= 3.4.1 =

* bug on update fixed

= 3.4 =

* small bugfix
* more options for virtual styles

= 3.3.5 =

* Ukrainian translation added thanks to Michael Yunat([http://getvoip.com](http://getvoip.com))

= 3.3.4 =

* Mistake in image class fixed

= 3.3.3 =

* Interference with Wordpress Page Widgets eliminated

= 3.3.2 =

* Bug with fetching the image fixed

= 3.3.1 =

* DSS now compressible

= 3.3 =

* Code correction

= 3.2 =

* All 'Divided by Zero' errors should be eliminated

= 3.1 =

* More foolproof

= 3.0 =

* Ability to display images better

= 2.9.3 =

* Instead of styling each individual widget, you can style now the whole class

= 2.9.2 =

* more features, post types included, fine-tuning

= 2.9.1 =

* Post Category can be shown now

= 2.9 =

* More options added

= 2.8.6 =

* Loads of inner beauty added

= 2.8.5 =

* Slovak translation added thanks to [Branco Radenovich](http://webhostinggeeks.com/blog/)

= 2.8.4 =

* no multiple posts when wanting a random post 

= 2.8.3 =

* bugfix with headline and css

= 2.8.2 =

* bugfix in framework

= 2.8.1 =

* bugfix with missing class

= 2.8 =

* adjustable size of the post headline

= 2.7 =

* also the wp thumbnail is adjustable in size now

= 2.6 =

* bugfix, the plugin doesn't crash the widget area anymore

= 2.5 =

* Bugfix and translations changed

= 2.4 =

* Some classes added to framework

= 2.3 =

* Small bugfix in autoexcerpt

= 2.2 =

* Added functionality on demand
* Complete overhaul of the code; should work smoother now
* Hooks into the [Ads Easy Plugin](http://wordpress.org/extend/plugins/adeasy) if Google AdSense Tags are in use

= 2.1 =

* More accurate excerpt function
* Images have better 'title' tags
* Get's also an image if working with galleries
* Uses dss instead of writing a css file all the time

= 2.0 =

* Bugfixes and streamlining done; choosing posts is easier now and if you don't choose a post, a random post will be taken

= 1.5 =

* The textareas are now resizable and the input fields got smaller

= 1.1 =

* Bug with empty stylesheet on possible update fixed; settings accessible from plugin page now

= 1.0 =

* Initial release with German and Dutch language pack

== Upgrade Notice ==

= 3.1 =

More foolproof

= 3.0 =

Ability to display images is now better

= 2.9.3 =

Instead of styling each individual widget, you can style now the whole class

= 2.9.2 =

more features, post types included, finetuning

= 2.9.1 =

Post Category can be shown now

= 2.9 =

More options added

= 2.8.6 =

Loads of inner beauty added

= 2.8.5 =

Slovak translation added

= 2.8.4 =

no multiple posts when wanting a random post

= 2.8.3 =

bugfix with headline and css

= 2.8.2 =

bugfix in framework

= 2.8.1 =

bugfix with missing class

= 2.8 =

adjustable size of the post headline

= 2.7 =

also the wp thumbnail is adjustable in size now

= 2.6 =

bugfix, the plugin doesn't crash the widget area anymore

= 2.5 =

Bugfix and translations changed

= 2.4 =

Some classes added to framework

= 2.3 =

Small bugfix in autoexcerpt

= 2.2 =

Added functionality on demand
Complete overhaul of the code; should work smoother now
Hooks into the Ads Easy Plugin if Google AdSense Tags are in use

= 2.1 =

More accurate excerpt function
Images have better 'title' tags
Get's also an image if working with galleries
Uses dss instead of writing a css file all the time

= 2.0 =

Bugfixes and streamlining done; choosing posts is easier now and if you don't choose a post, a random post will be taken

= 1.5 =

The textareas are now resizable and the input fields got smaller

= 1.1 =

Bug with empty stylesheet on possible update fixed; settings accessible from plugin page now

= 3.2 =

All 'Divided by Zero' errors should be eliminated

= 3.3 =

Code correction

= 3.3.1 =

DSS now compressible

= 3.3.2 =

Bug with fetching the image fixed

= 3.3.3 =

Interference with Wordpress Page Widgets eliminated

= 3.3.4 =

Mistake in image class fixed

= 3.3.5 =

Ukrainian translation added

= 3.4 =

small bugfix; more options for virtual styles

= 3.4.1 =

bug on update fixed