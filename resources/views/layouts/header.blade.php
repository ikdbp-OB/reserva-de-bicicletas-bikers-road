<header class="header__layout">
    <div class="logo__container">
        <a class="logo__link nav__links" alt="" href="{{ route('home') }}">
            <x-icons.application-logo />
            <h1>Biker's road</h1>
        </a>
        
    </div>
    <nav class="header__nav">

        <div class="mobile__nav" id="mobile__nav" aria-hidden="true" inert>
            <a href="{{ route('home')}}" class="nav__links">{{ __('tid_home')}}</a>
            <a href="{{ route('bikes.index')}}" class="nav__links">{{ __('tid_bikes')}}</a>
            <a href="{{ route('bookings.index') }}" class="nav__links">{{ __('tid_my_bookings')}}</a>
        </div>

        <div class="header__pages">
            <a href="{{ route('home')}}" class="nav__links">{{ __('tid_home')}}</a>
            <a href="{{ route('bikes.index')}}" class="nav__links">{{ __('tid_bikes')}}</a>
            <a href="{{ route('bookings.index') }}" class="nav__links">{{ __('tid_my_bookings')}}</a>
        </div>
        <div class="header__icons" id="header__icons">
            <button
                type="button"
                id="theme-toggle"
                aria-label="{{ __('tid_theme_switch_to_dark') }}"
                aria-pressed="false"
                data-dark-label="{{ __('tid_theme_switch_to_light') }}"
                data-light-label="{{ __('tid_theme_switch_to_dark') }}"
            >
                <x-icons.moon-icon />
                <x-icons.sun-icon />
            </button>
            
            <a href="{{ route('profile.edit') }}" class="icon__link" title="{{ __('tid_profile') }}">
                <x-icons.user-icon />
            </a>
                
            <button
                type="button"
                id="header__menu"
                aria-label="{{ __('tid_menu') }}"
                aria-expanded="false"
                aria-controls="mobile__nav"
            >
                <x-icons.menu-icon />
                <x-icons.close-menu-icon />
            </button>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="form_logout">
                    @csrf
                    <button type="submit" class="icon__button" title="{{ __('tid_logout') }}">
                        <x-icons.logout-icon />
                    </button>
                </form>
            @endauth

        </div>
    </nav>
</header>