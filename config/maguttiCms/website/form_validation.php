<?php

use App\maguttiCms\Rules\GoogleRecaptcha;
use Illuminate\Validation\Rule;

return [

		'contacts' => [
			'name'	  => 'required',
			'surname' => 'required',
            'subject' => 'required',
			'message' => 'required',
			'privacy' => 'required',
			'email'   => 'required|Between:3,64|Email',
			'request_product_id' => 'sometimes|exists:products,id',
			'company' => 'nullable|string',
            /*'captcha_token' => [
                Rule::when(true,[new GoogleRecaptcha(0.6),'required'])
            ]*/
		],

		'newsletter' => [
			'email' => 'required|Between:3,64|Email|unique:newsletters',
			'privacy' => 'required'
		],

		'cart-item-add' => [
			'product_code' => 'required',
			'quantity'     => 'required|numeric|min:1'
		],

		'cart-item-remove' => [
			'id' => 'required',
		],
        'cart-item-update' => [
			'id' => 'required',
            'quantity'     => 'required|numeric|min:1'
		],

		'order-submit' => [
			'cart_id'             => 'required|numeric',
			'billing_address_id'  => 'required|numeric',
			'shipping_address_id' => 'numeric'
		],

		'order-payment' => [
			'order_id'          => 'required|numeric',
			'payment_method_id' => 'required|numeric'
		],



		'validate-coupon' => [
			'code' => 'required|exists:discounts,code'
		],


		'address-new' => [
			'street'     => 'required',
			'number'     => 'required',
			'zip_code'   => 'required',
			'city'       => 'required',
			'province'   => 'required',
			'country_id' => 'required|numeric',
			'email'      => 'email'
		]
];
