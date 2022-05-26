<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Question;
use App\Service;

class QuestionController extends ApiBaseController
{
    public function create(Request $request, $Service_id){
        $Service = Service::find($Service_id);
        if(is_null($Service)){
            return $this->sendError('Không tìm thấy dịch vụ cần thêm câu hỏi');
        }   
        $Input = $request->all();
        $Messages = [
            'question.required' => 'Bạn chưa nhập câu trả lời',
            'multiple.required' => 'Bạn chưa chọn loại câu hỏi',
            'multiple.numeric' => 'Loại câu hỏi không hợp lệ',
            'multiple.min' => 'Loại câu hỏi không hợp lệ',
            'multiple.max' => 'Loại câu hỏi không hợp lệ'
        ];
        $Validator = Validator::make($Input, [
            'question' => 'required',
            'multiple' => 'required|numeric|min:0|max:1',
        ], $Messages);

        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }
        $Question = new Question();
        $Question->question = $request->input('question');
        $Question->multiple = $request->input('multiple');
        $Question->save();
        DB::table('service_survey')
            ->insert([
                'service_id' => $Service_id,
                'question_id' => $Question->question_id
            ]);
        return $this->sendResponse($Question->toArray(), 'Thêm mới thành công');
    }
    public function update(Request $request, $Question_id){
        $Question = Question::find($Question_id);
        if(is_null($Question)){
            return $this->sendError('Không tìm thấy câu hỏi cần cập nhật');
        }
        $Input = $request->all();
        $Messages = [
            'question.required' => 'Bạn chưa nhập câu trả lời',
            'multiple.required' => 'Bạn chưa chọn loại câu hỏi',
            'multiple.numeric' => 'Loại câu hỏi không hợp lệ',
            'multiple.min' => 'Loại câu hỏi không hợp lệ',
            'multiple.max' => 'Loại câu hỏi không hợp lệ'
        ];
        $Validator = Validator::make($Input, [
            'question' => 'required',
            'multiple' => 'required|numeric|min:0|max:1',
        ], $Messages);

        if($Validator->fails()){
            return $this->sendError('Lỗi. ', $Validator->errors());       
        }
        $Question->question = $request->input('question');
        $Question->multiple = $request->input('multiple');
        $Question->save();
        return $this->sendResponse($Question->toArray(), 'Cập nhật thành công');
    }
}
