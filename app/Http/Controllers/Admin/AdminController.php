<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Order;
use App\Models\User;
use App\Models\Subscriber;
use App\Mail\Websitemail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $total_revenue = Order::sum('final_amount');
        $total_orders = Order::count();
        $total_customers = User::count();
        $total_subscribers = Subscriber::where('status',1)->count();

        $recent_orders = Order::with('user')->orderBy('id','desc')->take(5)->get();

        // Daily sales for current month
        $current_month = now()->month;
        $current_year = now()->year;
        $days_in_month = now()->daysInMonth;

        $daily_sales = Order::whereMonth('created_at', $current_month)
            ->whereYear('created_at', $current_year)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('SUM(final_amount) as total'))
            ->groupBy('day')
            ->pluck('total','day')
            ->toArray();

        $chart_labels = range(1, $days_in_month);
        $chart_data = [];
        foreach($chart_labels as $day) {
            $chart_data[] = isset($daily_sales[$day]) ? (float)$daily_sales[$day] : 0;
        }

        return view('admin.dashboard', compact(
            'total_revenue',
            'total_orders',
            'total_customers',
            'total_subscribers',
            'recent_orders',
            'chart_labels',
            'chart_data'
        ));
    }

    public function login()
    {
        if(Auth::guard('admin')->check()) {
            return redirect()->route('admin_dashboard');
        }
        return view('admin.login');
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password']
        ];

        if(Auth::guard('admin')->attempt($data)) {
            return redirect()->route('admin_dashboard')->with('success','Login is successful!');
        } else {
            return redirect()->route('admin_login')->with('error','The information you entered is incorrect! Please try again!');
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin_login')->with('success','Logout is successful!');
    }

    public function forget_password()
    {
        return view('admin.forget-password');
    }

    public function forget_password_submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = Admin::where('email',$request->email)->first();
        if(!$admin) {
            return redirect()->back()->with('error','Email is not found');
        }

        $token = hash('sha256',time());
        $admin->token = $token;
        $admin->update();

        $reset_link = url('admin/reset-password/'.$token.'/'.$request->email);
        $subject = "Password Reset";
        $message = "To reset password, please click on the link below:<br>";
        $message .= "<a href='".$reset_link."'>".$reset_link."</a>";

        \Mail::to($request->email)->send(new Websitemail($subject,$message));

        return redirect()->back()->with('success','We have sent a password reset link to your email. Please check your email. If you do not find the email in your inbox, please check your spam folder.');
    }

    public function reset_password($token,$email)
    {
        $admin = Admin::where('email',$email)->where('token',$token)->first();
        if(!$admin) {
            return redirect()->route('admin_login')->with('error','Token or email is not correct');
        }
        return view('admin.reset-password', compact('token','email'));
    }

    public function reset_password_submit(Request $request, $token, $email)
    {
        $request->validate([
            'password' => ['required'],
            'confirm_password' => ['required','same:password'],
        ]);

        $admin = Admin::where('email',$request->email)->where('token',$request->token)->first();
        $admin->password = Hash::make($request->password);
        $admin->token = "";
        $admin->update();

        return redirect()->route('admin_login')->with('success','Password reset is successful. You can login now.');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $admin = Admin::where('id', Auth::guard('admin')->user()->id)->first();

        if($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $final_name = 'admin_'.time().'.'.$request->photo->getClientOriginalExtension();

            if($admin->photo != null && file_exists(public_path('uploads/'.$admin->photo))) {
                unlink(public_path('uploads/'.$admin->photo));
            }

            $request->photo->move(public_path('uploads'), $final_name);

            \App\Support\ImageOptimizer::optimize(public_path('uploads/'.$final_name));
            $admin->photo = $final_name;
        }

        if($request->password != null) {
            $request->validate([
                'password' => ['required'],
                'confirm_password' => ['required','same:password'],
            ]);
            $admin->password = Hash::make($request->password);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->update();

        return redirect()->back()->with('success','Profile update is successful!');
    }
}
