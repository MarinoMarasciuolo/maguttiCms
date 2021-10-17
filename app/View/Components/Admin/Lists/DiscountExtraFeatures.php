<?php

namespace App\View\Components\Admin\Lists;

use App\Domain;
use App\Setting;
use Illuminate\View\Component;

class DiscountExtraFeatures extends ExtraFeatures
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $newsletter_add_welcome_coupon;
    public $newsletter_coupon_discount_amount;

    public function __construct()
    {
        //
        $this->newsletter_add_welcome_coupon = Setting::firstWhere('key','newsletter_add_welcome_coupon');
        $this->newsletter_coupon_discount_amount = Setting::firstWhere('key','newsletter_coupon_discount_amount');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.lists.discount-extra-features');
    }
}
