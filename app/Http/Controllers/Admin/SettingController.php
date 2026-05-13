<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * Class SettingController
 * Handles the display, update, and resetting of global application settings.
 */
class SettingController extends Controller
{
    /**
     * Inject the SettingsService to handle all business logic related to settings.
     */
    public function __construct(protected SettingsService $settings) {}

    /**
     * Display the settings edit form.
     */
    public function edit()
    {
        // Ensure the user has the correct permissions
        Gate::authorize('manage-settings');
        
        // Retrieve all current settings (merging saved data with defaults)
        $data = $this->settings->getAll();
        
        return view('admin.settings.edit', compact('data'));
    }

    /**
     * Update the global configurations.
     * Uses UpdateSettingsRequest to handle all validation before reaching this method.
     */
    public function update(UpdateSettingsRequest $request)
    {
        // Pass the validated data directly to the service for processing and caching
        $this->settings->update($request->validated());
        
        return back()->with('success', 'Configurations updated successfully.');
    }

    /**
     * Reset a specific section of settings back to their default values.
     */
    public function resetSection(Request $request, $section)
    {
        Gate::authorize('manage-settings');

        // Map the requested section to its corresponding JSON keys
        $keys = match($section) {
            'identity'     => ['app_name', 'company_name', 'site_tagline', 'brand_orange', 'brand_blue', 'font_family', 'theme_layout', 'logo', 'logo_dark_mode', 'logo_mobile', 'favicon'],
            'contact'      => ['contact_email', 'support_email', 'sales_email', 'phone', 'mobile_number', 'whatsapp', 'address', 'working_hours', 'map_embed_url'],
            'localization' => ['currency', 'currency_symbol', 'timezone', 'date_format', 'time_format', 'default_language'],
            'social'       => ['social_fb', 'social_x', 'social_insta', 'social_linkedin', 'social_youtube'],
            'seo'          => ['seo_title', 'seo_desc', 'seo_keywords'],
            'legal'        => ['tax_number', 'company_reg_number', 'privacy_policy_url', 'terms_conditions_url'],
            'system'       => ['maintenance_mode', 'pagination_limit', 'footer_text'],
            'integrations' => ['google_analytics_id', 'google_tag_manager_id', 'facebook_pixel_id', 'recaptcha_site_key'],
            'advanced'     => ['enable_user_registration', 'enable_newsletter_popup', 'enable_live_chat', 'live_chat_script', 'custom_css', 'custom_js'],
            default        => [] // Return empty array if the section doesn't exist
        };

        // Prevent errors if a user manipulates the URL with an invalid section
        if (empty($keys)) {
            return back()->with('error', 'Invalid section specified.');
        }

        // Pass the matched keys to the service to reset them
        $this->settings->resetKeys($keys);
        
        return back()->with('success', ucfirst($section) . ' settings reset to default.');
    }

    /**
     * Perform a complete factory reset of all application settings.
     */
    public function reset()
    {
        Gate::authorize('manage-settings');
        
        // Trigger the complete reset and cache clearing
        $this->settings->reset();
        
        return back()->with('success', 'All settings reverted to factory defaults.');
    }
}