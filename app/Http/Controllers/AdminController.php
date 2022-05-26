<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Service;
use ConsoleTVs\Charts\Facades\Charts;
use ConsoleTVs\Charts\BaseChart;
use Chartisan\PHP\Chartisan;
use App\Question;




class AdminController extends Controller
{
    public function newSurveyView(){
        // $Services = DB::table('services')->get();
        return view('admin.new-survey');
    }

    // Trang quản lý khảo sát
    public function surveyManagerView(){
        $Surveys = DB::table('surveys')
                    ->join('customers', 'customers.customer_id', '=', 'surveys.customer_id')
                    ->join('services', 'services.service_id', '=', 'surveys.service_id')
                    ->select('customers.fullname as customer', 'customers.customer_id', 'services.name as service', 'services.service_id', 'surveys.survey_id', 'surveys.created_at')
                    ->orderBy('survey_id', 'desc')
                    ->paginate(10);
        // return json_encode($Surveys);
        return view('admin.survey-manager', compact('Surveys'));
    }
    // Trang thống kê
    public function dashboardView(){
        return view('admin.dashboad');
    }

    // Quản lý người dùng
    public function userManagerView(){
        $Users = DB::table('users')
                ->orderBy('user_id', 'desc')
                ->paginate(10);
        // return response()->json($Users);
        return view('admin.user-manager', compact('Users'));
    }

    // Trang quản lý dịch vụ
    public function serviceManagerView(){
        $Services = DB::table('services')->paginate(10);
        return view('admin.service-manager', compact('Services'));
    }

    // Trang lấy chi tiết của một khảo sát
    public function surveyDetailView($id){
        // New
        $Surveys = DB::table('surveys')
                    ->join('survey_details', 'survey_details.survey_id', '=', 'surveys.survey_id')
                    ->where('surveys.survey_id', '=', $id)
                    ->join('services', 'services.service_id', '=', 'surveys.service_id')
                    ->join('questions', 'questions.question_id', '=', 'survey_details.question_id')
                    ->join('customers', 'customers.customer_id', '=', 'surveys.customer_id')
                    // ->join('note_meta', 'note_meta.note_id', '=', 'survey_details.note_id')
                    ->select('questions.*', 'services.name as service', 'survey_details.*' ,'customers.*')
                    ->get();
            

        // Gộp danh sách câu trả lời
        for($i = 0; $i < count($Surveys); $i++){
            $AnwserArray = [$Surveys[$i]->anwser_id];
            for($j = 0; $j < count($Surveys); $j++){
                if($Surveys[$i]->question_id == $Surveys[$j]->question_id && $Surveys[$i]->survey_detail_id != $Surveys[$j]->survey_detail_id && $Surveys[$i]->multiple == 1.0 && $Surveys[$j]->multiple == 1.0){
                    array_push($AnwserArray, $Surveys[$j]->anwser_id);
                }
                $Surveys[$i]->anwsers_id = $AnwserArray;
            }
        }
        // Xoá câu hỏi trùng lặp
        for($i = 0; $i < count($Surveys); $i++){
            for($j = 0; $j < count($Surveys); $j++){
                if($Surveys[$i]->question_id == $Surveys[$j]->question_id && $Surveys[$i]->survey_detail_id != $Surveys[$j]->survey_detail_id && $Surveys[$i]->multiple == 1.0 && $Surveys[$j]->multiple == 1.0){
                    array_splice($Surveys, $j, 1);
                }
            }
        }   
        $Questions = DB::table('questions')
                    ->join('anwsers', 'questions.question_id', '=', 'anwsers.question_id')
                    ->select('anwsers.*')
                    ->get();
        // Lấy nội dung của câu hỏi có tuỳ chọn nhập nội dung
        foreach($Surveys as $item){
            if($item->note_id !=0 || $item->note_id != null){
                $item->note = DB::table('note_meta')
                                ->where('note_id', '=', $item->note_id)
                                ->select('message')
                                ->first()->message;
            }
        }
        // return dd($Questions, $Surveys);
        if(!$Surveys){
            return abort(403, 'Nội dung này không tồn tại');
        }
        return view('admin.my-survey-single', compact('Surveys', 'id', 'Questions'));
    }


    // Trang quản lý khách hàng

