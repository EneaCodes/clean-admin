# Clean Admin – Hide Dashboard Ads

**Clean Admin** is a lightweight WordPress plugin that cleans up your `wp-admin` area by hiding most ads, review messages and promo banners, while keeping real warnings and errors visible.  

Power users can also define their own custom promo/review keywords to hide, and developers can hook into the keyword lists via simple filters.

---

## ✨ Features

- Hides dashboard promo widgets and sale banners  
- Hides “Rate us / Leave a review” style messages  
- Hides common plugin promo / upsell boxes on settings pages  
- Keeps WordPress core error/warning notices visible  
- Simple settings page under **Settings → Clean Admin**  
- Custom promo + review keyword lists (comma-separated)  
- Translation-ready (`clean-admin` text domain)  
- One-click **Reset to Defaults** button  
- Handy activation notice with direct **Settings** link  
- Small, focused codebase – no impact on the frontend

---

## 📦 Files in This Plugin

- `clean-admin.php` – main plugin file  
- `caa-admin-clean.js` – admin cleaner script  
- `readme.txt` – WordPress.org-style readme (for the plugin directory)  
- `languages/` *(optional)* – translation files (e.g. `clean-admin.pot`)

---

## 🚀 Installation

### 1. Install via ZIP upload (most common)

1. Download the plugin as a ZIP (either from GitHub “Download ZIP” or a release).  
   The ZIP should contain the `clean-admin` folder with all plugin files inside.
2. In your WordPress dashboard, go to:  
   **Plugins → Add New → Upload Plugin**.
3. Click **Choose File**, select the `clean-admin.zip`, then click **Install Now**.
4. When installation finishes, click **Activate Plugin**.
5. Go to **Settings → Clean Admin** and configure what to hide.

> ✅ Tip: Make sure the folder inside `wp-content/plugins/` is named exactly `clean-admin`.

---

### 2. Install via Git (for developers)

```bash
cd wp-content/plugins
git clone https://github.com/EneaCodes/Bros-Clean-Admin.git
