<div {{ $attributes->merge(['class' => 'swiper-slide'])}}>
    <img src="{{ ImgHelper::init($attributes['disk'])->get_cached($image, config($config)) }}"
        alt="" class="img-fluid w-100">
</div>