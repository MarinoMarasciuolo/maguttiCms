<?php

namespace App\maguttiCms\Rules;

use App\maguttiCms\Tools\SettingHelper;
use Illuminate\Contracts\Validation\Rule;


/**
 * @property float|mixed score
 */
class GoogleRecaptcha implements Rule
{


    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($params=0.5)
    {
        $this->score = $params;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (SettingHelper::getOption('captcha_site')) {
            // check google reCAPTCHA
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => SettingHelper::getOption('captcha_secret'),
                'response' => $value,
                'remoteip' => request()->getClientIp()
            ];

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            $result = json_decode(file_get_contents($url, false, $context));
            return $this->validateResult($result);
        }
        return true;
    }


    function  validateResult($result){

        if (
            !$result
            || !$result->success
            || $result->score < $this->score
            || $result->action != request()->get('captcha_action')
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.recaptcha');
    }
}
