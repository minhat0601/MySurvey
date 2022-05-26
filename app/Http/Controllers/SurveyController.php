<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use App\Survey;
use Illuminate\Support\Facades\Auth;




class SurveyController extends Controller
{
    // Lấy danh sách dịch vụ khảo sát
    public function surveyList(){
        $Service = Service::all();
        return $this->sendResponse($Service, 'Lấy dữ liệu thành công');
    }

    // Lấy dữ liệu của bài khảo sát
    public function getSurveyDetails($ServiceId){
        $Service = Service::find($ServiceId);
        $Questions = DB::table('service_survey')
                    ->where('service_survey.service_id','=', $ServiceId)
                    ->join('questions', 'service_survey.question_id', '=', 'questions.question_id')
                    ->join('anwsers', 'anwsers.question_id', '=', 'service_survey.question_id')
                    ->select('questions.question', 'questions.question_id', 'anwsers.name', 'anwsers.anwser_id','anwsers.note_require', 'anwsers.option_question', 'questions.multiple')
                    ->get();

        if(!is_null($Questions)){
            // for($i = 0; $i < $Questions->count(); $i++){
            //     for($j = 0; $j < $Questions->count(); $j++){
            //         if($Questions[$j]->question_id == $Questions[$i]->question_id && $j != $i){
            //             array_push($newArray, (Object) array(['anwser']));
            //         }
            //     }
            // }
        }
        return $this->sendResponse(['service' => $Service['name'], 'service_id' => $Service['service_id'], 'questions'=>$Questions], 'Lấy dữ liệu thành công');
    }
    // Lưu dữ liệu bài khảo sát
    public function surveySubmit(Request $request){
        $Input = $request->all();
        $Message = [
            'customer_id.required' => 'Không nhận được ID khách hàng',
            'customer_id.numeric' => 'ID khách hàng không đúng định dạng',
            'data.required' => 'Không nhận được dữ liệu',
            'service.required' => 'Không nhận được ID dịch vụ',
            'service.numeric' => 'Service không hợp lệ',
        ];
        $Validator = Validator::make($Input, [
            'customer_id' =>'required|numeric',
            'data' => 'required',
            'service_id' => 'required|numeric'
        ], $Message);
        if($Validator->fails()){
            return $this->sendError('Lỗi', $Validator->errors());
        }        
        $Customer = Customer::find($request->input('customer_id'));
        if(is_null($Customer)){
            return $this->sendError('Lỗi', ['Customer' => 'Không tìm thấy người dùng này']);
        }
        $Service = Service::find($request->input('service_id'));
        if(is_null($Service)){
            return $this->sendError('Lỗi', ['Service' => 'Không tìm thấy dịch vụ cần đánh giá']);
        }
        $Survey = new Survey();
        $Survey->user_id = Auth::user()['user_id'];
        $Survey->service_id = $Service['service_id'];
        $Survey->customer_id = $Customer['customer_id'];
        $Survey->save();

        $data = json_decode($request->input('data'));
        for($i = 0; $i < count((array)$data); $i++ ){
            // DB::insert("insert into service_details (question_id, anwser_id, survey_id, service_id) values ($data[$i]['question_id'], $data[$i]['answer_id'],  )");
            if(isset($data[$i]->option_anwser)){
                $note_id = DB::table('note_meta')
                    ->insertGetId([
                        'message' => $data[$i]->option_anwser,
                        'anwser_id' => $data[$i]->anwser_id
                ]);
            }
            DB::table('survey_details')
                ->insertGetId([
                    'question_id' => $data[$i]->question_id,
                    'anwser_id' => $data[$i]->anwser_id,
                    'survey_id' => $Survey['survey_id'],
                    'note_id' => (isset($data[$i]->option_anwser))? $note_id : null,
                    'created_at' => strtotime(date('M d, Y H:i:s'))
                ]);

        }

        return $this->sendResponse($Survey, 'Cập nhật thành công');
    }

    public function test(){
        return json_decode(DB::select(DB::raw('show create table surveys')->select('survey_')));
    }
}
