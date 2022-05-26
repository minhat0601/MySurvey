
@extends('layouts.admin')
@section('title', 'Survey ID #'.$Surveys[0]->survey_id)
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Phiếu đánh giá chất lượng dịch vụ {{$Surveys[0]->service}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Basic Elements</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">ID: #{{$Surveys[0]->survey_id}}</h4>
                    </div>
                    <div class="card-body p-4">

                        <div class="row">


                            <!-- end row -->

                            <!-- Start row -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Thông tin khách hàng</h4>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="mb-4">
                                                    <label class="form-label" for="default-input">Họ & tên</label>
                                                    <input class="form-control" value="{{$Surveys[0]->fullname}}" disabled>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="default-input">Điện thoại</label>
                                                    <input class="form-control" value="{{$Surveys[0]->phone}}" disabled>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="default-input">Địa chỉ</label>
                                                    <input class="form-control" value="{{$Surveys[0]->address}}" disabled>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Chi tiết đánh giá</h4>
                                            <p class="card-title-desc">Dịch vụ: {{$Surveys[0]->service}}</p>
                                            <p class="card-title-desc">Thời gian tạo: {{gmdate("H:i d/m/Y", $Surveys[0]->created_at)}}</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="">
                                                    <div>
                                                        @foreach($Surveys as $key=>$item)
                                                            @if($item->multiple == 0.0)
                                                                <h5 class="font-size-14 mt-4 mb-2">{{$key+1}}. {{$item->question}}</h5>
                                                                @foreach($Questions as $anwser)
                                                                    @if($anwser->question_id == $item->question_id)
                                                                        @if(!$anwser->note_require)
                                                                            <div class="form-check mb-3">
                                                                                <input class="form-check-input" type="radio" name="{{$item->question}}" id="{{$anwser->anwser_id}}" value="{{$anwser->anwser_id}}" {{($anwser->anwser_id == $item->anwser_id)? 'Checked' : ''}} disabled>
                                                                                <label class="form-check-label" for="{{$anwser->anwser_id}}">{{$anwser->name}}</label>
                                                                            </div>
                                                                        @else 
                                                                            <div class="form-check mb-3">
                                                                                <input class="form-check-input" type="radio" name="{{$item->question}}" id="{{$anwser->anwser_id}}" value="{{$anwser->anwser_id}}" {{($anwser->anwser_id == $item->anwser_id)? 'Checked' : ''}} disabled>
                                                                                <label class="form-check-label" for="{{$anwser->anwser_id}}">{{$anwser->name}}</label>
                                                                            </div>
                                                                            <div class="form-check mb-3">
                                                                                <label class="form-check-label">{{$anwser->option_question}}: </label>
                                                                                @if(isset($item->note))
                                                                                    <textarea class="form-control" disabled row="3">{{$item->note}}</textarea>
                                                                                @else 
                                                                                    <textarea class="form-control" disabled row="3"></textarea>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                        @foreach($Surveys as $key=>$item)
                                                            @if($item->multiple == 1.0)
                                                                <h5 class="font-size-14 mt-4 mb-2">{{$key+1}}. {{$item->question}}</h5>
                                                                {{-- Lặp mảng câu trả lời --}}
                                                                @foreach($Questions as $anwser) 
                                                                    @if($anwser->question_id == $item->question_id)
                                                                        @foreach($item->anwsers_id as $anwser_id)
                                                                            @if($anwser_id == $anwser->anwser_id)
                                                                                <div class="form-check mb-3">
                                                                                    <input class="form-check-input" type="checkbox" id="{{$anwser->anwser_id}}" checked disabled>
                                                                                    <label class="form-check-label" for="{{$anwser->anwser_id}}">{{$anwser->name}}</label>
                                                                                </div>
                                                                            @else
                                                                                {{-- <div class="form-check mb-3">
                                                                                    <input class="form-check-input" type="checkbox" id="{{$anwser->anwser_id}}">
                                                                                    <label class="form-check-label" for="{{$anwser->anwser_id}}">{{$anwser->name}}</label>
                                                                                </div> --}}
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- End row -->
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>

@endsection()
