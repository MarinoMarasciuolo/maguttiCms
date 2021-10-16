<?php

namespace App\maguttiCms\Website\Controllers;


use Input;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

use App\maguttiCms\Tools\JsonResponseTrait;
use App\maguttiCms\Website\Requests\AjaxFormRequest;

use App\maguttiCms\Domain\Store\Action\AddCouponToNewsletter;
use App\maguttiCms\Domain\Newsletter\Action\NotifyNewSubscriberAction;
use App\maguttiCms\Domain\Newsletter\Action\AddNewsletterSubscriberAction;


class APIController extends Controller
{
    private array $attributes_bag ;
    use JsonResponseTrait;
   /**
     * @return mixed
     */
    public function subscribeNewsletter(AjaxFormRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules());

        $coupon_code = (new AddCouponToNewsletter())->execute();
        if($coupon_code)$this->attributes_bag['coupon_code']= $coupon_code;

        $this->attributes_bag['locale'] = app()->getLocale();

        // merge custom attributes
        $validated = $validator->safe()->merge($this->attributes_bag);

        $newsletter = (new AddNewsletterSubscriberAction($validated->all()))->execute();

        (new NotifyNewSubscriberAction($newsletter))->execute();

        return $this->responseSuccess(__('website.mail_message.subscribe_newsletter_feedback'))->apiResponse();
    }

}