    public function manageMyCustomerView(){
        $Customers = DB::table('customers')
                    ->orderBy('customer_id', 'desc')
                    ->paginate(10);
        return view('admin.my-customers', compact('Customers'));
    }

    // Quản lý câu hỏi
    public function manageQuestionView($ServiceID){
        $Questions = DB::table('questions')
                    ->join('service_survey', 'questions.question_id', '=', 'service_survey.question_id')
                    ->where('service_survey.service_id', '=', $ServiceID)
                    ->select('questions.*')
                    ->paginate(10);
        return view('admin.service-question', compact('Questions', 'ServiceID'));
    }

    // Chi tiết câu hỏi, câu trả lời

    public function questionDetails($id){
        $Questions = DB::table('questions')
                    ->where('question_id', '=', $id)
                    ->first();
        $Anwsers = DB::table('anwsers')
                    ->join('questions', 'questions.question_id', '=', 'anwsers.question_id')
                    ->where('anwsers.question_id', '=', $id)
                    ->select('anwsers.*')
                    ->paginate(10);
        // return dd($Questions, $Anwsers);
        return view('admin.question-details', compact('Questions' ,'Anwsers', 'id'));
    }

    // test chart chart
    public function chart(Request $request){

    }

    public function reportView($Service_id){
        // Xác minh xem có dịch vụ hay không
        $Service = Service::find($Service_id);
        if(is_null($Service)){
            abort(404, 'Không tìm thấy dịch vụ cần thống kê, bạn vui lòng kiểm tra lại');
        }

        // Lấy danh sách câu hoi
        $Questions = DB::table('service_survey')
                    ->join('questions' , 'questions.question_id', '=', 'service_survey.question_id')
                    ->where('service_survey.service_id', '=', $Service_id)
                    ->select('questions.*')
                    ->get();
        $data = [];
        foreach($Questions as $Question){
            $anwsers = DB::table('anwsers')->where('anwsers.question_id', '=', $Question->question_id)->get();
            $analyticsData = [];
            foreach($anwsers as $i){
                $count = DB::table('survey_details')
                            ->where('anwser_id', '=' , $i->anwser_id)
                            // ->where('created_at', '>', strtotime('-30 day', strtotime(date('M d, Y'))))
                            // ->where('created_at', '<', strtotime(date('M d, Y H:i:s')))
                            ->count();
                $temp = [$i->name, $count];
                array_push($analyticsData, $temp);
            }
            $Question->analytics = $analyticsData;
        }
        // foreach($Anwsers as $item){
        //     $temp = [$item->name];
        //     $count = DB::table('survey_details')
        //             ->where('anwser_id', '=' , $item->anwser_id)
        //             ->where('created_at', '>', strtotime('-30 day', strtotime(date('M d, Y'))))
        //             ->where('created_at', '<', strtotime(date('M d, Y')))
        //             ->count();
        //     array_push($temp, $count);
        //     array_push($data, $temp);
        // }
        // array_push($Questions, $data);
        // return response($Questions);
        return view('admin.report', compact('Questions'));
    }


    public function getQuestionReport(Request $request, $Question_id) {
        $start = strtotime($request->input('start'));
        $end = strtotime($request->input('end'));
        $start = (!$start)? strtotime('-30 day', strtotime(date('M d, Y'))): (int) $start;
        $end = (!$end)? strtotime(date('M d, Y H:i:s')): (int) $end;
        $Question = Question::find($Question_id);
        if(is_null($Question)){
            return $this->sendError('Không tìm thấy ID câu hỏi: '.$Question_id);
        }
        $date = strtotime(date('M d, Y'));
        // return strtotime("-1 day", $date);
        $data = [];
        $Anwsers = DB::table('anwsers')->where('question_id', '=', $Question_id)->get();
        foreach($Anwsers as $item){
            $temp = [$item->name];
            $count = DB::table('survey_details')
                    ->where('anwser_id', '=' , $item->anwser_id)
                    ->where('created_at', '>', $start)
                    ->where('created_at', '<', $end)
                    ->count();
            array_push($temp, $count);
            array_push($data, $temp);
        }
        // foreach($data as $item){
        //     $item = DB::table('survey_details')->where('an');
        // }

        return $this->sendResponse($data, 'Thành công');
    }

}
