=== Branded Login Page ===
Contributors:      techtankholdings
Donate link:       https://techtankholdings.com/
Tags:              login, branding, customize, admin, security, login page
Requires at least: 5.0
Requires PHP:      7.4
Tested up to:      7.1
Stable tag:        1.0.1
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Branded, configurable WordPress login page with logo, background image, colors, and basic security options.

== Description ==

Branded Login Page gives store and site owners an easy way to make the WordPress login screen match their brand. Instead of the default WordPress logo and plain background, you can set your own logo, a background image, and a color scheme from a single settings screen.

All styling is generated from stored options and applied on the login page with no page-weight cost. Options are sanitized on save, and the plugin follows WordPress coding standards.

= Features =

* Custom logo image (transparent PNG or SVG recommended)
* Optional full-screen background image with adjustable dark overlay
* Configurable form width and logo dimensions
* Color control for primary, button, button-hover, link, and form background colors
* Hide the "Back to site" link and the language switcher
* Replace username-specific login errors with a generic message
* Remove the login form "shake" on failed login
* Block author enumeration (?author=N requests)
* No external requests; everything renders locally

= Requirements =

* WordPress 5.0+
* PHP 7.4+

== Installation ==

1. Upload the `branded-login-page` folder to `/wp-content/plugins/`, or install the plugin through the WordPress **Plugins** screen.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Go to **Settings → Branded Login Page** and configure your logo, background, colors, and options.
4. Save. The changes appear on your login page.

== Frequently Asked Questions ==

= Can I use any image format for the logo? =

Yes. For the logo, a transparent PNG or SVG is recommended. For the background, an optimized JPG or WebP keeps load times down.

= Does this plugin send any data off-site? =

No. Everything is configured and rendered on your own server.

= Does it work with Multisite? =

Yes. Options are stored per-site, so each site in a network can have its own branding.

== Changelog ==

= 1.0.1 =
* Initial public release.