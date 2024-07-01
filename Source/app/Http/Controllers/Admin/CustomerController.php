<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CustomerController extends Controller
{
    public function updateStatus(Request $request, $customer)
{
    try {
        $validatedData = $request->validate([
            'status' => ['required', 'string', 'in:Đang chuẩn bị,Đang giao hàng,Đã giao thành công,Đã hủy'],
        ]);

        $customer = Customer::findOrFail($customer);
        $customer->status = $validatedData['status'];
        $customer->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công');
    } catch (\Exception $e) {
        Log::error('Error updating customer status: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
    }
}



}