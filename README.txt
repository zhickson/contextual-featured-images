=== Contextual Featured Images ===
Contributors: zacharyh96
Donate link: https://www.paypal.me/dunktree
Tags: post thumbnail, featured image, categories, context, contextual featured image, thumbnail
Requires at least: 4.9
Tested up to: 5.2.2
Stable tag: trunk
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Displays a custom featured image (thumbnail) based on the context of the current post.

== Description ==

Contextual Featured Images provides the functionality to assign a featured image to a post's category. 
Then, depending on the context of the post, the custom featured image you set will be used.

Example: Say you have a post with multiple categories such as "Teens", "Adults", etc. When you are visiting the "Teens" archive, you want to show a targeted image for teens, but when visiting the "Adults" archive, you want to show an adult specific image, this plugin will allow you to do that.

It allows you to personalise how posts are displayed to your visitors. Think Netflix's personalisation of show covers, but much simpler. ;)

How to use:
1. Assign a category, tag, custom taxonomy or term to the current post you are editing.
2. Save the post, and refresh the screen. (this is so the plugin can pick up the term(s) you have just assigned)
3. Select the post term in the Metabox on the Edit screen.
4. Select an existing image from the WordPress Media Library or Upload a new custom image.
5. Your selection will be saved automatically in the background. 

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/contextual-featured-images` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. The plugin will work automatically, out-of-the-box.

== Frequently Asked Questions ==

= Does this support Custom Post Types? =

Yes, any post type that supports featured images will show the CFI metabox.

= What about the actual featured image? =

By default, the actual featured image will be displayed.
Unless, there are custom thumbnail's set for a category, and that category is active (i.e. Category Archives)

== Screenshots ==

1. The UI for when the Classic Editor is active.
2. The UI for when Gutenberg is active.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
Initial plugin release.