<?php

namespace App\Http\Controllers;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Product;
use App\Http\Services\CartService;
class PaymentController extends Controller
{
    public function vnpay_payment(Request $request) {

        Log::Debug(1);

        Log::Debug($request);

        $totalPrice = str_replace('.', '', $request->priceEnd);
        $totalPrice = intval($totalPrice);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "ZKXUHP8C";//Mã website tại VNPAY
        $vnp_HashSecret = "0TEIR2ATODMY9KCBRJSZDXNPFBBL9JA7"; //Chuỗi bí mật

        $vnp_TxnRef = time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán hóa đơn đơn hàng.';
        $vnp_OrderType = 'Type_order';
        // $vnp_Amount = 10000 * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $totalPrice * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
        // $returnData = array('code' => '00'
        //     , 'message' => 'success'
        //     , 'data' => $vnp_Url);
        //     if (isset($_POST['redirect'])) {
        //         echo "Nút 'redirect' đã được nhấn!";
        //         header('Location: ' . $vnp_Url);
        //         die();
        //     } else {
        //         echo json_encode($returnData);
        //     }
    }

    public function vnpay_return(Request $request) {
        Log::debug('VNPAY Return Data: ', $request->all());

        $vnp_HashSecret = "0TEIR2ATODMY9KCBRJSZDXNPFBBL9JA7"; // Chuỗi bí mật
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $vnp_SecureHashType = $request->input('vnp_SecureHashType');

        // Xử lý dữ liệu trả về từ VNPAY
        $inputData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        ksort($inputData);
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            $hashdata .= urlencode($key) . "=" . urlencode($value) . "&";
        }
        $hashdata = rtrim($hashdata, "&");

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công
                Session::flash('success', 'Thanh toán thành công!');
                Session::forget('carts');
                return redirect()->route('carts.list');
                
            } else {
                // Thanh toán không thành công
                Session::flash('error', 'Thanh toán không thành công!');
                return redirect()->route('carts.list');
            }
        } else {
            // Dữ liệu bị giả mạo
            Session::flash('error', 'Dữ liệu trả về không hợp lệ!');
            return redirect()->route('carts.list');
        }
    }
}
