=== Admin Clean – Hide Dashboard Ads ===
Contributors: Enea
Author : Enea
Donate link: https://ko-fi.com/W7W51P4XY6
Tags: admin, dashboard, clean, ads, elementor, notices, nag, promotions
Plugin URI: https://github.com/EneaCodes/admin-clean
Requires at least: 5.6
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Clean up your WordPress admin area by hiding most ads, review nags, and promo banners while keeping real warnings and errors visible.

== Description ==
...

If you enjoy this plugin and want to support development, you can buy me a coffee here:
https://ko-fi.com/W7W51P4XY6

Development and source code:

* Author profile: https://github.com/EneaCodes/
* Plugin repository: https://github.com/EneaCodes/admin-clean

== Installation ==

1. Upload the `admin-clean` folder to the `/wp-content/plugins/` directory, or install via the Plugins → Add New screen.
2. Activate **Admin Clean – Hide Dashboard Ads** through the "Plugins" menu in WordPress.
3. Go to **Settings → Admin Clean** and choose which types of notices to hide.
4. (Optional) Add your own keywords in the advanced settings to hide more promo/review texts.

== Frequently Asked Questions ==

= Does this affect my site frontend? =

No. Admin Clean only runs in the WordPress admin area (`/wp-admin`).

= Will it hide core error messages? =

The plugin tries to keep anything that looks like a real error or warning (for example WordPress core error notices).
It mainly targets promotional, upsell, and review messages.

= Can this break a plugin? =

It only hides UI elements with CSS/JS based on their text content and classes.
It does not disable hooks or remove code, so in normal cases it should not break functionality.
...

= Does it support Elementor / similar plugins? =

Yes, Admin Clean can hide many Elementor / ElementsKit / other builder-related notices and review nags, but it cannot guarantee 100% coverage for every plugin.

= Where is the Settings link? =

On the Plugins page, there is a direct **Settings** link under Admin Clean, or go to **Settings → Admin Clean**.

== Advanced Usage ==

= Custom Keywords =

You can add your own keywords to hide specific promotions or review requests. For example:

* To hide "Early Bird" offers: add `early bird` to **Custom Promo Keywords**.
* To hide "Beta Tester" requests: add `beta tester` to **Custom Review Keywords**.

Each field accepts a comma-separated list of phrases. Matching is done in a simple "contains text" way, case-insensitive.

= Hooks for Developers =

You can extend or modify the built-in word lists:

`add_filter( 'caa_promo_words', function( $words ) { $words[] = 'early bird'; return $words; } );`

`add_filter( 'caa_review_words', function( $words ) { $words[] = 'beta tester'; return $words; } );`

== Screenshots ==

1. Cleaned-up dashboard with most promo boxes removed.
2. Settings page with simple toggles for which ads/nags to hide.
3. Advanced section with custom keyword lists.

== Changelog ==

= 1.1.0 =
* Added text domain loading for translations.
* Added "Settings" link on Plugins page.
* Added activation notice with direct link to settings.
* Improved default keyword lists for promo and review notices.
* Internal refactors and cleanups.

= 1.0.0 =
* Initial release.
