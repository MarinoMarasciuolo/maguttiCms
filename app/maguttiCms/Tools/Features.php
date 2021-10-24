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

       return in_array($feature, config('maguttiCms.website.option.features', []));
    }

    public static function optionEnabled(string $feature, string $option)
    {
        return static::enabled($feature) && config("maguttiCms.website.option.{$feature}.{$option}") === true;
    }




    /**
     * Determine if the application has user login /registration enable.
     *
     * @return bool
     */
    public static function hasReservedArea()
    {
       return static::enabled(static::enableReservedArea());
    }
    /**
     * Enable the profile photo upload feature.
     *
     * @return string
     */
    public static function enableReservedArea()
    {
        return 'reserved-area';
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