=== Plugin Name ===
Contributors: tom.maitland
Donate link: http://www.tommaitland.net/about/
Tags: access, capability, editor, permission, role, security, user, parents, cms, restrictions
Requires at least: 3.4.0
Tested up to: 3.5.1
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Restrict Page Parents restricts page parent options to those owned by the user, with the option of forcing a page parent.

== Description ==

Restrict Page Parents is a lightweight plugin to enhance the user permissions features of WordPress. It changes the option to set a page parent to only show pages owned by the current user. It can also be configured to force users to select a parent page before they're able to publish or save.

Restrict Page Parents prevents users from adding their own pages under sections of the site they do not own or are able to manage. Users can be confined to their own section of the website, making your site permissions much more secure.

Permissions can be configured for each user role, each individual user and turned on/off based on post types.

You can find out more about the plugin [here](http://www.tommaitland.net/restrict-page-parents) or on the [Github project page](https://github.com/tommaitland/rpp).

== Installation ==

Install the plugin through the 'Plugins' menu in WordPress, or by downloading the ZIP and following these instructions:

1. Download and extract the plugin files
2. Upload `restrict-page-parents` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the plugin from the 'Restrict Page Parents' option in the 'Settings' menu

== Frequently Asked Questions ==

= Can restrictions be overridden per user? =

Yes, a user can have different restrictions to those set for their role. This is all set up on the plugin options page.

= Do you provide support? =

Send me an email with any questions, or post in the plugin forum and I'll do my best to get back to you.

== Screenshots ==

1. The plugin options page.
2. Error that appears when a parent page is required.

== Changelog ==

= 1.1.0 =
* New feature: Parent restrictions can be turned on or off based on post types for more granular control.

= 1.0.4 =
* Bugfixes

= 1.0.3 =
* Added the current page parent to the drop down, even if it is owned by another user.

= 1.0.2 =
* Important bug fixes. Page parent drop down disappeared in rare cases.

= 1.0.1 =
* Bugfixes related to rare events when the author only owns a single tree of pages.

= 1.0.0 =
* First release of the plugin
* Localisation ready
* See plugin description for features

== Upgrade Notice ==

= 1.1.0 =
New feature: You can now turn on/off parent restrictions for specific post types.

= 1.0.4 =
Bugfixes

= 1.0.3 =
Added current parent to list, if already set.

= 1.0.2 =
Important bug fixes. Page parent drop down disappeared in rare cases.

= 1.0.1 =
Bugfixes related to rare events when the author only owns a single tree of pages.

= 1.0.0 =
Initial release of the plugin, upgrade alpha/beta versions immediately.
