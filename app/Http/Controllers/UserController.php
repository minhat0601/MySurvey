<?php

namespace App\Http\Controllers;
use PDO, PDOException;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    public function index(){
        return 'ok';
    }
    public function login(){
        return view('login');
    }

    public function signup(){
        return view('register');
    }
    // public function test(){
    //     return dd((DB::select(DB::raw('SHOW CREATE TABLE survey_details'))));
    // }

    public function recover(){
        return 'Trang tìm lại mật khẩu';
    }

    public function permissionHandle(){
        if(Auth::user()['user_type'] == 1){
            return redirect('member');
        }elseif(Auth::user()['user_type'] == 2){
            return redirect()->route('manager.homepage');
        }elseif(Auth::user()['user_type'] == 3){
            return redirect('admin');
        }
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/');    
    }
}
