<nav id="main-nav" class="navbar navbar-expand-lg navbar-dark {{ request()->is('/') ? 'home-navigation' : 'main-navigation' }} py-3">
    <div class="container">
        
        @if(request()->is('/'))
        <a class="navbar-brand" href="{{ route('home') }}">
            <img class="logo-default" src="{{ asset('uploads/'.$global_setting->logo_2) }}" alt="{{ $global_setting->site_name }}">
            <img class="logo-sticky" src="{{ asset('uploads/'.$global_setting->logo_1) }}" alt="{{ $global_setting->site_name }}">
        </a>
        @else
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('uploads/'.$global_setting->logo_1) }}" alt="{{ $global_setting->site_name }}"></a>
        @endif

        <button class="navbar-toggler  border-0 shadow-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#drawer-navigation">
                <i class="fa-solid fa-bars toggler-icon-style"></i>
        </button>

        <div class="collapse navbar-collapse gap-3" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">
                
                @php
                $menu_items = App\Models\Menu::where('id',1)->first();
                @endphp

                @if($menu_items->menu_home_status == 'Show')
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">{{ $menu_items->menu_home_name }}</a></li>
                @endif

                @if($menu_items->menu_about_status == 'Show')
                <li class="nav-item"><a class="nav-link  {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ $menu_items->menu_about_name }}</a></li>
                @endif

                @if($menu_items->menu_service_status == 'Show')
                <li class="nav-item"><a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ route('services') }}">{{ $menu_items->menu_service_name }}</a></li>
                @endif

                @if($menu_items->menu_event_status == 'Show' || 
                $menu_items->menu_team_member_status == 'Show' || 
                $menu_items->menu_project_status == 'Show' || 
                (config('app.shop_enabled') && $menu_items->menu_shop_status == 'Show') ||
                $menu_items->menu_gallery_status == 'Show' || 
                $menu_items->menu_faq_status == 'Show')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown">Pages</a>
                    <ul class="dropdown-menu border-0">
                        @if($menu_items->menu_event_status == 'Show')
                        <li><a class="dropdown-item" href="{{ route('events') }}">{{ $menu_items->menu_event_name }}</a></li>
                        @endif
                        @if($menu_items->menu_team_member_status == 'Show')
                        <li><a class="dropdown-item" href="{{ route('members') }}">{{ $menu_items->menu_team_member_name }}</a></li>
                        @endif
                        @if($menu_items->menu_project_status == 'Show')
                        <li><a class="dropdown-item" href="{{ route('projects') }}">{{ $menu_items->menu_project_name }}</a></li>
                        @endif
                        @if(config('app.shop_enabled') && $menu_items->menu_shop_status == 'Show')
                        <li><a class="dropdown-item" href="{{ route('shop') }}">{{ $menu_items->menu_shop_name }}</a></li>
                        @endif
                        @if($menu_items->menu_gallery_status == 'Show')
                        <li><a class="dropdown-item" href="{{ route('gallery') }}">{{ $menu_items->menu_gallery_name }}</a></li>
                        @endif
                        @if($menu_items->menu_faq_status == 'Show')
                        <li><a class="dropdown-item" href="{{ route('faq') }}">{{ $menu_items->menu_faq_name }}</a></li>
                        @endif
                        @php
                            $custom_pages = App\Models\CustomPage::get();
                        @endphp
                        @foreach($custom_pages as $custom_page)
                            <li><a class="dropdown-item" href="{{ route('custom_page', $custom_page->slug) }}">{{ $custom_page->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @endif

                @if($menu_items->menu_blog_status == 'Show')
                <li class="nav-item"><a class="nav-link {{ request()->is('blog') ? 'active' : '' }}" href="{{ route('blog') }}">{{ $menu_items->menu_blog_name }}</a></li>
                @endif
                
                @if($menu_items->menu_contact_status == 'Show')
                <li class="nav-item me-3"><a class="nav-link" href="{{ route('contact') }}">{{ $menu_items->menu_contact_name }}</a></li>
                @endif

                @if(config('app.shop_enabled') && $menu_items->menu_cart_status == 'Show')
                <li class="nav-item me-4">
                    <div class="text-white cursor-pointer position-relative">
                        <a href="{{ route('cart') }}">
                            <i class="fa-solid fa-cart-plus" id="drawer-cart-icon"></i>
                            @if(session()->has('cart'))
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-10">
                                {{ count(session()->get('cart')) }}
                            </span>
                            @endif
                        </a>
                    </div>
                </li>
                @endif
            </ul>


            @if($menu_items->menu_login_status == 'Show')
            @if(Auth::guard('web')->check())
            <a href="{{ route('dashboard') }}" class="primary-btns hover-icon-reverse d-md-none d-lg-none d-xl-block">
                <span class="btn-text-content">
                    <span class="btn-icon-wrapper">
                        <span class="btn-text">Dashboard</span>
                    </span>
                </span>
            </a>
            @else
            <a href="{{ route('login') }}" class="primary-btns hover-icon-reverse d-md-none d-lg-none d-xl-block">
                <span class="btn-text-content">
                    <span class="btn-icon-wrapper">
                        <span class="btn-text">{{ $menu_items->menu_login_name }}</span>
                    </span>
                </span>
            </a>
            @endif
            @endif

        </div>
    </div>
</nav>