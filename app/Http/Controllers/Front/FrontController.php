<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\Websitemail;
use App\Models\User;
use App\Models\Admin;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Photo;
use App\Models\Faq;
use App\Models\AboutItem;
use App\Models\Service;
use App\Models\ServiceFaq;
use App\Models\Event;
use App\Models\EventFaq;
use App\Models\Project;
use App\Models\ProjectFaq;
use App\Models\Member;
use App\Models\MemberSkill;
use App\Models\MemberAward;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\ShippingMethod;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\PageHomeItem;
use App\Models\PageAboutItem;
use App\Models\PageServiceItem;
use App\Models\PageProjectItem;
use App\Models\PageEventItem;
use App\Models\PageBlogItem;
use App\Models\PageTeamItem;
use App\Models\PageGalleryItem;
use App\Models\PageFaqItem;
use App\Models\PageLoginItem;
use App\Models\PageTermsItem;
use App\Models\PagePrivacyItem;
use App\Models\PageContactItem;
use App\Models\PageShopItem;
use App\Models\PageCartItem;
use App\Models\Wishlist;
use App\Models\Subscriber;
use App\Models\CustomPage;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function home()
    {
        $sliders = Slider::orderBy('id','asc')->get();
        $testimonials = Testimonial::orderBy('id','asc')->get();
        $about_item = AboutItem::where('id',1)->first();
        $services = Service::where('show_on_home','Yes')->get();
        $events = Event::where('show_on_home','Yes')->get();
        $projects = Project::where('show_on_home','Yes')->get();
        $members = Member::where('show_on_home','Yes')->get();
        $posts = Post::orderBy('id','desc')->take(3)->get();
        $page_data = PageHomeItem::where('id',1)->first();
        return view('front.home', compact('sliders', 'testimonials', 'about_item', 'services', 'events', 'projects', 'members', 'posts', 'page_data'));
    }
    
    public function about()
    {
        $testimonials = Testimonial::orderBy('id','asc')->get();
        $about_item = AboutItem::where('id',1)->first();
        $services = Service::where('show_on_home','Yes')->get();
        $page_data = PageAboutItem::where('id',1)->first();
        return view('front.about', compact('testimonials', 'about_item', 'services', 'page_data'));
    }

    public function login()
    {
        if(Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        $page_data = PageLoginItem::where('id',1)->first();
        return view('front.login', compact('page_data'));
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if email and password are correct
        $user = User::where('email',$request->email)->where('email_verified_at','!=',null)->first();
        if(!$user) {
            return redirect()->route('login')->with('error','The information you entered is incorrect! Please try again!');
        }

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if(Auth::guard('web')->attempt($data)) {
            return redirect()->route('dashboard')->with('success','You are logged in successfully!');
        } else {
            return redirect()->route('login')->with('error','The information you entered is incorrect! Please try again!');
        }
    }

    public function register()
    {
        if(Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        $page_data = PageLoginItem::where('id',1)->first();
        return view('front.register', compact('page_data'));
    }

    public function register_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $token = hash('sha256',time());
        $user->remember_token = $token;
        $user->save();

        $verification_link = url('register_verify/'.$token.'/'.$request->email);
        $subject = "Registration Verification";
        $message = "To complete registration, please click on the link below:<br>";
        $message .= "<a href='".$verification_link."'>".$verification_link."</a>";

        \Mail::to($request->email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success','Your registration is completed. Please check your email for verification. If you do not find the email in your inbox, please check your spam folder.');
    }

    public function register_verify($token,$email)
    {
        $user = User::where('remember_token',$token)->where('email',$email)->first();
        if(!$user) {
            return redirect()->route('login');
        }
        $user->email_verified_at = now();
        $user->remember_token = '';
        $user->save();

        return redirect()->route('login')->with('success', 'Your email is verified. You can login now.');
    }

    public function forget_password()
    {
        if(Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        $page_data = PageLoginItem::where('id',1)->first();
        return view('front.forget-password', compact('page_data'));
    }

    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user) {
            return redirect()->back()->with('error','Email is not found');
        }

        $token = hash('sha256',time());
        $user->remember_token = $token;
        $user->update();

        $reset_link = url('reset-password/'.$token.'/'.$request->email);
        $subject = "Password Reset";
        $message = "To reset password, please click on the link below:<br>";
        $message .= "<a href='".$reset_link."'>".$reset_link."</a>";

        \Mail::to($request->email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success','We have sent a password reset link to your email. Please check your email. If you do not find the email in your inbox, please check your spam folder.');
    }

    public function reset_password($token,$email)
    {
        $user = User::where('email',$email)->where('remember_token',$token)->first();
        if(!$user) {
            return redirect()->route('login')->with('error','Token or email is not correct');
        }
        $page_data = PageLoginItem::where('id',1)->first();
        return view('front.reset-password', compact('token','email','page_data'));
    }

    public function reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('email',$request->email)->where('remember_token',$request->token)->first();
        $user->password = Hash::make($request->password);
        $user->remember_token = "";
        $user->update();

        return redirect()->route('login')->with('success','Password reset is successful. You can login now.');
    }

    public function gallery()
    {
        $photos = Photo::orderBy('id','asc')->paginate(8);
        $page_data = PageGalleryItem::where('id',1)->first();
        return view('front.gallery', compact('photos', 'page_data'));
    }

    public function faq()
    {
        $faqs = Faq::orderBy('id','asc')->paginate(8);
        $page_data = PageFaqItem::where('id',1)->first();
        return view('front.faq', compact('faqs', 'page_data'));
    }

    public function services()
    {
        $services = Service::orderBy('id','asc')->paginate(6);
        $page_data = PageServiceItem::where('id',1)->first();
        return view('front.services', compact('services', 'page_data'));
    }

    public function service($slug)
    {
        $service = Service::where('slug',$slug)->first();
        if(!$service) {
            abort(404);
        }
        $all_services = Service::orderBy('title','asc')->get();
        $all_faqs = ServiceFaq::where('service_id',$service->id)->orderBy('id','asc')->get();
        $page_data = PageServiceItem::where('id',1)->first();
        return view('front.service', compact('service', 'all_services', 'all_faqs', 'page_data'));
    }

    public function service_contact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $subject = "New Service Contact Message";
        $message = "<b>Service Title:</b><br>".$request->service_title."<br><br>";
        $message .= "<b>Name:</b><br>".$request->name."<br><br>";
        $message .= "<b>Email:</b><br>".$request->email."<br><br>";
        $message .= "<b>Message:</b><br>".$request->message."<br><br>";

        $admin_data = Admin::where('id',1)->first();
        $admin_email = $admin_data->email;

        \Mail::to($admin_email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success','Your message is sent successfully. We will contact you soon.')->with('lead_conversion', 'service_enquiry');
    }

    public function events()
    {
        $events = Event::orderBy('id','asc')->paginate(6);
        $page_data = PageEventItem::where('id',1)->first();
        return view('front.events', compact('events', 'page_data'));
    }

    public function event($slug)
    {
        $event = Event::where('slug',$slug)->first();
        if(!$event) {
            abort(404);
        }
        $all_faqs = EventFaq::where('event_id',$event->id)->orderBy('id','asc')->get();
        $page_data = PageEventItem::where('id',1)->first();
        return view('front.event', compact('event', 'all_faqs', 'page_data'));
    }

    public function projects()
    {
        $projects = Project::orderBy('id','asc')->paginate(3);
        $page_data = PageProjectItem::where('id',1)->first();
        return view('front.projects', compact('projects', 'page_data'));
    }

    public function project($slug)
    {
        $project = Project::where('slug',$slug)->first();
        if(!$project) {
            abort(404);
        }
        $all_faqs = ProjectFaq::where('project_id',$project->id)->orderBy('id','asc')->get();
        $page_data = PageProjectItem::where('id',1)->first();
        return view('front.project', compact('project', 'all_faqs', 'page_data'));
    }

    public function members()
    {
        $members = Member::orderBy('id','asc')->paginate(12);
        $page_data = PageTeamItem::where('id',1)->first();
        return view('front.members', compact('members', 'page_data'));
    }

    public function member($slug)
    {
        $member = Member::where('slug',$slug)->first();
        if(!$member) {
            abort(404);
        }
        $all_skills = MemberSkill::where('member_id',$member->id)->orderBy('id','asc')->get();
        $all_awards = MemberAward::where('member_id',$member->id)->orderBy('id','asc')->get();
        $page_data = PageTeamItem::where('id',1)->first();
        return view('front.member', compact('member', 'all_skills', 'all_awards', 'page_data'));
    }

    public function blog()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(6);
        $page_data = PageBlogItem::where('id',1)->first();
        return view('front.blog', compact('posts', 'page_data'));
    }

    public function post($slug)
    {
        $post = Post::where('slug',$slug)->first();
        if(!$post) {
            abort(404);
        }
        $recent_posts = Post::orderBy('id', 'desc')->take(3)->get();
        $post_categopries = PostCategory::withCount('posts')->orderBy('name', 'asc')->get();
        $total_approved_comments = Comment::where('post_id', $post->id)->where('status', 'Approved')->count();
        $comments = Comment::where('post_id', $post->id)->where('status', 'Approved')->orderBy('id', 'desc')->get();
        $page_data = PageBlogItem::where('id',1)->first();
        return view('front.post', compact('post', 'recent_posts', 'post_categopries', 'total_approved_comments', 'comments', 'page_data'));
    }

    public function category($slug)
    {
        $category = PostCategory::where('slug', $slug)->first();
        if(!$category) {
            abort(404);
        }
        $posts = Post::where('post_category_id', $category->id)->orderBy('id', 'desc')->paginate(6);
        return view('front.category', compact('category', 'posts'));
    }

    public function archive($month)
    {
        $posts = Post::whereMonth('created_at', date('m', strtotime($month)))->whereYear('created_at', date('Y', strtotime($month)))->orderBy('id', 'desc')->paginate(6);
        return view('front.archive', compact('month', 'posts'));
    }

    public function tag($tag)
    {
        $posts = Post::where('tags', 'LIKE', '%'.$tag.'%')->orderBy('id', 'desc')->paginate(6);
        return view('front.tag', compact('tag', 'posts'));
    }

    public function search(Request $request)
    {
        $search_text = $request->search_text;
        $posts = Post::where('title', 'LIKE', '%' . $search_text . '%')
                        ->orWhere('description', 'LIKE', '%' . $search_text . '%')
                        ->orderBy('id','desc')
                        ->paginate(6);
        return view('front.search', compact('posts', 'search_text'));
    }

    public function comment_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ]);

        $obj = new Comment();
        $obj->post_id = $request->post_id;
        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->comment = $request->comment;
        $obj->status = 'Pending';
        $obj->save();

        // Send email to admin as notification
        $admin_data = Admin::where('id',1)->first();
        $admin_email = $admin_data->email;

        $post_title = Post::where('id', $request->post_id)->first()->title;

        $subject = "New Comment Submitted";
        $message = "<b>Post Title:</b><br>".$post_title."<br><br>";
        $message .= "<b>Name:</b><br>".$request->name."<br><br>";
        $message .= "<b>Email:</b><br>".$request->email."<br><br>";
        $message .= "<b>Comment:</b><br>".nl2br($request->comment)."<br><br>";

        \Mail::to($admin_email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success', 'Comment submitted successfully and is pending for the admin approval.');
    }

    public function reply_store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'reply' => 'required',
        ]);

        $obj = new Reply();
        $obj->post_id = $request->post_id;
        $obj->comment_id = $request->comment_id;
        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->reply = $request->reply;
        $obj->reply_by = 'User';
        $obj->status = 'Pending';
        $obj->save();

        // Send email to admin as notification
        $admin_data = Admin::where('id',1)->first();
        $admin_email = $admin_data->email;

        $post_title = Post::where('id', $request->post_id)->first()->title;

        $subject = "New Reply Submitted";
        $message = "<b>Post Title:</b><br>".$post_title."<br><br>";
        $message .= "<b>Name:</b><br>".$request->name."<br><br>";
        $message .= "<b>Email:</b><br>".$request->email."<br><br>";
        $message .= "<b>Reply:</b><br>".nl2br($request->reply)."<br><br>";

        \Mail::to($admin_email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success', 'Reply submitted successfully and is pending for the admin approval.');
    }

    public function shop(Request $request)
    {
        //dd(session()->get('cart'));
        $products = Product::orderBy('id','asc');
        if($request->has('search')) {
            $products->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $products = $products->paginate(6);

        $page_data = PageShopItem::where('id',1)->first();
        return view('front.shop', compact('products', 'page_data'));
    }

    public function product($slug)
    {
        $product = Product::where('slug',$slug)->first();
        if(!$product) {
            abort(404);
        }

        $page_data = PageShopItem::where('id',1)->first();
        return view('front.product', compact('product', 'page_data'));
    }

    public function submit_review(Request $request)
    {
        //dd($request->all());
        $check = OrderDetail::where('user_id', $request->user_id)->where('product_id', $request->product_id)->count();
        if($check == 0) {
            return redirect()->back()->with('error', 'You cannot submit review for this product without purchasing it!');
        }

        $check2 = Review::where('user_id', $request->user_id)->where('product_id', $request->product_id)->count();
        if($check2 > 0) {
            return redirect()->back()->with('error', 'You have already submitted review for this product!');
        }

        $review = new Review();
        $review->user_id = $request->user_id;
        $review->product_id = $request->product_id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->back()->with('success', 'Your review is submitted successfully!');

    }

    public function cart()
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to add product to cart!');
        }

        // If there is no data into cart, it will take you to shop page
        if(!session()->has('cart') || count(session()->get('cart')) == 0) {
            return redirect()->route('shop')->with('error','Your cart is empty! Please add some products to cart.');
        }

        $shipping_methods = ShippingMethod::orderBy('id','asc')->get();

        // When there is no data into shipping_method session, then the fist item will be saved into the session as default shipping method
        if(!session()->has('shipping_method')) {
            if($shipping_methods->count() > 0) {
                $default_shipping_method = $shipping_methods->first();
                session()->put('shipping_method', [
                    'id' => $default_shipping_method->id,
                    'name' => $default_shipping_method->name,
                    'cost' => $default_shipping_method->cost,
                ]);
            }
        }

        $cart = session()->get('cart', []);
        $page_data = PageCartItem::where('id',1)->first();
        return view('front.cart', compact('cart', 'shipping_methods', 'page_data'));
    }

    public function add_to_cart(Request $request)
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to add product to cart!');
        }

        // Add product to cart, means into session
        $cart = session()->get('cart', []);

        $product_id = $request->product_id;
        $quantity = $request->quantity;

        $product_data = Product::where('id', $product_id)->first();
        $current_stock = $product_data->stock;

        // Check if product already exists in cart
        if(isset($cart[$product_id])) {
            
            // Check if updated quantity is greater than stock
            $requested_quantity = $quantity;
            $current_quantity = $cart[$product_id]['quantity'];
            $final_quantity = $current_quantity+$requested_quantity;

            if($final_quantity > $current_stock) {
                return redirect()->back()->with('error', 'Only '.$current_stock.' items are available in stock.');
            }

            $cart[$product_id]['quantity'] += $quantity;

        } else {
            $product = Product::find($product_id);
            if(!$product) {
                return redirect()->route('shop')->with('error', 'Product not found.');
            }

            if($quantity > $current_stock) {
                return redirect()->back()->with('error', 'Only '.$current_stock.' items are available in stock.');
            }

            $cart[$product_id] = [
                'product_id' => $product_id,
                'name' => $product->name,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update_cart(Request $request)
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to update cart!');
        }

        $cart = session()->get('cart', []);
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        // Check if this product is into the stock
        $product_data = Product::where('id', $product_id)->first();
        if($product_data->stock < $quantity) {
            return redirect()->back()->with('error', 'Only '.$product_data->stock.' items are available in stock.');
        }

        if(isset($cart[$product_id])) {
            if($quantity > 0) {
                $cart[$product_id]['quantity'] = $quantity;
            } else {
                unset($cart[$product_id]);
            }
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Product not found in cart.');
        }
    }

    public function remove_from_cart($product_id)
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to remove product from cart!');
        }

        $cart = session()->get('cart', []);
        if(isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed from cart successfully.');
        } else {
            return redirect()->back()->with('error', 'Product not found in cart.');
        }
    }

    public function apply_coupon(Request $request)
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to apply coupon!');
        }

        $request->validate([
            'code' => 'required',
        ]);

        $code = $request->code;
        $coupon_data = Coupon::where('code', $code)->first();
        if(!$coupon_data) {
            return redirect()->back()->with('error', 'Invalid coupon code.');
        }

        if($coupon_data->status != 'Active') {
            return redirect()->back()->with('error', 'This coupon is not active.');
        }

        if($coupon_data->start_date > date('Y-m-d')) {
            return redirect()->back()->with('error', 'This coupon is not valid yet.');
        }

        if($coupon_data->expire_date < date('Y-m-d')) {
            return redirect()->back()->with('error', 'This coupon has expired.');
        }

        $already_used = Order::where('coupon_code',$code)->count();
        if($already_used == $coupon_data->usage_limit) {
            return redirect()->back()->with('error', 'This coupon usage limit is over.');
        }

        session()->put('coupon', [
            'id' => $coupon_data->id,
            'code' => $coupon_data->code,
            'percentage' => $coupon_data->percentage,
        ]);

        return redirect()->back()->with('success', 'Coupon applied successfully.');
    }

    public function remove_coupon()
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to remove coupon!');
        }

        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed successfully.');
    }

    public function update_shipping(Request $request)
    {
        $method = ShippingMethod::findOrFail($request->shipping_id);

        session()->put('shipping_method', [
            'id'   => $method->id,
            'name' => $method->name,
            'cost' => $method->cost,
        ]);

        return redirect()->back()->with('success', 'Shipping updated!');
    }

    public function checkout()
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to checkout!');
        }

        // If cart is empty, then redirect to shop page
        if(!session()->has('cart') || count(session()->get('cart')) == 0) {
            return redirect()->route('shop')->with('error','Your cart is empty! Please add some products to cart.');
        }

        $cart = session()->get('cart', []);
        
        $page_data = PageCartItem::where('id',1)->first();
        return view('front.checkout', compact('cart', 'page_data'));
    }

    public function payment(Request $request)
    {
        //dd($request->all());

        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to make payment!');
        }

        // If the user checked on agree
        if(!$request->has('terms')) {
            return redirect()->back()->with('error','You need to agree with the terms of use to make payment!');
        }

        $payment_method = $request->payment_method;
        $final_amount = $request->final_amount;

        if($payment_method == 'PayPal') 
        {
            // PayPal Code Starts Here
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal_success'),
                    "cancel_url" => route('paypal_cancel')
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $final_amount
                        ]
                    ]
                ]
            ]);
            //dd($response);
            if(isset($response['id']) && $response['id'] != null) {
                foreach($response['links'] as $link) {
                    if($link['rel'] == 'approve') {
                        session()->put('billing_name', $request->name);
                        session()->put('billing_email', $request->email);
                        session()->put('billing_phone', $request->phone);
                        session()->put('billing_address', $request->address);
                        session()->put('billing_country', $request->country);
                        session()->put('billing_state', $request->state);
                        session()->put('billing_city', $request->city);
                        session()->put('billing_zip', $request->zip);
                        session()->put('billing_note', $request->note);
                        return redirect()->away($link['href']);
                    }
                }
            } else {
                return redirect()->route('paypal_cancel');
            }
            // PayPal Code End Here
        }
        else
        {
            // Stripe Code Starts Here
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Physical Products',
                            ],
                            'unit_amount' => $request->final_amount*100,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe_success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe_cancel'),
            ]);
            //dd($response);
            if(isset($response->id) && $response->id != ''){
                session()->put('billing_name', $request->name);
                session()->put('billing_email', $request->email);
                session()->put('billing_phone', $request->phone);
                session()->put('billing_address', $request->address);
                session()->put('billing_country', $request->country);
                session()->put('billing_state', $request->state);
                session()->put('billing_city', $request->city);
                session()->put('billing_zip', $request->zip);
                session()->put('billing_note', $request->note);
                return redirect($response->url);
            } else {
                return redirect()->route('stripe_cancel');
            }
            // Stripe Code Ends Here
        }
    }

    public function paypal_success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        //dd($response);
        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            
            // Insert data into database
            $order_no = 'ORD-'.strtoupper(uniqid());

            $obj = new Order;
            $obj->user_id = Auth::guard('web')->user()->id;
            $obj->order_no = $order_no;
            $obj->payment_method = "PayPal";
            $obj->currency = "USD";
            $obj->final_amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $obj->coupon_code = session()->has('coupon') ? session()->get('coupon')['code'] : null;
            $obj->coupon_percentage = session()->has('coupon') ? session()->get('coupon')['percentage'] : null;
            $obj->shipping_cost = session()->has('shipping_method') ? session()->get('shipping_method')['cost'] : 0;
            $obj->billing_name = session()->get('billing_name');
            $obj->billing_email = session()->get('billing_email');
            $obj->billing_phone = session()->get('billing_phone');
            $obj->billing_address = session()->get('billing_address');
            $obj->billing_country = session()->get('billing_country');
            $obj->billing_state = session()->get('billing_state');
            $obj->billing_city = session()->get('billing_city');
            $obj->billing_zip = session()->get('billing_zip');
            $obj->billing_note = session()->get('billing_note');
            $obj->status = "Completed";
            $obj->save();

            $last_inserted_id = $obj->id;
            $cart = session()->get('cart', []);
            foreach($cart as $item) {
                $obj1 = new OrderDetail;
                $obj1->order_id = $last_inserted_id;
                $obj1->user_id = Auth::guard('web')->user()->id;
                $obj1->order_no = $order_no;
                $obj1->product_id = $item['product_id'];
                $obj1->product_price = Product::where('id', $item['product_id'])->first()->price;
                $obj1->quantity = $item['quantity'];
                $obj1->save();
            }

            session()->forget('cart');
            session()->forget('coupon');
            session()->forget('shipping_method');

            return redirect()->route('shop')->with('success', 'Payment is successful!');

        } else {
            return redirect()->route('paypal_cancel');
        }
    }

    public function paypal_cancel()
    {
        return redirect()->route('checkout')->with('error','You have canceled the PayPal payment process.');
    }

    public function stripe_success(Request $request)
    {
        if(isset($request->session_id)) {

            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);
            //dd($response);

            // Insert data into database
            $order_no = 'ORD-'.strtoupper(uniqid());

            $obj = new Order;
            $obj->user_id = Auth::guard('web')->user()->id;
            $obj->order_no = $order_no;
            $obj->payment_method = "Stripe";
            $obj->currency = "USD";
            $obj->final_amount = $response->amount_total/100;
            $obj->coupon_code = session()->has('coupon') ? session()->get('coupon')['code'] : null;
            $obj->coupon_percentage = session()->has('coupon') ? session()->get('coupon')['percentage'] : null;
            $obj->shipping_cost = session()->has('shipping_method') ? session()->get('shipping_method')['cost'] : 0;
            $obj->billing_name = session()->get('billing_name');
            $obj->billing_email = session()->get('billing_email');
            $obj->billing_phone = session()->get('billing_phone');
            $obj->billing_address = session()->get('billing_address');
            $obj->billing_country = session()->get('billing_country');
            $obj->billing_state = session()->get('billing_state');
            $obj->billing_city = session()->get('billing_city');
            $obj->billing_zip = session()->get('billing_zip');
            $obj->billing_note = session()->get('billing_note');
            $obj->status = "Completed";
            $obj->save();

            $last_inserted_id = $obj->id;
            $cart = session()->get('cart', []);
            foreach($cart as $item) {
                $obj1 = new OrderDetail;
                $obj1->order_id = $last_inserted_id;
                $obj1->user_id = Auth::guard('web')->user()->id;
                $obj1->order_no = $order_no;
                $obj1->product_id = $item['product_id'];
                $obj1->product_price = Product::where('id', $item['product_id'])->first()->price;
                $obj1->quantity = $item['quantity'];
                $obj1->save();
            }

            session()->forget('cart');
            session()->forget('coupon');
            session()->forget('shipping_method');

            return redirect()->route('shop')->with('success', 'Payment is successful!');

        } else {
            return redirect()->route('stripe_cancel');
        }
    }

    public function stripe_cancel()
    {
        return redirect()->route('checkout')->with('error','You have canceled the Stripe payment process.');
    }

    public function terms()
    {
        $page_data = PageTermsItem::where('id',1)->first();
        return view('front.terms', compact('page_data'));
    }
    public function privacy()
    {
        $page_data = PagePrivacyItem::where('id',1)->first();
        return view('front.privacy', compact('page_data'));
    }
    public function contact()
    {
        $page_data = PageContactItem::where('id',1)->first();
        return view('front.contact', compact('page_data'));
    }

    public function contact_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $subject = "New Contact Message";
        $message = "<b>Name:</b><br>".$request->name."<br><br>";
        $message .= "<b>Email:</b><br>".$request->email."<br><br>";
        $message .= "<b>Message:</b><br>".$request->message."<br><br>";

        $admin_data = Admin::where('id',1)->first();
        $admin_email = $admin_data->email;

        \Mail::to($admin_email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success','Your message is sent successfully. We will contact you soon.')->with('lead_conversion', 'contact_form');
    }

    public function add_to_wishlist(Request $request)
    {
        if(!Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error','You need to login first to add product to wishlist!');
        }

        // Check if this product is already added to wishlist by this user
        $check = Wishlist::where('user_id', Auth::guard('web')->user()->id)->where('product_id', $request->product_id)->count();
        if($check > 0) {
            return redirect()->back()->with('error', 'You have already added this product to wishlist!');
        }

        $product_id = $request->product_id;
        $user_id = Auth::guard('web')->user()->id;

        $wishlist = new Wishlist;
        $wishlist->user_id = $user_id;
        $wishlist->product_id = $product_id;
        $wishlist->save();

        return redirect()->back()->with('success', 'Product added to wishlist successfully.');
    }

    public function subscriber_send_email(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:subscribers,email'
        ]);

        if(!$validator->passes()) {
            return response()->json(['code'=>0,'error_message'=>$validator->errors()->toArray()]);
        } else {

            $token = hash('sha256', time());

            $obj = new Subscriber();
            $obj->email = $request->email;
            $obj->token = $token;
            $obj->status = 0;
            $obj->save();

            $verification_link = url('subscriber/verify/'.$request->email.'/'.$token);

            // Send email
            $subject = 'Subscriber Verification';
            $message = 'Please click on the link below to confirm subscription:<br>';
            $message .= '<a href="'.$verification_link.'">';
            $message .= $verification_link;
            $message .= '</a>';

            \Mail::to($request->email)->send(new Websitemail($subject,$message));

            return response()->json(['code'=>1,'success_message'=>'Please check your email to confirm subscription']);
        }
    }

    public function subscriber_verify($email,$token)
    {
        $subscriber_data = Subscriber::where('email',$email)->where('token',$token)->first();

        if($subscriber_data) {

            $subscriber_data->token = '';
            $subscriber_data->status = 1;
            $subscriber_data->update();

            return redirect()->route('home')->with('success', __('Your subscription is verified successfully!'));

        } else {
            return redirect()->route('home');
        }
    }

    public function custom_page($slug)
    {
        $page = CustomPage::where('slug', $slug)->first();
        if(!$page) {
            abort(404);
        }
        return view('front.custom-page', compact('page'));
    }

}
