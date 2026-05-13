<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('manage-settings');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Identity & Branding
            'app_name'         => ['required', 'string', 'max:100'],
            'company_name'     => ['required', 'string', 'max:150'],
            'site_tagline'     => ['nullable', 'string', 'max:255'],
            'brand_orange'     => ['required', 'string', 'max:7', 'regex:/^#[0-9a-fA-F]{6}$/i'],
            'brand_blue'       => ['required', 'string', 'max:7', 'regex:/^#[0-9a-fA-F]{6}$/i'],
            'font_family'      => ['nullable', 'string', 'max:100'],
            'theme_layout'     => ['nullable', 'in:light,dark,auto'],
            'logo'             => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'logo_dark_mode'   => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'logo_mobile'      => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'favicon'          => ['nullable', 'image', 'mimes:png,ico', 'max:512'],

            // Contact & Support
            'contact_email'    => ['nullable', 'email', 'max:255'],
            'support_email'    => ['nullable', 'email', 'max:255'],
            'sales_email'      => ['nullable', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'mobile_number'    => ['nullable', 'string', 'max:20'],
            'whatsapp'         => ['nullable', 'string', 'max:20'],
            'address'          => ['nullable', 'string', 'max:500'],
            'working_hours'    => ['nullable', 'string', 'max:255'],
            'map_embed_url'    => ['nullable', 'string', 'max:2000'], // string to allow iframe snippets

            // Localization & System
            'currency'         => ['nullable', 'string', 'max:10'],
            'currency_symbol'  => ['nullable', 'string', 'max:10'],
            'timezone'         => ['nullable', 'string', 'timezone'],
            'date_format'      => ['nullable', 'string', 'max:50'],
            'time_format'      => ['nullable', 'string', 'max:50'],
            'default_language' => ['nullable', 'string', 'max:10'],
            'pagination_limit' => ['nullable', 'integer', 'min:1', 'max:100'],

            // Social Media (Validating as actual URLs)
            'social_fb'        => ['nullable', 'url', 'max:255'],
            'social_x'         => ['nullable', 'url', 'max:255'],
            'social_insta'     => ['nullable', 'url', 'max:255'],
            'social_linkedin'  => ['nullable', 'url', 'max:255'],
            'social_youtube'   => ['nullable', 'url', 'max:255'],

            // Legal & Company Info
            'tax_number'           => ['nullable', 'string', 'max:50'],
            'company_reg_number'   => ['nullable', 'string', 'max:100'],
            'privacy_policy_url'   => ['nullable', 'string', 'max:255'], // string for relative routes (e.g. /privacy)
            'terms_conditions_url' => ['nullable', 'string', 'max:255'],

            // SEO, Tracking & Metadata
            'seo_title'             => ['nullable', 'string', 'max:255'],
            'seo_desc'              => ['nullable', 'string', 'max:500'],
            'seo_keywords'          => ['nullable', 'string', 'max:500'],
            'google_analytics_id'   => ['nullable', 'string', 'max:50'],
            'google_tag_manager_id' => ['nullable', 'string', 'max:100'],
            'facebook_pixel_id'     => ['nullable', 'string', 'max:100'],
            'recaptcha_site_key'    => ['nullable', 'string', 'max:255'],

            // Feature Toggles & Custom Injections
            'maintenance_mode'         => ['nullable', 'in:on,off'],
            'enable_user_registration' => ['nullable', 'in:on,off'],
            'enable_newsletter_popup'  => ['nullable', 'in:on,off'],
            'enable_live_chat'         => ['nullable', 'in:on,off'],
            'live_chat_script'         => ['nullable', 'string'],
            'custom_css'               => ['nullable', 'string'],
            'custom_js'                => ['nullable', 'string'],
            'footer_text'              => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'app_name'                 => 'application name',
            'brand_orange'             => 'primary brand color',
            'brand_blue'               => 'secondary brand color',
            'social_fb'                => 'Facebook URL',
            'social_x'                 => 'X (Twitter) URL',
            'social_insta'             => 'Instagram URL',
            'logo_dark_mode'           => 'dark mode logo',
            'logo_mobile'              => 'mobile logo',
            'map_embed_url'            => 'Google Maps embed link',
            'privacy_policy_url'       => 'privacy policy link',
            'terms_conditions_url'     => 'terms & conditions link',
            'enable_user_registration' => 'user registration toggle',
            'enable_newsletter_popup'  => 'newsletter popup toggle',
            'enable_live_chat'         => 'live chat toggle',
        ];
    }
}