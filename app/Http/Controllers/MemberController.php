<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MemberController extends Controller
{
    public function index(){
        return view('member.dashboad');
    }
}
