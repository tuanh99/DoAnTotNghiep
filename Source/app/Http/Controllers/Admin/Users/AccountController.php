<?php
namespace App\Http\Controllers\Admin\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AccountController extends Controller
{
    public function index(){
        $users = User::where('role',0)->get();
        return view('admin.users.list',['users' => $users , 'title' => 'Danh sách tài khoản']);
    }
        public function deactivate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = 0; // Vô hiệu hóa tài khoản
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function activate($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->status = 1; // Kích hoạt tài khoản
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }


    
}