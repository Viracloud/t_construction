<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\SeoController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminPhotoController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminAboutItemController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\AdminPostCategoryController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminShippingMethodController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPageHomeItemController;
use App\Http\Controllers\Admin\AdminPageAboutItemController;
use App\Http\Controllers\Admin\AdminPageServiceItemController;
use App\Http\Controllers\Admin\AdminPageProjectItemController;
use App\Http\Controllers\Admin\AdminPageEventItemController;
use App\Http\Controllers\Admin\AdminPageBlogItemController;
use App\Http\Controllers\Admin\AdminPageTeamItemController;
use App\Http\Controllers\Admin\AdminPageGalleryItemController;
use App\Http\Controllers\Admin\AdminPageFaqItemController;
use App\Http\Controllers\Admin\AdminPageLoginItemController;
use App\Http\Controllers\Admin\AdminPageUserItemController;
use App\Http\Controllers\Admin\AdminPageTermsItemController;
use App\Http\Controllers\Admin\AdminPagePrivacyItemController;
use App\Http\Controllers\Admin\AdminPageContactItemController;
use App\Http\Controllers\Admin\AdminPageShopItemController;
use App\Http\Controllers\Admin\AdminPageCartItemController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminCustomPageController;
use App\Http\Controllers\Admin\AdminMenuController;

Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/login', [FrontController::class, 'login'])->name('login');
Route::post('/login',[FrontController::class,'login_submit'])->name('login_submit');
Route::get('/register', [FrontController::class, 'register'])->name('register');
Route::post('/register_submit',[FrontController::class,'register_submit'])->name('register_submit');
Route::get('/register_verify/{token}/{email}',[FrontController::class,'register_verify'])->name('register_verify');
Route::get('/forget-password',[FrontController::class,'forget_password'])->name('forget_password');
Route::post('/forget-password',[FrontController::class,'forget_password_submit'])->name('forget_password_submit');
Route::get('/reset-password/{token}/{email}',[FrontController::class,'reset_password'])->name('reset_password');
Route::post('/reset-password/{token}/{email}',[FrontController::class,'reset_password_submit'])->name('reset_password_submit');
Route::get('/gallery', [FrontController::class, 'gallery'])->name('gallery');
Route::get('/faq', [FrontController::class, 'faq'])->name('faq');

Route::get('/services', [FrontController::class, 'services'])->name('services');
Route::get('/service/{slug}', [FrontController::class, 'service'])->name('service');
Route::post('/service-contact', [FrontController::class, 'service_contact'])->name('service_contact');

Route::get('/events', [FrontController::class, 'events'])->name('events');
Route::get('/event/{slug}', [FrontController::class, 'event'])->name('event');

Route::get('/projects', [FrontController::class, 'projects'])->name('projects');
Route::get('/project/{slug}', [FrontController::class, 'project'])->name('project');

Route::get('/team-members', [FrontController::class, 'members'])->name('members');
Route::get('/team-member/{slug}', [FrontController::class, 'member'])->name('member');

Route::get('/blog', [FrontController::class, 'blog'])->name('blog');
Route::get('/post/{slug}', [FrontController::class, 'post'])->name('post');
Route::get('/category/{slug}', [FrontController::class, 'category'])->name('category');
Route::get('/archive/{month}', [FrontController::class, 'archive'])->name('archive');
Route::get('/tag/{tag}', [FrontController::class, 'tag'])->name('tag');
Route::get('/search', [FrontController::class, 'search'])->name('search');

Route::post('/comment/store',[FrontController::class,'comment_store'])->name('comment_store');
Route::post('/reply/store',[FrontController::class,'reply_store'])->name('reply_store');

