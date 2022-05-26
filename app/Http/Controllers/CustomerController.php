<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // Kiểm tra thông tin khách hàng cho trang tạo khảo sát
    public function customerCheck(Request $request){
        $Input = $request->all();
        $Message = [
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.numeric' => 'Số điện thoại không đúng định dạng',
            'phone.digits_between' => 'Số điện thoại phải nằm trong khoảng 9 - 12 ký tự',
        ];
        $Validator = Validator::make($Input, [
            'phone' =>'required|numeric|digits_between:9,12',
        ], $Message);
        if($Validator->fails()){
            return $this->sendError('Lỗi', $Validator->errors());
        }
        // Kiểm tra xem đã có khách hàng sử dụng số điện thoại này chưa
        $Customer = Customer::where('phone', $request->input('phone'))->first();
        return $this->sendResponse($Customer, 'Lấy dữ liệu thành công');
    }
}
