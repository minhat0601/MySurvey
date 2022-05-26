<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Anwser;

class AnwserController extends ApiBaseController
{
    public function create(Request $request, $id){
        $Question = DB::table('questions')
                    ->where('question_id', $id)
                    ->first();
        if(is_null($Question)){
            return $this->sendError('Không tìm thấy câu hỏi cần thêm');
        }   
        $Input = $request->all();
        $Messages = [
            'name.required' => 'Bạn chưa nhập câu trả lời',
            'note_require.required' => 'note_require đang bị thiếu',
            'note_require.numeric' => 'note_require không hợp lệ',
            'option_question.required_if' => 'Bạn chưa nhập nội dung câu hỏi thêm'
        ];
        $Validator = Validator::make($Input, [
            'name' => 'required',
            'note_require' => 'required|numeric',
            'option_question' => 'required_if:note_require,==,1|string'
        ], $Messages);

        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }
        $Anwser = new Anwser();
        $Anwser->name = $request->input('name');
        $Anwser->note_require = $request->input('note_require');
        $Anwser->option_question = $request->input('option_question');
        $Anwser->question_id = $id;
        $Anwser->save();
        return $this->sendResponse($Anwser->toArray(), 'Thêm mới thành công');
    }
    public function update(Request $request, $id){
        $Anwser = Anwser::find($id);
        if(is_null($Anwser)){
            return $this->sendError('Không tìm thấy nội dung cần cập nhật');
        }
        $Input = $request->all();
        $Messages = [
            'anwser_id.required' => 'anwser_id không hợp lệ',
            'anwser_id.numeric' => 'anwser_id không hợp lệ',
            'name.required' => 'Bạn chưa nhập câu trả lời',
            'note_require.required' => 'note_require đang bị thiếu',
            'note_require.numeric' => 'note_require không hợp lệ',
            'option_question.required_if' => 'Bạn chưa nhập nội dung câu hỏi thêm'
        ];
        $Validator = Validator::make($Input, [
            'anwser_id' => 'required|numeric',
            'name' => 'required',
            'note_require' => 'required|numeric',
            'option_question' => 'required_if:note_require,==,1|string',
        ], $Messages);

        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }
        $Anwser->name = $request->input('name');
        $Anwser->note_require = $request->input('note_require');
        $Anwser->option_question = $request->input('option_question');
        $Anwser->save();
        return $this->sendResponse($Anwser->toArray(), 'Cập nhật thành công');
    }
}