// Shop (disabled unless SHOP_ENABLED=true in .env)
if (config('app.shop_enabled')) {
    Route::get('/shop', [FrontController::class, 'shop'])->name('shop');
    Route::get('/product/{slug}', [FrontController::class, 'product'])->name('product');
    Route::post('/add-to-cart', [FrontController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('/cart', [FrontController::class, 'cart'])->name('cart');
    Route::post('/update-cart', [FrontController::class, 'update_cart'])->name('update_cart');
    Route::get('/remove-from-cart/{product_id}', [FrontController::class, 'remove_from_cart'])->name('remove_from_cart');
    Route::post('/apply-coupon', [FrontController::class, 'apply_coupon'])->name('apply_coupon');
    Route::get('/remove-coupon', [FrontController::class, 'remove_coupon'])->name('remove_coupon');
    Route::post('/update_shipping', [FrontController::class, 'update_shipping'])->name('update_shipping');
    Route::get('/checkout', [FrontController::class, 'checkout'])->name('checkout');
    Route::post('/payment', [FrontController::class, 'payment'])->name('payment');
    Route::get('/paypal/success', [FrontController::class, 'paypal_success'])->name('paypal_success');
    Route::get('/paypal/cancel', [FrontController::class, 'paypal_cancel'])->name('paypal_cancel');
    Route::get('/stripe/success', [FrontController::class, 'stripe_success'])->name('stripe_success');
    Route::get('/stripe/cancel', [FrontController::class, 'stripe_cancel'])->name('stripe_cancel');
    Route::post('/submit_review', [FrontController::class, 'submit_review'])->name('submit_review');
    Route::post('/add-to-wishlist', [FrontController::class, 'add_to_wishlist'])->name('add_to_wishlist');
}

Route::get('/terms-of-use', [FrontController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [FrontController::class, 'privacy'])->name('privacy');
Route::get('/contact', [FrontController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontController::class, 'contact_submit'])->name('contact_submit');

Route::post('/subscriber/send-email', [FrontController::class, 'subscriber_send_email'])->name('subscriber_send_email');
Route::get('/subscriber/verify/{email}/{token}', [FrontController::class, 'subscriber_verify'])->name('subscriber_verify');

Route::get('/page/{slug}', [FrontController::class, 'custom_page'])->name('custom_page');


Route::middleware('auth')->group(function () {    
    Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard');
    Route::get('/profile',[UserController::class,'profile'])->name('profile');
    Route::post('/profile',[UserController::class,'profile_update'])->name('profile_update');
    Route::get('/logout',[UserController::class,'logout'])->name('logout');
    if (config('app.shop_enabled')) {
        Route::get('/orders',[UserController::class,'orders'])->name('orders');
        Route::get('/invoice/{order_no}',[UserController::class,'invoice'])->name('invoice');
        Route::get('/reviews',[UserController::class,'reviews'])->name('reviews');
        Route::get('/wishlist',[UserController::class,'wishlist'])->name('wishlist');
        Route::get('/wishlist/delete/{id}',[UserController::class,'wishlist_delete'])->name('wishlist_delete');
    }
});


Route::prefix('admin')->group(function () {
    Route::get('/', function () {return redirect('/admin/login');});
    Route::get('/login',[AdminController::class,'login'])->name('admin_login');
    Route::post('/login',[AdminController::class,'login_submit'])->name('admin_login_submit');
    Route::get('/logout',[AdminController::class,'logout'])->name('admin_logout');
    Route::get('/forget-password',[AdminController::class,'forget_password'])->name('admin_forget_password');
    Route::post('/forget_password_submit',[AdminController::class,'forget_password_submit'])->name('admin_forget_password_submit');
    Route::get('/reset-password/{token}/{email}',[AdminController::class,'reset_password'])->name('admin_reset_password');
    Route::post('/reset-password/{token}/{email}',[AdminController::class,'reset_password_submit'])->name('admin_reset_password_submit');
});

Route::middleware('admin')->prefix('admin')->group(function () {    
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin_dashboard');
    Route::get('/profile',[AdminController::class,'profile'])->name('admin_profile');
    Route::post('/profile',[AdminController::class,'profile_update'])->name('admin_profile_update');
    
    Route::get('/slider/index',[AdminSliderController::class,'index'])->name('admin_slider_index');
    Route::post('/slider/store',[AdminSliderController::class,'store'])->name('admin_slider_store');
    Route::post('/slider/update/{id}',[AdminSliderController::class,'update'])->name('admin_slider_update');
    Route::post('/slider/delete/{id}',[AdminSliderController::class,'delete'])->name('admin_slider_delete');

    Route::get('/testimonial/index',[AdminTestimonialController::class,'index'])->name('admin_testimonial_index');
    Route::post('/testimonial/store',[AdminTestimonialController::class,'store'])->name('admin_testimonial_store');
    Route::post('/testimonial/update/{id}',[AdminTestimonialController::class,'update'])->name('admin_testimonial_update');
    Route::post('/testimonial/delete/{id}',[AdminTestimonialController::class,'delete'])->name('admin_testimonial_delete');

    Route::get('/photo/index',[AdminPhotoController::class,'index'])->name('admin_photo_index');
    Route::post('/photo/store',[AdminPhotoController::class,'store'])->name('admin_photo_store');
    Route::post('/photo/update/{id}',[AdminPhotoController::class,'update'])->name('admin_photo_update');
    Route::post('/photo/delete/{id}',[AdminPhotoController::class,'delete'])->name('admin_photo_delete');

    Route::get('/faq/index',[AdminFaqController::class,'index'])->name('admin_faq_index');
    Route::post('/faq/store',[AdminFaqController::class,'store'])->name('admin_faq_store');
    Route::post('/faq/update/{id}',[AdminFaqController::class,'update'])->name('admin_faq_update');
    Route::post('/faq/delete/{id}',[AdminFaqController::class,'delete'])->name('admin_faq_delete');

    Route::get('/about-item/index',[AdminAboutItemController::class,'index'])->name('admin_about_item_index');
    Route::post('/about-item/update',[AdminAboutItemController::class,'update'])->name('admin_about_item_update');

    Route::get('/service/index',[AdminServiceController::class,'index'])->name('admin_service_index');
    Route::post('/service/store',[AdminServiceController::class,'store'])->name('admin_service_store');
    Route::post('/service/update/{id}',[AdminServiceController::class,'update'])->name('admin_service_update');
    Route::post('/service/delete/{id}',[AdminServiceController::class,'delete'])->name('admin_service_delete');
    Route::get('/service/{service_id}/faqs', [AdminServiceController::class, 'faqs'])->name('admin_service_faqs');
    Route::post('/service/{service_id}/faq/store',[AdminServiceController::class,'faq_store'])->name('admin_service_faq_store');
    Route::post('/service/{faq_id}/faq/update',[AdminServiceController::class,'faq_update'])->name('admin_service_faq_update');
    Route::post('/service/{faq_id}/faq/delete',[AdminServiceController::class,'faq_delete'])->name('admin_service_faq_delete');

    Route::get('/event/index',[AdminEventController::class,'index'])->name('admin_event_index');
    Route::post('/event/store',[AdminEventController::class,'store'])->name('admin_event_store');
    Route::post('/event/update/{id}',[AdminEventController::class,'update'])->name('admin_event_update');
    Route::post('/event/delete/{id}',[AdminEventController::class,'delete'])->name('admin_event_delete');
    Route::get('/event/{event_id}/faqs', [AdminEventController::class, 'faqs'])->name('admin_event_faqs');
    Route::post('/event/{event_id}/faq/store',[AdminEventController::class,'faq_store'])->name('admin_event_faq_store');
    Route::post('/event/{faq_id}/faq/update',[AdminEventController::class,'faq_update'])->name('admin_event_faq_update');
    Route::post('/event/{faq_id}/faq/delete',[AdminEventController::class,'faq_delete'])->name('admin_event_faq_delete');

    Route::get('/project/index',[AdminProjectController::class,'index'])->name('admin_project_index');
    Route::post('/project/store',[AdminProjectController::class,'store'])->name('admin_project_store');
    Route::post('/project/update/{id}',[AdminProjectController::class,'update'])->name('admin_project_update');
    Route::post('/project/delete/{id}',[AdminProjectController::class,'delete'])->name('admin_project_delete');
    Route::get('/project/{project_id}/faqs', [AdminProjectController::class, 'faqs'])->name('admin_project_faqs');
    Route::post('/project/{project_id}/faq/store',[AdminProjectController::class,'faq_store'])->name('admin_project_faq_store');
    Route::post('/project/{faq_id}/faq/update',[AdminProjectController::class,'faq_update'])->name('admin_project_faq_update');
    Route::post('/project/{faq_id}/faq/delete',[AdminProjectController::class,'faq_delete'])->name('admin_project_faq_delete');


    Route::get('/member/index',[AdminMemberController::class,'index'])->name('admin_member_index');
    Route::post('/member/store',[AdminMemberController::class,'store'])->name('admin_member_store');
    Route::post('/member/update/{id}',[AdminMemberController::class,'update'])->name('admin_member_update');
    Route::post('/member/delete/{id}',[AdminMemberController::class,'delete'])->name('admin_member_delete');
    Route::get('/member/{member_id}/skills', [AdminMemberController::class, 'skills'])->name('admin_member_skills');
    Route::post('/member/{member_id}/skill/store',[AdminMemberController::class,'skill_store'])->name('admin_member_skill_store');
    Route::post('/member/{skill_id}/skill/update',[AdminMemberController::class,'skill_update'])->name('admin_member_skill_update');
    Route::post('/member/{skill_id}/skill/delete',[AdminMemberController::class,'skill_delete'])->name('admin_member_skill_delete');

    Route::get('/member/{member_id}/awards', [AdminMemberController::class, 'awards'])->name('admin_member_awards');
    Route::post('/member/{member_id}/award/store',[AdminMemberController::class,'award_store'])->name('admin_member_award_store');
    Route::post('/member/{award_id}/award/update',[AdminMemberController::class,'award_update'])->name('admin_member_award_update');
    Route::post('/member/{award_id}/award/delete',[AdminMemberController::class,'award_delete'])->name('admin_member_award_delete');

    Route::get('/post-category/index',[AdminPostCategoryController::class,'index'])->name('admin_post_category_index');
    Route::post('/post-category/store',[AdminPostCategoryController::class,'store'])->name('admin_post_category_store');
    Route::post('/post-category/update/{id}',[AdminPostCategoryController::class,'update'])->name('admin_post_category_update');
    Route::post('/post-category/delete/{id}',[AdminPostCategoryController::class,'delete'])->name('admin_post_category_delete');

    Route::get('/post/index',[AdminPostController::class,'index'])->name('admin_post_index');
    Route::post('/post/store',[AdminPostController::class,'store'])->name('admin_post_store');
    Route::post('/post/update/{id}',[AdminPostController::class,'update'])->name('admin_post_update');
    Route::post('/post/delete/{id}',[AdminPostController::class,'delete'])->name('admin_post_delete');
    Route::get('/post/comments',[AdminPostController::class,'comments'])->name('admin_post_comments');
    Route::post('/post/comment/change/{id}',[AdminPostController::class,'change_comment_status'])->name('admin_post_comment_change');
    Route::post('/post/comment/delete/{id}',[AdminPostController::class,'delete_comment'])->name('admin_post_comment_delete');
    Route::get('/post/replies',[AdminPostController::class,'replies'])->name('admin_post_replies');
    Route::post('/post/reply/change/{id}',[AdminPostController::class,'change_reply_status'])->name('admin_post_reply_change');
    Route::post('/post/reply/delete/{id}',[AdminPostController::class,'delete_reply'])->name('admin_post_reply_delete');
    Route::post('/post/reply/admin-reply',[AdminPostController::class,'admin_reply'])->name('admin_post_reply_admin_reply');

    // Shop admin (disabled unless SHOP_ENABLED=true)
    if (config('app.shop_enabled')) {
    Route::get('/product/index',[AdminProductController::class,'index'])->name('admin_product_index');
    Route::post('/product/store',[AdminProductController::class,'store'])->name('admin_product_store');
    Route::post('/product/update/{id}',[AdminProductController::class,'update'])->name('admin_product_update');
    Route::post('/product/delete/{id}',[AdminProductController::class,'delete'])->name('admin_product_delete');
    Route::get('/product/{product_id}/specifications', [AdminProductController::class, 'specifications'])->name('admin_product_specifications');
    Route::post('/product/{product_id}/specification/store',[AdminProductController::class,'specification_store'])->name('admin_product_specification_store');
    Route::post('/product/{specification_id}/specification/update',[AdminProductController::class,'specification_update'])->name('admin_product_specification_update');
    Route::post('/product/{specification_id}/specification/delete',[AdminProductController::class,'specification_delete'])->name('admin_product_specification_delete');

    Route::get('/product/{product_id}/photos', [AdminProductController::class, 'photos'])->name('admin_product_photos');
    Route::post('/product/{product_id}/photo/store',[AdminProductController::class,'photo_store'])->name('admin_product_photo_store');
    Route::post('/product/{photo_id}/photo/update',[AdminProductController::class,'photo_update'])->name('admin_product_photo_update');
    Route::post('/product/{photo_id}/photo/delete',[AdminProductController::class,'photo_delete'])->name('admin_product_photo_delete');

    Route::get('/reviews',[AdminProductController::class,'reviews'])->name('admin_review_index');
    Route::post('/review/delete/{id}',[AdminProductController::class,'review_delete'])->name('admin_review_delete');

    Route::get('/coupon/index',[AdminCouponController::class,'index'])->name('admin_coupon_index');
    Route::post('/coupon/store',[AdminCouponController::class,'store'])->name('admin_coupon_store');
    Route::post('/coupon/update/{id}',[AdminCouponController::class,'update'])->name('admin_coupon_update');
    Route::post('/coupon/delete/{id}',[AdminCouponController::class,'delete'])->name('admin_coupon_delete');

    Route::get('/shipping/index',[AdminShippingMethodController::class,'index'])->name('admin_shipping_index');
    Route::post('/shipping/store',[AdminShippingMethodController::class,'store'])->name('admin_shipping_store');
    Route::post('/shipping/update/{id}',[AdminShippingMethodController::class,'update'])->name('admin_shipping_update');
    Route::post('/shipping/delete/{id}',[AdminShippingMethodController::class,'delete'])->name('admin_shipping_delete');

    Route::get('/orders',[AdminOrderController::class,'orders'])->name('admin_order_orders');
    Route::post('/order/change_status/{order_id}',[AdminOrderController::class,'change_status'])->name('admin_order_change_status');
    Route::post('/order/delete/{order_id}',[AdminOrderController::class,'delete'])->name('admin_order_delete');
    Route::get('/order/invoice/{order_no}',[AdminOrderController::class,'invoice'])->name('admin_order_invoice');
    }

    Route::get('/user/index',[AdminUserController::class,'index'])->name('admin_user_index');
    Route::post('/user/store',[AdminUserController::class,'store'])->name('admin_user_store');
    Route::post('/user/update/{id}',[AdminUserController::class,'update'])->name('admin_user_update');
    Route::post('/user/delete/{id}',[AdminUserController::class,'delete'])->name('admin_user_delete');

    Route::get('/page-item/home/index',[AdminPageHomeItemController::class,'index'])->name('admin_page_home_index');
    Route::post('/page-item/home/update',[AdminPageHomeItemController::class,'update'])->name('admin_page_home_update');

    Route::get('/page-item/about/index',[AdminPageAboutItemController::class,'index'])->name('admin_page_about_index');
    Route::post('/page-item/about/update',[AdminPageAboutItemController::class,'update'])->name('admin_page_about_update');

    Route::get('/page-item/service/index',[AdminPageServiceItemController::class,'index'])->name('admin_page_service_index');
    Route::post('/page-item/service/update',[AdminPageServiceItemController::class,'update'])->name('admin_page_service_update');

    Route::get('/page-item/project/index',[AdminPageProjectItemController::class,'index'])->name('admin_page_project_index');
    Route::post('/page-item/project/update',[AdminPageProjectItemController::class,'update'])->name('admin_page_project_update');

    Route::get('/page-item/event/index',[AdminPageEventItemController::class,'index'])->name('admin_page_event_index');
    Route::post('/page-item/event/update',[AdminPageEventItemController::class,'update'])->name('admin_page_event_update');

    Route::get('/page-item/blog/index',[AdminPageBlogItemController::class,'index'])->name('admin_page_blog_index');
    Route::post('/page-item/blog/update',[AdminPageBlogItemController::class,'update'])->name('admin_page_blog_update');

    Route::get('/page-item/team/index',[AdminPageTeamItemController::class,'index'])->name('admin_page_team_index');
    Route::post('/page-item/team/update',[AdminPageTeamItemController::class,'update'])->name('admin_page_team_update');

    Route::get('/page-item/gallery/index',[AdminPageGalleryItemController::class,'index'])->name('admin_page_gallery_index');
    Route::post('/page-item/gallery/update',[AdminPageGalleryItemController::class,'update'])->name('admin_page_gallery_update');

    Route::get('/page-item/faq/index',[AdminPageFaqItemController::class,'index'])->name('admin_page_faq_index');
    Route::post('/page-item/faq/update',[AdminPageFaqItemController::class,'update'])->name('admin_page_faq_update');

    Route::get('/page-item/login/index',[AdminPageLoginItemController::class,'index'])->name('admin_page_login_index');
    Route::post('/page-item/login/update',[AdminPageLoginItemController::class,'update'])->name('admin_page_login_update');

    Route::get('/page-item/user/index',[AdminPageUserItemController::class,'index'])->name('admin_page_user_index');
    Route::post('/page-item/user/update',[AdminPageUserItemController::class,'update'])->name('admin_page_user_update');

    Route::get('/page-item/terms/index',[AdminPageTermsItemController::class,'index'])->name('admin_page_terms_index');
    Route::post('/page-item/terms/update',[AdminPageTermsItemController::class,'update'])->name('admin_page_terms_update');

    Route::get('/page-item/privacy/index',[AdminPagePrivacyItemController::class,'index'])->name('admin_page_privacy_index');
    Route::post('/page-item/privacy/update',[AdminPagePrivacyItemController::class,'update'])->name('admin_page_privacy_update');

    Route::get('/page-item/contact/index',[AdminPageContactItemController::class,'index'])->name('admin_page_contact_index');
    Route::post('/page-item/contact/update',[AdminPageContactItemController::class,'update'])->name('admin_page_contact_update');

    if (config('app.shop_enabled')) {
    Route::get('/page-item/shop/index',[AdminPageShopItemController::class,'index'])->name('admin_page_shop_index');
    Route::post('/page-item/shop/update',[AdminPageShopItemController::class,'update'])->name('admin_page_shop_update');

    Route::get('/page-item/cart/index',[AdminPageCartItemController::class,'index'])->name('admin_page_cart_index');
    Route::post('/page-item/cart/update',[AdminPageCartItemController::class,'update'])->name('admin_page_cart_update');
    }

    Route::get('/subscriber/index',[AdminSubscriberController::class,'index'])->name('admin_subscriber_index');
    Route::post('/subscriber/delete/{id}',[AdminSubscriberController::class,'delete'])->name('admin_subscriber_delete');
    Route::get('/subscriber/export',[AdminSubscriberController::class,'export'])->name('admin_subscriber_export');

    Route::get('/setting/logo',[AdminSettingController::class,'logo'])->name('admin_setting_logo');
    Route::post('/setting/logo/update',[AdminSettingController::class,'logo_update'])->name('admin_setting_logo_update');
    Route::get('/setting/favicon',[AdminSettingController::class,'favicon'])->name('admin_setting_favicon');
    Route::post('/setting/favicon/update',[AdminSettingController::class,'favicon_update'])->name('admin_setting_favicon_update');
    Route::get('/setting/banner',[AdminSettingController::class,'banner'])->name('admin_setting_banner');
    Route::post('/setting/banner/update',[AdminSettingController::class,'banner_update'])->name('admin_setting_banner_update');
    Route::get('/setting/top-bar',[AdminSettingController::class,'top_bar'])->name('admin_setting_top_bar');
    Route::post('/setting/top-bar/update',[AdminSettingController::class,'top_bar_update'])->name('admin_setting_top_bar_update');
    Route::get('/setting/footer',[AdminSettingController::class,'footer'])->name('admin_setting_footer');
    Route::post('/setting/footer/update',[AdminSettingController::class,'footer_update'])->name('admin_setting_footer_update');
    Route::get('/setting/theme-color',[AdminSettingController::class,'theme_color'])->name('admin_setting_theme_color');
    Route::post('/setting/theme-color/update',[AdminSettingController::class,'theme_color_update'])->name('admin_setting_theme_color_update');
    Route::get('/setting/layout-direction',[AdminSettingController::class,'layout_direction'])->name('admin_setting_layout_direction');
    Route::post('/setting/layout-direction/update',[AdminSettingController::class,'layout_direction_update'])->name('admin_setting_layout_direction_update');
    Route::get('/setting/seo',[AdminSettingController::class,'seo'])->name('admin_setting_seo');
    Route::post('/setting/seo/update',[AdminSettingController::class,'seo_update'])->name('admin_setting_seo_update');

    Route::get('/custom-page/index',[AdminCustomPageController::class,'index'])->name('admin_custom_page_index');
    Route::post('/custom-page/store',[AdminCustomPageController::class,'store'])->name('admin_custom_page_store');
    Route::post('/custom-page/update/{id}',[AdminCustomPageController::class,'update'])->name('admin_custom_page_update');
    Route::post('/custom-page/delete/{id}',[AdminCustomPageController::class,'delete'])->name('admin_custom_page_delete');

    Route::get('/menu/index',[AdminMenuController::class,'index'])->name('admin_menu_index');
    Route::post('/menu/update',[AdminMenuController::class,'update'])->name('admin_menu_update');
});