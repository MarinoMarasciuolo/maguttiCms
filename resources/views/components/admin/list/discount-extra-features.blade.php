<div class="card">
<h3>{{__('Welcome coupon for newsletters subscriber')}}</h3>
<div class="row row-cols-auto g-3">
    <div class="text-center">
        <x-admin.form.input-boolean
           :label="__('Enable/Disable')"
           :for="'Setting_value_'.$newsletter_coupon_discount_amount->id"
           :value="$newsletter_add_welcome_coupon->value"

           class="align-items-center"
           data-list-boolean="{{ 'Setting_'.$newsletter_add_welcome_coupon->id }}"
           data-list-name="value"
        />
    </div>
    <div>
        <x-admin.form.input
           :label="$newsletter_coupon_discount_amount->description"
           :for="'Setting_value_'.$newsletter_coupon_discount_amount->id"
           :value="$newsletter_coupon_discount_amount->value"

           data-list-value="{{ 'Setting_'.$newsletter_coupon_discount_amount->id }}"
           data-list-name="value"
         />
    </div>
</div>
</div>