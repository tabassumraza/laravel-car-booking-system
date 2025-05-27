<?php 
    if (!function_exists('setting')) {
    function setting($key = null, $default = null)
    {
        if (is_null($key)) {
            return new \App\Models\Setting;
        }
        
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                \App\Models\Setting::updateOrCreate(
                    ['key' => $k],
                    ['value' => $v]
                );
            }
            return true;
        }
        
        $setting = \App\Models\Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}