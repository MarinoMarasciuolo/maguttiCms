<?php namespace App\maguttiCms\Tools;

 use App\Setting;
/**
 * Class Setting
 * @package App\maguttiCms\Tools
 */
class SettingHelper {

	/**
	 * @param $key
	 * @return mixed
     */
	static public function getOption($key)
	{
		$settingObj = Setting::firstWhere('Key',$key);
		return  ($settingObj)
            ? $settingObj->value
            :  '';
	}

}
