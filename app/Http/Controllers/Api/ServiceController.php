<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Service;

class ServiceController extends Controller
{
    public function update(Request $request, $id){
        $Service = Service::find($id);
        if (is_null($Service)) {
            return $this->sendError('Dịch vụ này không tồn tại');
        }
        $Input = $request->all();
        $Messages = [
            'name.required' => 'Tên dịch vụ không được để trống',
            'service_id.numeric' => 'ID dịch vụ không hợp lệ',
            'service_id.required' => 'ID dịch vụ không được để trống'
        ];
        $Validator = Validator::make($Input, [
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|unique:customers,email'
        ], $Messages);
        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }
        $Service->name = $Input['name'];
        $Service->update(['updated_at' => microtime(true)]);
        $Service->save();


        return $this->sendResponse($Service->toArray(), 'Cập nhật thành công');
    }

    public function store(Request $request){
        $Input = $request->all();
        $Messages = [
            'name.required' => 'Tên dịch vụ không được để trống',
        ];
        $Validator = Validator::make($Input, [
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|unique:customers,email'
        ], $Messages);
        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }
        $Service = new Service();
        $Service->name = $Input['name'];
        // $Service->update(['created_at' => microtime(true)]);
        $Service->save();


        return $this->sendResponse($Service->toArray(), 'Thêm thành công');
    }
}
