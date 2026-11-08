@php
$menu_items = App\Models\Menu::where('id',1)->first();
$custom_pages = App\Models\CustomPage::get();
@endphp
<div class="offcanvas offcanvas-end  text-white drawer-nav-style" tabindex="-1" id="drawer-navigation">
    <div class="offcanvas-header border-bottom border-secondary">
        <img src="{{ asset('uploads/'.$global_setting->logo_2) }}" class="h-60px" alt="{{ $global_setting->site_name }}" />
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column fw-bold text-uppercase">
            @if($menu_items->menu_home_status == 'Show')
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('home') }}">{{ $menu_items->menu_home_name }}</a></li>
            @endif

            @if($menu_items->menu_about_status == 'Show')
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('about') }}">{{ $menu_items->menu_about_name }}</a></li>
            @endif

            @if($menu_items->menu_service_status == 'Show')
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('services') }}">{{ $menu_items->menu_service_name }}</a></li>
            @endif

            @if($menu_items->menu_event_status == 'Show' ||
            $menu_items->menu_team_member_status == 'Show' ||
            $menu_items->menu_project_status == 'Show' ||
            (config('app.shop_enabled') && $menu_items->menu_shop_status == 'Show') ||
            $menu_items->menu_gallery_status == 'Show' ||
            $menu_items->menu_faq_status == 'Show' ||
            $custom_pages->count())
            <li class="mobile-nav-item nav-item">
                <a class="nav-link text-white py-3 d-flex justify-content-between align-items-center p-3 cursor-pointer"
                    data-bs-toggle="collapse" data-bs-target="#mobileCategoryWrapper" role="button"
                    aria-expanded="false">
                    Pages
                    <i class="fa-solid fa-angle-down small transition-icon"></i>
                </a>
                <div class="collapse" id="mobileCategoryWrapper">
                    <div class="accordion accordion-flush" id="categoryAccordionMobile">
                        <ul class="list-unstyled mb-0 ms-3 ps-3">
                            @if($menu_items->menu_event_status == 'Show')
                            <li><a class="text-decoration-none text-white d-block py-2 hover-pink-text small" href="{{ route('events') }}">{{ $menu_items->menu_event_name }}</a></li>
                            @endif
                            @if($menu_items->menu_team_member_status == 'Show')
                            <li><a class="text-decoration-none text-white d-block py-2 hover-pink-text small" href="{{ route('members') }}">{{ $menu_items->menu_team_member_name }}</a></li>
                            @endif
                            @if($menu_items->menu_project_status == 'Show')
                            <li><a class="text-decoration-none text-white d-block py-2 hover-pink-text small" href="{{ route('projects') }}">{{ $menu_items->menu_project_name }}</a></li>
                            @endif
                            @if(config('app.shop_enabled') && $menu_items->menu_shop_status == 'Show')
                            <li><a class="text-decoration-none text-white d-block py-2 hover-pink-text small" href="{{ route('shop') }}">{{ $menu_items->menu_shop_name }}</a></li>
                            @endif
                            @if($menu_items->menu_gallery_status == 'Show')
                            <li><a class="text-decoration-none text-white d-block py-2 hover-pink-text small" href="{{ route('gallery') }}">{{ $menu_items->menu_gallery_name }}</a></li>
                            @endif
                            @if($menu_items->menu_faq_status == 'Show')
                            <li><a class="text-decoration-none text-white d-block py-2 hover-pink-text small" href="{{ route('faq') }}">{{ $menu_items->menu_faq_name }}</a></li>
                            @endif
                            @foreach($custom_pages as $custom_page)
                            <li><a class="text-decoration-none text-white d-block py-2 hover-pink-text small" href="{{ route('custom_page', $custom_page->slug) }}">{{ $custom_page->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </li>
            @endif

            @if($menu_items->menu_blog_status == 'Show')
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('blog') }}">{{ $menu_items->menu_blog_name }}</a></li>
            @endif

            @if($menu_items->menu_contact_status == 'Show')
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('contact') }}">{{ $menu_items->menu_contact_name }}</a></li>
            @endif

            @if(config('app.shop_enabled') && $menu_items->menu_cart_status == 'Show')
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('cart') }}">
                <i class="fa-solid fa-cart-plus me-1"></i> Cart
                @if(session()->has('cart'))
                <span class="badge rounded-pill bg-danger ms-1">{{ count(session()->get('cart')) }}</span>
                @endif
            </a></li>
            @endif

            @if($menu_items->menu_login_status == 'Show')
            @if(Auth::guard('web')->check())
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('dashboard') }}">Dashboard</a></li>
            @else
            <li class="nav-item"><a class="nav-link text-white py-3" href="{{ route('login') }}">{{ $menu_items->menu_login_name }}</a></li>
            @endif
            @endif
        </ul>
    </div>
</div>
