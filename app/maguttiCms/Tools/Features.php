<?php

namespace App\maguttiCms\Tools;

// Magutti Cms Features
class Features
{

    /**
     * Determine if the given feature is enabled.
     *
     * @param string $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        return in_array($feature, config('maguttiCms.option.features', []));
    }

    /**
     * @param string $feature
     * @return bool
     */
    public static function hasFeature(string $feature) : bool
    {
        return (bool)SettingHelper::getOption($feature);
    }

    /**
     * @param string $feature
     * @return mixed|string
     */
    public static function getFeature(string $feature)
    {
        return SettingHelper::getOption($feature);
    }
}