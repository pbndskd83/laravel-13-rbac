<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

/**
 * Service to handle reading, writing, and caching application settings
 * using a local JSON file.
 */
class SettingsService
{
    protected string $path = 'settings.json';
    protected string $disk = 'local';
    protected string $cacheKey = 'app_settings_cache';

    /**
     * Get the default settings for the application.
     * 
     * @return array
     */
    public function getDefaults(): array
    {
        return [
            // --- Original Settings ---
            'app_name' => config('app.name', 'Laravel'),
            'company_name' => 'Binayak Solution',
            'site_tagline' => 'Innovating Digital Solutions',
            'brand_orange' => '#FFA500',
            'brand_blue' => '#214497',
            'font_family' => 'Plus Jakarta Sans',
            'theme_layout' => 'light',
            'logo' => null,
            'favicon' => null,
            'currency' => 'NPR',
            'currency_symbol' => 'Rs.',
            'timezone' => 'Asia/Kathmandu',
            'date_format' => 'Y-m-d',
            'contact_email' => 'info@binayaksolution.com',
            'phone' => '+977 1-000000',
            'whatsapp' => '',
            'address' => 'Kathmandu, Nepal',
            'tax_number' => '', // Can be used for PAN/VAT in Nepal
            'working_hours' => 'Sun - Fri, 9:00 AM - 6:00 PM',
            'map_embed_url' => '',
            'social_fb' => '',
            'social_x' => '',
            'social_insta' => '',
            'social_linkedin' => '',
            'social_youtube' => '',
            'seo_title' => 'Professional IT Solutions',
            'seo_desc' => 'Dynamic IT services for your business growth.',
            'seo_keywords' => 'software, web design, nepal, it solutions',
            'footer_text' => '© ' . date('Y') . ' Binayak Solution. All rights reserved.',
            'maintenance_mode' => 'off',
            'google_analytics_id' => '',

            // --- Newly Added Settings ---

            // System & Localization
            'time_format' => 'h:i A',             // e.g., 02:30 PM
            'default_language' => 'en',           // Good for multi-language setups
            'pagination_limit' => '15',           // Global default for paginated lists

            // Additional Branding & UI
            'logo_dark_mode' => null,             // Useful since you have a 'theme_layout' toggle
            'logo_mobile' => null,                // Alternative icon-only logo for mobile headers
            'custom_css' => '',                   // Allow admins to inject quick CSS overrides
            'custom_js' => '',                    // Allow admins to inject scripts without changing code

            // Additional Contact & Support
            'support_email' => 'support@binayaksolution.com',
            'sales_email' => 'sales@binayaksolution.com',
            'mobile_number' => '',                // To separate mobile from landline 'phone'

            // Legal & Company Info
            'company_reg_number' => '',           // Company Registrar details
            'privacy_policy_url' => '/privacy-policy',
            'terms_conditions_url' => '/terms',

            // Marketing, Tracking & Integrations
            'facebook_pixel_id' => '',
            'google_tag_manager_id' => '',
            'recaptcha_site_key' => '',           // For frontend contact forms
            
            // Feature Toggles (Enable/Disable UI sections)
            'enable_user_registration' => 'off',  // Toggle public signup
            'enable_newsletter_popup' => 'on',    // Toggle marketing popups
            'enable_live_chat' => 'off',          // Toggle Messenger/Tawk.to chat widget
            'live_chat_script' => '',             // Paste script for Tawk.to, Crisp, etc.
        ];
    }

    /**
     * Retrieve all settings, merging saved values with defaults.
     * Caches the result forever to prevent constant disk reads.
     * 
     * @return array
     */
    public function getAll(): array
    {
        return Cache::rememberForever($this->cacheKey, function () {
            // If no settings file exists yet, return defaults
            if (!Storage::disk($this->disk)->exists($this->path)) {
                return $this->getDefaults();
            }
            
            // Read and decode the JSON file safely
            $fileContent = Storage::disk($this->disk)->get($this->path);
            $saved = json_decode($fileContent, true) ?? [];
            
            // Merge defaults with saved settings so new keys always exist
            return array_merge($this->getDefaults(), $saved);
        });
    }

    /**
     * Get a specific setting by key.
     * 
     * @param string $key The setting key using dot notation
     * @param mixed $default The fallback value if key is not found
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->getAll(), $key, $default);
    }

    /**
     * Update settings and handle file uploads (logo/favicon).
     * 
     * @param array $data Validated request data
     * @return void
     */
    public function update(array $data): void
    {
        $current = $this->getAll();

        // List all keys that should be treated as file uploads
        $fileKeys = ['logo', 'logo_dark_mode', 'logo_mobile', 'favicon'];

        foreach ($fileKeys as $fileKey) {
            if (isset($data[$fileKey]) && $data[$fileKey] instanceof UploadedFile) {
                // Delete the old file from the 'public' disk if it exists
                if (!empty($current[$fileKey])) {
                    Storage::disk('public')->delete($current[$fileKey]);
                }
                // Store the new file in the 'site' directory on the 'public' disk
                $data[$fileKey] = $data[$fileKey]->store('site', 'public');
            } else {
                // Keep the old path if no new file was uploaded
                $data[$fileKey] = $current[$fileKey] ?? null;
            }
        }

        // Default maintenance_mode to 'off' if it's missing from the request
        $data['maintenance_mode'] = $data['maintenance_mode'] ?? 'off';
        
        $updated = array_merge($current, $data);
        $this->saveAndClearCache($updated);
    }

    /**
     * Reset specific setting keys back to their default values.
     * 
     * @param array $keys Array of setting keys to reset
     * @return void
     */
    public function resetKeys(array $keys): void
    {
        $current = $this->getAll();
        $defaults = $this->getDefaults();
        $fileKeys = ['logo', 'logo_dark_mode', 'logo_mobile', 'favicon'];

        foreach ($keys as $key) {
            // Delete physical files for any image keys being reset
            if (in_array($key, $fileKeys) && !empty($current[$key])) {
                Storage::disk('public')->delete($current[$key]);
            }
            $current[$key] = $defaults[$key] ?? null;
        }

        $this->saveAndClearCache($current);
    }

    /**
     * Perform a complete factory reset. Wipes the JSON file and cache.
     * 
     * @return void
     */
    public function reset(): void
    {
        $current = $this->getAll();
        
        // Clean up uploaded files before deleting settings
        foreach (['logo', 'favicon'] as $fileKey) {
            if (!empty($current[$fileKey])) {
                Storage::disk('public')->delete($current[$fileKey]);
            }
        }
        
        // Delete the JSON file and flush cache
        Storage::disk($this->disk)->delete($this->path);
        Cache::forget($this->cacheKey);
    }

    /**
     * Helper to save the JSON file and flush the cache.
     * 
     * @param array $data Data to save
     * @return void
     */
    private function saveAndClearCache(array $data): void
    {
        Storage::disk($this->disk)->put($this->path, json_encode($data, JSON_PRETTY_PRINT));
        Cache::forget($this->cacheKey);
    }
}