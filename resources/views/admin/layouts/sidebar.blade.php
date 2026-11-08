<aside id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">A</div>
        <span class="sidebar-brand sidebar-label">Admin Panel</span>
    </div>
    <nav class="sidebar-nav space-y-1">
        <a href="{{ route('admin_dashboard') }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span class="sidebar-label">Dashboard</span>
        </a>
        <div class="nav-dropdown">
            <a href="javascript:void(0)" class="nav-link nav-dropdown-toggle">
                <i class="fa-solid fa-gear"></i>
                <span class="sidebar-label">Settings</span>
                <i class="fa-solid fa-chevron-right nav-arrow sidebar-label"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin_setting_logo') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/logo*') ? 'active' : '' }}">Logo</a>
                <a href="{{ route('admin_setting_favicon') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/favicon*') ? 'active' : '' }}">Favicon</a>
                <a href="{{ route('admin_setting_banner') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/banner*') ? 'active' : '' }}">Banner</a>
                <a href="{{ route('admin_setting_top_bar') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/top-bar*') ? 'active' : '' }}">Top Bar</a>
                <a href="{{ route('admin_setting_footer') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/footer*') ? 'active' : '' }}">Footer</a>
                <a href="{{ route('admin_setting_theme_color') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/theme-color*') ? 'active' : '' }}">Theme Color</a>
                <a href="{{ route('admin_setting_layout_direction') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/layout-direction*') ? 'active' : '' }}">Layout Direction</a>
                <a href="{{ route('admin_setting_seo') }}" class="nav-link nav-sub-link {{ Request::is('admin/setting/seo*') ? 'active' : '' }}">SEO &amp; Google</a>
            </div>
        </div>
        @if(config('app.shop_enabled'))
        <div class="nav-dropdown">
            <a href="javascript:void(0)" class="nav-link nav-dropdown-toggle">
                <i class="fa-solid fa-shop"></i>
                <span class="sidebar-label">Shop</span>
                <i class="fa-solid fa-chevron-right nav-arrow sidebar-label"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin_coupon_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/coupon/*') ? 'active' : '' }}">Coupon</a>
                <a href="{{ route('admin_shipping_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/shipping/*') ? 'active' : '' }}">Shipping Method</a>
                <a href="{{ route('admin_product_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/product/*') ? 'active' : '' }}">Products</a>
                <a href="{{ route('admin_review_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/reviews') ? 'active' : '' }}">Reviews</a>
            </div>
        </div>
        @endif
        <div class="nav-dropdown">
            <a href="javascript:void(0)" class="nav-link nav-dropdown-toggle">
                <i class="fa-solid fa-table"></i>
                <span class="sidebar-label">Post</span>
                <i class="fa-solid fa-chevron-right nav-arrow sidebar-label"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin_post_category_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/post-category/*') ? 'active' : '' }}">Post Category</a>
                <a href="{{ route('admin_post_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/post/index') ? 'active' : '' }}">Post</a>
                <a href="{{ route('admin_post_comments') }}" class="nav-link nav-sub-link {{ Request::is('admin/post/comments') ? 'active' : '' }}">Comments</a>
                <a href="{{ route('admin_post_replies') }}" class="nav-link nav-sub-link {{ Request::is('admin/post/rep*') ? 'active' : '' }}">Replies</a>
            </div>
        </div>
        <div class="nav-dropdown">
            <a href="javascript:void(0)" class="nav-link nav-dropdown-toggle">
                <i class="fa-solid fa-table"></i>
                <span class="sidebar-label">Page Items</span>
                <i class="fa-solid fa-chevron-right nav-arrow sidebar-label"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="{{ route('admin_page_home_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/home/*') ? 'active' : '' }}">Home Page</a>
                <a href="{{ route('admin_page_about_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/about/*') ? 'active' : '' }}">About Page</a>
                <a href="{{ route('admin_page_service_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/service/*') ? 'active' : '' }}">Service Page</a>
                <a href="{{ route('admin_page_project_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/project/*') ? 'active' : '' }}">Project Page</a>
                <a href="{{ route('admin_page_event_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/event/*') ? 'active' : '' }}">Event Page</a>
                <a href="{{ route('admin_page_blog_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/blog/*') ? 'active' : '' }}">Blog Page</a>
                <a href="{{ route('admin_page_team_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/team/*') ? 'active' : '' }}">Team Page</a>
                <a href="{{ route('admin_page_gallery_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/gallery/*') ? 'active' : '' }}">Gallery Page</a>
                <a href="{{ route('admin_page_faq_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/faq/*') ? 'active' : '' }}">FAQ Page</a>
                <a href="{{ route('admin_page_login_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/login/*') ? 'active' : '' }}">Login Page</a>
                <a href="{{ route('admin_page_user_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/user/*') ? 'active' : '' }}">User Page</a>
                <a href="{{ route('admin_page_terms_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/terms/*') ? 'active' : '' }}">Terms Page</a>
                <a href="{{ route('admin_page_privacy_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/privacy/*') ? 'active' : '' }}">Privacy Page</a>
                <a href="{{ route('admin_page_contact_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/contact/*') ? 'active' : '' }}">Contact Page</a>
                @if(config('app.shop_enabled'))
                <a href="{{ route('admin_page_shop_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/shop/*') ? 'active' : '' }}">Shop Page</a>
                <a href="{{ route('admin_page_cart_index') }}" class="nav-link nav-sub-link {{ Request::is('admin/page-item/cart/*') ? 'active' : '' }}">Cart Page</a>
                @endif
            </div>
        </div>
        @if(config('app.shop_enabled'))
        <a href="{{ route('admin_order_orders') }}" class="nav-link {{ Request::is('admin/order*') ? 'active' : '' }}">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="sidebar-label">Orders</span>
        </a>
        @endif
        <a href="{{ route('admin_menu_index') }}" class="nav-link {{ Request::is('admin/menu*') ? 'active' : '' }}">
            <i class="fa-solid fa-bars"></i>
            <span class="sidebar-label">Menu</span>
        </a>
        <a href="{{ route('admin_custom_page_index') }}" class="nav-link {{ Request::is('admin/custom-page/*') ? 'active' : '' }}">
            <i class="fa-solid fa-file"></i>
            <span class="sidebar-label">Custom Pages</span>
        </a>
        <a href="{{ route('admin_user_index') }}" class="nav-link {{ Request::is('admin/user/*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span class="sidebar-label">Users</span>
        </a>
        <a href="{{ route('admin_slider_index') }}" class="nav-link {{ Request::is('admin/slider/*') ? 'active' : '' }}">
            <i class="fa-solid fa-images"></i>
            <span class="sidebar-label">Slider</span>
        </a>
        <a href="{{ route('admin_testimonial_index') }}" class="nav-link {{ Request::is('admin/testimonial/*') ? 'active' : '' }}">
            <i class="fa-solid fa-comment"></i>
            <span class="sidebar-label">Testimonial</span>
        </a>
        <a href="{{ route('admin_photo_index') }}" class="nav-link {{ Request::is('admin/photo/*') ? 'active' : '' }}">
            <i class="fa-solid fa-image"></i>
            <span class="sidebar-label">Photo</span>
        </a>
        <a href="{{ route('admin_faq_index') }}" class="nav-link {{ Request::is('admin/faq/*') ? 'active' : '' }}">
            <i class="fa-solid fa-question"></i>
            <span class="sidebar-label">FAQ</span>
        </a>
        <a href="{{ route('admin_about_item_index') }}" class="nav-link {{ Request::is('admin/about-item/*') ? 'active' : '' }}">
            <i class="fa-solid fa-info-circle"></i>
            <span class="sidebar-label">About Items</span>
        </a>
        <a href="{{ route('admin_service_index') }}" class="nav-link {{ Request::is('admin/service/*') ? 'active' : '' }}">
            <i class="fa-solid fa-tools"></i>
            <span class="sidebar-label">Services</span>
        </a>
        <a href="{{ route('admin_event_index') }}" class="nav-link {{ Request::is('admin/event/*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar"></i>
            <span class="sidebar-label">Events</span>
        </a>
        <a href="{{ route('admin_project_index') }}" class="nav-link {{ Request::is('admin/project/*') ? 'active' : '' }}">
            <i class="fa-solid fa-briefcase"></i>
            <span class="sidebar-label">Projects</span>
        </a>
        <a href="{{ route('admin_member_index') }}" class="nav-link {{ Request::is('admin/member/*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span class="sidebar-label">Team Members</span>
        </a>
        <a href="{{ route('admin_subscriber_index') }}" class="nav-link {{ Request::is('admin/subscriber/*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i>
            <span class="sidebar-label">Subscribers</span>
        </a>
        {{-- <div class="nav-dropdown">
            <a href="javascript:void(0)" class="nav-link nav-dropdown-toggle">
                <i class="fa-solid fa-table"></i>
                <span class="sidebar-label">Tables</span>
                <i class="fa-solid fa-chevron-right nav-arrow sidebar-label"></i>
            </a>
            <div class="nav-dropdown-menu">
                <a href="table.html" class="nav-link nav-sub-link">Table</a>
                <a href="datatable.html" class="nav-link nav-sub-link">DataTable</a>
            </div>
        </div>
        <a href="form.html" class="nav-link">
            <i class="fa-solid fa-file-pen"></i>
            <span class="sidebar-label">Form</span>
        </a>
        <a href="setting-general.html" class="nav-link">
            <i class="fa-solid fa-gear"></i>
            <span class="sidebar-label">Settings</span>
        </a> --}}
    </nav>
</aside>