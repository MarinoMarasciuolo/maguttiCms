@if(MaguttiFeatures::hasReservedArea())

	@if (!Auth::guard()->check())
		<li class="nav-item">
			<a class="nav-link" href="{{url_locale('users/login')}}">
				{{trans('auth.login')}}
			</a>
		</li>
	@else
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" role="button"
			   id="dd_auth"
			   data-bs-toggle="dropdown" aria-expanded="false" >{{Auth::guard()->user()->name}}</a>
			<div class="dropdown-menu" aria-labelledby="#dd_auth">
				@if(StoreFeatures::isStoreEnabled())
				<a class="dropdown-item" href="{{url_locale('users/dashboard')}}">
					{{icon('list')}} {{trans('auth.dashboard')}}
				</a>
				@endif
				<a class="dropdown-item" href="{{url_locale('users/profile')}}">
					{{icon('user')}} {{trans('auth.profile')}}
				</a>
				<a class="dropdown-item" href="{{url_locale('logout')}}">
					{{icon('sign-out-alt')}} {{trans('auth.logout')}}
				</a>
			</div>
		</li>
	@endif
@endif
