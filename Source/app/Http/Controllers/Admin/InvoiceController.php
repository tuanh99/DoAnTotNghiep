<?php

namespace App\Http\Controllers\Admin;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function updateStatus(Request $request, $id)
{
    // Xác thực request
    $request->validate([
        'status' => 'required|in:đang chuẩn bị,đang giao hàng,đã giao thành công,đã hủy',
    ]);

    // Tìm hóa đơn theo id và cập nhật trạng thái
    $invoice = Invoice::findOrFail($id);
    $invoice->status = $request->input('status');
    $invoice->save();

    // Redirect trở lại trang khách hàng với thông báo thành công
    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
}

}
