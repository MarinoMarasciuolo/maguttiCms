@if (data_get($site_settings,'captcha_site'))
	<script src='https://www.google.com/recaptcha/api.js?hl={{get_locale()}}&render={{data_get($site_settings,'captcha_site')}}'></script>
@endif
