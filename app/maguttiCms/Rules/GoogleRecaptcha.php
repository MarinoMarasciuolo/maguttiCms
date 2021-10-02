<?php

namespace App\maguttiCms\Rules;

use App\maguttiCms\Tools\SettingHelper;
use Illuminate\Contracts\Validation\Rule;


class GoogleRecaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
            // controllo google reCAPTCHA
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

            if (
                !$result
                || !$result->success
                || $result->score < 0.5
                || $result->action != request()->get('captcha_action')
            ) {
                return false;
            }
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
