<?php

if (!function_exists('applicationVersion')) {
    function applicationVersion($default = 'Unknown')
    {
        $versionFilePath = public_path('version');
        if (file_exists($versionFilePath)) {
            return file_get_contents($versionFilePath);
        }

        return $default;
    }
}
