<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Customer;
use App\Service;
use App\User;

class ManagerController extends Controller
{
    
    public function index(){
        echo 'Index';
    }
    public function homePage(){
        return view('manager.homepage');
    }
    // Trang tạo khảo sát
    public function createSurveyView(){
        $Services = DB::table('services')->get();
        return view('manager.new-survey', compact('Services'));
    }

    // Trang danh sách khảo sát đã tạo của nhân viên
    public function manageMySurveyView(){
        $Surveys = DB::table('surveys')
                    ->join('customers', 'customers.customer_id', '=', 'surveys.customer_id')
                    ->join('services', 'services.service_id', '=', 'surveys.service_id')
                    ->select('customers.fullname as customer', 'customers.customer_id', 'services.name as service', 'services.service_id', 'surveys.survey_id', 'surveys.created_at')
                    ->where('surveys.user_id', '=', Auth::user()['user_id'])
                    ->orderBy('survey_id', 'desc')
                    ->paginate(10);
        // return json_encode($Surveys);
        return view('manager.my-surveys', compact('Surveys'));
    }
 
    // Lấy danh sách mẫu khảo sát
    public function surveyDetailView($id){
        // Old
    
        // // Mảng thông tin câu hỏi và câu KH chọn
        // $Surveys = DB::table('surveys')
        //             ->where('surveys.survey_id', '=', $id)
        //             ->where('surveys.user_id', '=', Auth::user()['user_id'])
        //             ->join('survey_details', 'survey_details.survey_id', '=', 'surveys.survey_id')
        //             ->join('services', 'services.service_id', '=', 'surveys.service_id')
        //             ->join('customers', 'customers.customer_id', '=', 'surveys.customer_id')
        //             ->join('questions', 'questions.question_id', '=', 'survey_details.question_id')
        //             ->join('anwsers', 'anwsers.anwser_id', '=', 'survey_details.anwser_id')
        //             ->select('questions.question', 'questions.question_id', 'anwsers.name as anwser', 'anwsers.anwser_id', 'services.name as service', 'customers.fullname', 'customers.customer_id', 'customers.phone', 'customers.address', 'surveys.created_at', 'surveys.survey_id', 'questions.multiple')
        //             ->get();
        // // Mảng thông tin câu hỏi và câu trả lời
        // $Questions = DB::table('surveys')
        //             ->where('surveys.survey_id', '=', $id)
        //             ->where('surveys.user_id', '=', Auth::user()['user_id'])
        //             ->join('survey_details', 'survey_details.survey_id', '=', 'surveys.survey_id')
        //             ->join('questions', 'questions.question_id', '=', 'survey_details.question_id')
        //             ->join('anwsers', 'anwsers.question_id', '=', 'survey_details.question_id')
        //             ->select('questions.question', 'questions.question_id', 'anwsers.name as anwser', 'anwsers.anwser_id')
        //             ->get();

        // for($i=0; $i<count($Surveys); $i++){
        //     $Surveys[$i]->anwsers = [];
        //     // Lặp danh sách câu trả lời và kiểm tra nếu cùng question_id
        //     for($j=0; $j<count($Questions); $j++){
        //         if($Surveys[$i]->question_id == $Questions[$j]->question_id){
        //             $arr = [
        //                 'anwser_id' => $Questions[$j]->anwser_id,
        //                 'anwser' => $Questions[$j]->anwser,
        //                 'selected' => ($Questions[$j]->anwser_id == $Surveys[$i]->anwser_id)? true : false,
        //             ];
        //             array_push($Surveys[$i]->anwsers, $arr);
        //         }
        //     }
            
        // }
        // if($Surveys && $Questions){
        //     return view('manager.my-survey-single', compact('Surveys', 'id'));
        // }else{
        //     return abort(404,'Nội dung bạn cần tìm không tồn tại hoặc bạn không có quyền truy cập trang này. Vui lòng báo với admin nếu bạn cho rằng đây là một lỗi.');        
        // }


        // New
        $Surveys = DB::table('surveys')
                    ->join('survey_details', 'survey_details.survey_id', '=', 'surveys.survey_id')
                    ->where('surveys.survey_id', '=', $id)
                    ->where('surveys.user_id', '=', Auth::user()['user_id'])
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
    
        foreach($Surveys as $item){
            if($item->note_id !=0 || $item->note_id != null){
                $item->note = DB::table('note_meta')
                                ->where('note_id', '=', $item->note_id)
                                ->select('message')
                                ->first()->message;
            }
        }
        if(!$Surveys){
            return abort(403, 'Không tìm thấy nội dung bạn cần tìm hoặc bạn không được phép xem nội dung này. Nếu bạn cho đây là một lỗi, vui lòng liên hệ với admin');
        }
        return view('manager.my-survey-single', compact('Surveys', 'id', 'Questions'));
    }
    
    public function manageMyCustomerView(){
        $Customers = DB::table('customers')
                    ->where('user_id', '=', Auth::user()['user_id'])
                    ->orderBy('customer_id', 'desc')
                    ->paginate(10);
        return view('manager.my-customers', compact('Customers'));


        
    }

    public function testCustomers(){
        // $Customers = DB::table('customers')
        //             ->where('user_id', '=', Auth::user()['user_id'])
        //             ->orderBy('customer_id', 'desc')
        //             ->paginate(10);
        // return view('manager.my-customers', compact('Customers'));


        //

        $columns = array(
            0 => 'customer_id',
            1 => 'fullname',
            2 => 'phone',
            3 => 'address',
            4 => 'created_at',
            5 => 'acction'
        );
        $totalData = DB::table('customers')->where('user_id', '=', Auth::user()['user_id'])->count();
        $limit = Input::get('length');
        $start = Input::get('start');
        $order = $columns[Input::get('order.0.column')];
        $dir = Input::get('order.0.dir');
        if(empty(Input::get('search.value'))){
            $Customers = Customer::offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->where('user_id', '=', Auth::user()['user_id'])
                        ->get();
            $totalFiltered = $totalData;
        }else{
            $search = Input::get('search.value');
            $Customers = Customer::where('name', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order, $dir)
                        ->where('user_id', '=', Auth::user()['user_id'])
                        ->get();
            $totalFiltered = Customer::where('name', 'like', "%$search%")
                            ->orWhere('phone', 'like', "%$search%")
                            ->orWhere('address', 'like', "%$search%")
                            ->count();
        }               
        $data = [];
        if($Customers){
            foreach($Customers as $item){
                $temp['customer_id'] = $item->customer_id;
                $temp['fullname'] = $item->fullname;
                $temp['phone'] = $item->phone;
                $temp['address'] = $item->address;
                $temp['created_at'] = gmdate('H:i d/m/Y', $item->address);
                $temp['action'] = `
                        <a class="btn btn-warning" onclick="OpenUpdateForm('{{$item->customer_id}}', '{{$item->fullname}}', '{{$item->phone}}', '{{$item->address}}')">Cập nhật</a>
                        <a class="btn btn-danger" onclick="CustomerDelete('{{$item->customer_id}}', '{{$item->fullname}}')">Xoá</a>
                `;
                $data[] = $temp;

            }
            json_encode([
                'draw' => intval(Input::get('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ]);
        }
        return response($data);
    }
}
