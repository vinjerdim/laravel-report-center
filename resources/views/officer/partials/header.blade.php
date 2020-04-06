<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
	@if(View::exists('officer.layout.logo'))
        @include('officer.layout.logo')
	@endif
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a role="button" class="dropdown-toggle nav-link">
                <span>
                    @if(Auth::check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-photo">
                    @elseif(Auth::check() && Auth::user()->username)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->username, 0, 1) }}</span>
                    @elseif(Auth::guard(config('officer-auth.defaults.guard'))->check() && Auth::guard(config('officer-auth.defaults.guard'))->user()->username)
                        <span class="avatar-initials">{{ mb_substr(Auth::guard(config('officer-auth.defaults.guard'))->user()->username, 0, 1) }}</span>
                    @else
                        <span class="avatar-initials"><i class="fa fa-user"></i></span>
                    @endif

                    @if(!is_null(config('officer-auth.defaults.guard')))
                        <span class="hidden-md-down">{{ Auth::guard(config('officer-auth.defaults.guard'))->check() ? Auth::guard(config('officer-auth.defaults.guard'))->user()->name : 'Anonymous' }}</span>
                    @else
                        <span class="hidden-md-down">{{ Auth::check() ? Auth::user()->name : 'Anonymous' }}</span>
                    @endif

                </span>
                <span class="caret"></span>
            </a>
            @if(View::exists('officer.layout.profile-dropdown'))
                @include('officer.layout.profile-dropdown')
            @endif
        </li>
    </ul>
</header>
