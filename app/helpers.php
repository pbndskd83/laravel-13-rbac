<?php

if (!function_exists('site_settings')) {
    /**
     * Global helper to access the SettingsService anywhere in views/controllers.
     * 
     * @param string|null $key Retrieve a specific key. If null, returns all settings.
     * @param mixed $default The fallback value if key does not exist.
     * @return mixed
     */
    function site_settings($key = null, $default = null)
    {
        // Resolve the service from Laravel's Service Container
        $service = app(\App\Services\SettingsService::class);
        
        if (is_null($key)) {
            return $service->getAll();
        }
        
        return $service->get($key, $default);
    }
}