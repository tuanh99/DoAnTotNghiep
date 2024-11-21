<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function create()
    {
        return view('customer.login');
    }

    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $user = \App\Models\User::where('email', $credentials['email'])->first();

    // Kiểm tra trạng thái tài khoản
    if ($user && $user->status == 0) {
        return back()->withErrors([
            'email' => 'Tài khoản của bạn đã bị vô hiệu hóa.',
        ]);
    }
    if (Auth::guard('user')->attempt($credentials)) {
        
            // $request->session()->regenerate(); // Regenerate session để ngăn chặn session fixation attacks
            return redirect()->route('home'); // Chuyển hướng đến route 'home' sau khi đăng nhập thành công
        
    }
    return back()->withErrors([
        'email' => 'Email hoặc Password không chính xác',
    ]);
}
    public function destroy()
    {
        Auth::guard('user')->logout(); 
        // request()->session()->invalidate(); 
        // request()->session()->regenerateToken(); 
        return redirect()->route('user.login');

    }

}