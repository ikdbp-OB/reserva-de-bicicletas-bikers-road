<header class="header__layout">
    <div class="logo__container">
        <a class="logo__link nav__links" alt="" href="{{ route('home') }}">
            <x-icons.application-logo />
            <h1>Biker's road</h1>
        </a>
        
    </div>
    <nav class="header__nav">

        <div class="mobile__nav" id="mobile__nav">
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
            <div id="theme-toggle">
                <x-icons.moon-icon />
                <x-icons.sun-icon />
            </div>
            
            <a href="{{ route('profile.edit') }}" class="icon__link" title="{{ __('tid_profile') }}">
                <x-icons.user-icon />
            </a>
                
            <div id="header__menu">
                <x-icons.menu-icon />
                <x-icons.close-menu-icon />
            </div>
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