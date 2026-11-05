# Custom Login Branding

**Contributors:** braxtonmoody, techtankholdings  
**Plugin Name:** Custom Login Branding  
**Requires at least:** 5.0  
**Tested up to:** 7.1  
**Requires PHP:** 7.4  
**License:** [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html)

---

Branded, configurable WordPress login page with logo, background image, colors, and basic security options.

---

## Overview

Custom Login Branding lets you replace the default WordPress login screen with your own brand: a custom logo, an optional full-screen background image, and a color scheme that matches your site. Everything is configured from a single settings screen and rendered locally, so there are no external requests.

## Features

- Custom logo image (transparent PNG or SVG recommended)
- Optional full-screen background image with adjustable dark overlay
- Configurable form width and logo dimensions
- Color control for primary, button, button-hover, link, and form background colors
- Hide the "Back to site" link and the language switcher
- Replace username-specific login errors with a generic message
- Remove the login form "shake" on failed login
- Block author enumeration (`?author=N` requests)
- No external requests; everything renders locally

## Requirements

- WordPress 5.0+
- PHP 7.4+

## Installation

1. Upload the `custom-login-branding` folder to `/wp-content/plugins/`, or install through the WordPress Plugins screen.
2. Activate the plugin through the Plugins menu.
3. Go to **Settings → Custom Login Branding** and configure your logo, background, colors, and options.
4. Save. The changes appear on your login page.

## FAQ

### Can I use any image format for the logo?

Yes. For the logo, a transparent PNG or SVG is recommended. For the background, an optimized JPG or WebP keeps load times down.

### Does this plugin send any data off-site?

No. Everything is configured and rendered on your own server.

### Does it work with Multisite?

Yes. Options are stored per-site, so each site in a network can have its own branding.

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).