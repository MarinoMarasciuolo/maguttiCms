<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Magutti" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('maguttiCms.admin.option.title') }}</title>

	<link rel="icon" href="{{ asset('/favicon.ico') }}" type="any" sizes="20x20">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400"/>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.1/cropper.min.css">

	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.plugins').'uploadifive/uploadifive.css') }}">
	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.plugins').'selectize/selectize.bootstrap3.css') }}">
	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.plugins').'custom-scrollbar/jquery.mCustomScrollbar.min.css') }}" />
	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.plugins').'colorpicker/css/bootstrap-colorpicker.min.css') }}" />
	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.common_css').'ma_helper.css') }}">
	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.assets').'cms/css/bootstrap-theme.css') }}">

	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.assets').mix('cms/css/vendor.css')) }}">
	<link rel="stylesheet" href="{{ asset(config('maguttiCms.admin.path.assets').mix('cms/css/app.css')) }}">

	<script type="text/javascript">
		// init some global variable
		var _SERVER_PATH = "{{ url('') }}";
		var _LOCALE = "{{ app()->getLocale() }}";
		var _CURMODEL = "{{ (isset($pageConfig['model']) ? $pageConfig['model'] : "" ) }}";
	</script>

</head>

<body class="{{(!Auth::guard('admin')->check())? 'login': ''}}">
<div id="app">
	@if (Auth::guard('admin')->check())
		@include('admin.common.navbar')
	@endif

	@yield('content')
</div>
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="{{ asset(config('maguttiCms.admin.path.assets').mix('/cms/js/cmsvendor.js')) }}"></script>
<script src="//code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.1/cropper.min.js" charset="utf-8"></script>
<script src="{{ asset(config('maguttiCms.admin.path.plugins').'custom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset(config('maguttiCms.admin.path.plugins').'notify.min.js') }}"></script>
<script src="{{ asset(config('maguttiCms.admin.path.plugins').'tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset(config('maguttiCms.admin.path.plugins').'colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset(config('maguttiCms.admin.path.plugins').'bootbox.js') }}"></script>
<script src="{{ asset(config('maguttiCms.admin.path.assets').mix('cms/js/cms.js')) }}"></script>
<script src="{{ asset(config('maguttiCms.admin.path.assets').mix('cms/js/header.js')) }}"></script>
<script src="{{ asset(config('maguttiCms.admin.path.assets').mix('cms/js/appcms.js')) }}"></script>

<script>
	$(document).ready(function() {
		Cms.init();
	});
</script>

@yield('footerjs')
</body>
</html>
