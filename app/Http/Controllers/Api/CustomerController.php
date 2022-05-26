<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;
use App\Http\Controllers\Api\ApiBaseController as ApiBaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use PDO;

class CustomerController extends ApiBaseController
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index(){
        $Customers = Customer::all();
        return $this->sendResponse($Customers->toArray(), 'Thành công');
    }

    public function store(Request $request)
    {
        $Input = $request->all();

        $Messages = [
            'phone.requied' => 'Số điện thoại này đã có người sử dụng',
            'phone.numeric' => 'Số điện thoại không đúng định dạng',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.unique' => 'Số điện thoại này đã có người sử dụng',
            'phone.digits_between' => 'Số điện thoại phải nằm trong khoảng 9 - 12 ký tự',
            'fullname.required' => 'Bạn chưa nhập tên khách hàng',
            'fullname.max' => 'Họ tên không được quá 255 ký tự',
            'address.max' => 'Địa chỉ không được quá 500 ký tự',
            'address.required' => 'Bạn chưa nhập địa chỉ',
        ];
        $Validator = Validator::make($Input, [
            'fullname' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|numeric|unique:customers,phone|digits_between:9,12',
            // 'email' => 'required|string|email|unique:customers,email'
        ], $Messages);

        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }
        $Customer = new Customer();
        $Customer->fullname = $request->input('fullname');
        $Customer->address = $request->input('address');
        $Customer->phone = $request->input('phone');
        $Customer->user_id = (Auth::check() && Auth::user() && Auth::user()['user_id'])? Auth::user()['user_id']: null;
        $Customer->save();
        return $this->sendResponse($Customer->toArray(), 'Tạo thành công.');
    }
    public function show($id)
    {
        $Customer = Customer::find($id);


        if (is_null($Customer)) {
            return $this->sendError('Không tìm thấy người dùng này');
        }


        return $this->sendResponse($Customer->toArray(), 'Lấy dữ liệu thành công.');
    }

    public function update(Request $request, $id)
    {
        $Customer = Customer::find($id);
        if (is_null($Customer)) {
            return $this->sendError('Người dùng này không tồn tại.');
        }
        // $Customer_id = function(){
        //     if(!is_null($Customer){

        //     }
        // };
        $Input = $request->all();
        $Messages = [
            'phone.requied' => 'Số điện thoại này đã có người sử dụng',
            'phone.numeric' => 'Số điện thoại không đúng định dạng',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.unique' => 'Só điện thoại đã có người sử dụng',
            'phone.digits_between' => 'Số điện thoại phải nằm trong khoảng 9 - 12 ký tự',
            'fullname.required' => 'Bạn chưa nhập tên khách hàng',
            'fullname.max' => 'Họ tên không được quá 255 ký tự',
            'address.max' => 'Địa chỉ không được quá 500 ký tự',
            'address.required' => 'Bạn chưa nhập địa chỉ',
        ];
        $Validator = Validator::make($Input, [
            'fullname' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|numeric|unique:customers,phone' . (!is_null($Customer) ? ','.$Customer['customer_id'] : '').',customer_id|digits_between:9,12',
            // 'email' => 'required|string|email|unique:customers,email'
        ], $Messages);

        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }



        $Customer->fullname = $Input['fullname'];
        $Customer->phone = $Input['phone'];
        $Customer->address = $Input['address'];
        $Customer->save();


        return $this->sendResponse($Customer->toArray(), 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $Customer = Customer::find($id);


        if (is_null($Customer)) {
            return $this->sendError('Không tìm thấy khách hàng này.');
        }


        $Customer->delete();


        return $this->sendResponse($id, 'Xoá thành công');
    }

}
