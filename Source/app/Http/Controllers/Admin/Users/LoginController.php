<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.users.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|email:filter',
    //         'password' => 'required'
    //     ]);

    //     if (Auth::attempt([
    //             'email' => $request->input('email'),
    //             'password' => $request->input('password')
    //         ], $request->input('remember'))) {

    //         return redirect()->route('admin');
    //     }

    //     Session::flash('error', 'Email hoặc Password không đúng');
    //     return redirect()->back();
    // }


    public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    if (Auth::guard('admin')->attempt($credentials)) {
        
            // $request->session()->regenerate(); // Regenerate session để ngăn chặn session fixation attacks
            // return redirect()->route('admin'); // Chuyển hướng đến route 'admin' sau khi đăng nhập thành công
            return redirect()->route('main');
    }
    return back()->withErrors([
        'email' => 'Email hoặc Password không chính xác',
    ]);
}
    public function destroy()
    {
        Auth::guard('admin')->logout(); 
        // request()->session()->invalidate(); 
        // request()->session()->regenerateToken(); 
        return redirect()->route('login');

    }

}
