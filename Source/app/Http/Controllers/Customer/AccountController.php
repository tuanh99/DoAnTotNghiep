<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
    public function show()
    {
        $user = Auth::guard('user')->user();
        return view('customer.account', [
            'user' => $user,
            'title' => 'Thông Tin Tài Khoản'
        ]);
    }


public function update(Request $request, $id)
    {


        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,

            
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);


        // Update user data
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // if ($request->filled('password')) {
        //     $user->password = bcrypt($request->input('password'));
        // }
        // Save the updated user
        $user->save();
        return redirect()->route('user.account')->with('success', 'Cập nhật thông tin thành công!');
        // return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }


    public function changePasswordForm($id)
    {
        $user = User::findOrFail($id);
        $title = 'Đổi mật khẩu';
        return view('customer.change-password', compact('user', 'title'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|different:current_password',
            'new_password_confirmation' => 'required|same:new_password',
        ],
        [
            'current_password.required' => 'Mật khẩu hiện tại là bắt buộc.',
            'new_password.required' => 'Mật khẩu mới là bắt buộc.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.different' => 'Mật khẩu mới và mật khẩu hiện tại phải khác nhau.',
            'new_password_confirmation.required' => 'Xác nhận mật khẩu mới là bắt buộc.',
            'new_password_confirmation.same' => 'Mật khẩu xác nhận phải khớp với mật khẩu mới.',
        ]);

        $user = Auth::guard('user')->user();

        // Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không chính xác.');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công.');
        }
    
}
