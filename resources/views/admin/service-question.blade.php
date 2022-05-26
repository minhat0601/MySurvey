@extends('layouts.admin')
@section('title', 'Quản lý câu hỏi')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Quản lý câu hỏi</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Quản lý dịch vụ</li>
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
                        <div class="row d-flex justify-content-between">
                            <div class="col-6">
                                <h4 class="card-title">Danh sách câu hỏi</h4>
                            </div>
                            <div class="col-6">
                                <button onclick="QuestionAdd()" class="btn btn-primary">Thêm câu hỏi</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="MySurveys" class="table table-bordered
                            dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Câu hỏi</th> 
                                    <th>Loại câu hỏi</th>
                                    <th>Ngày tạo</th>
                                    <th>Cập nhật</th>
                                    <th>Tuỳ chọn</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($Questions) == 0)
                                    <tr>
                                        <td colspan="5">
                                            Bạn chưa thêm câu hỏi nào cho dịch vụ này
                                        <td>
                                    </tr>
                                @endif
                                @foreach($Questions as $key=>$item)
                                <tr>
                                    <td>#{{($key+1)}}</td>
                                    <td>{{$item->question}}</td>
                                    <td>{{($item->multiple == 0.0)? 'Only': 'Multiple'}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->created_at)}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->updated_at)}}</td>
                                    <td>
                                        <button onclick="OpenUpdateModal(`{{$item->question_id}}`, `{{$item->question}}`, `{{$item->multiple}}`)" class="btn btn-warning">Cập nhật</button>
                                        <a href="{{ route('admin.questionManager', ['id' => "$item->question_id"]) }}" class="btn btn-primary">Quản lý câu trả lời</a>
                                        <a class="btn btn-danger">Xoá</a>
                                    </td>
                                </tr>
                                @endforeach()
                            </tbody>
                        </table>
                        {{ $Questions->links() }}
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
    <!-- Scrollable modal -->
    <div class="modal fade" id="EditQuestionModal" tabindex="-1" aria-labelledby="EditQuestionModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" id="EditQuestionForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditQuestionModalTitle">Cập nhật thông tin dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="EditQuestionModalAlert" role="alert">
                            <i class="mdi mdi-block-helper label-icon"></i>
                            <div id="EditQuestionModalAlertContent"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                        <div class="mb-3 d-none">
                            <label for="QuestionId" class="form-label">Question ID</label>
                            <input class="form-control" type="number" id="QuestionId">
                        </div>
                        <div class="mb-3">
                            <label for="Name" class="form-label">Câu hỏi</label>
                            <input class="form-control" type="text" placeholder="Tên câu hỏi" id="Name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Multiple">Loại câu hỏi?</label>
                            <select class="form-select" name="Multiple" id="Multiple">
                                <option value="0" selected="">Only</option>
                                <option value="1">Multiple</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="Update()">Cập nhật</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

        <!-- Scrollable modal -->
        <div class="modal fade" id="AddNewQuestionModal" tabindex="-1" aria-labelledby="AddNewQuestionModalArea" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content" id="AddNewQuestionForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddNewQuestionModalTitle">Thêm dịch vụ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="mb-3">
                                <label for="NewName" class="form-label">Câu hỏi</label>
                                <input class="form-control" type="text" placeholder="Tên câu hỏi" id="NewName">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="NewMultiple">Loại câu hỏi?</label>
                                <select class="form-select" name="Multiple" id="NewMultiple">
                                    <option value="0" selected="">Only</option>
                                    <option value="1">Multiple</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" onclick="Save()">Thêm</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script>
    const OpenUpdateModal = (question_id, name, multiple) =>{
        $('#QuestionId').val(question_id);
        $('#Name').val(name);
        $('#Multiple').val(multiple);
        $('#EditQuestionModal').modal('show');
    }
    const Update = () => {
        var question_id = $('#QuestionId').val();
        var question = $('#Name').val();
        var multiple = $('#Multiple').val();
        if(question_id && question && multiple){
            Notiflix.Block.dots('#EditQuestionForm');
            $.ajax({
                type: "PUT",
                url: "{{route('api.v1.question.update', [''])}}/"+question_id,
                data: {
                    question: question,
                    multiple: multiple
                },
            }).done(function(res){
                Notiflix.Notify.success(res.message);
                Notiflix.Block.remove('#EditQuestionForm');
                setTimeout(function() {
                    window.location.reload();
                }, 1300);
            }).fail(function(res){
                Notiflix.Block.remove('#EditQuestionForm');
                    var messages = JSON.parse(res.responseText);
                    // Lấy các trường lỗi do server trả về
                    messages = messages.data;
                    // Convert dữ liệu sang mảng
                    messages = Object.values(messages)
                    console.log(messages);
                    var string = '';
                    messages.map(function(item){
                        string += item[0]+'<br>';
                        // if(count(item) > 1){
                        //     item.map(function(i){
                        //         string += i;
                        //     })
                        // }
                    })
                    console.log(string);
                    $('#EditQuestionModalAlertContent').html(string);
                    $('#EditQuestionModalAlert').removeClass('hide');
                    $('#EditQuestionModalAlert').addClass('show');
            });
        }else{
            Notiflix.Report.failure(
            'Lỗi',
            'Vui lòng không để trống dữ liệu',
            'Đã hiểu',
            );
        }
    }

    const QuestionAdd = () =>{

        $('#AddNewQuestionModal').modal('show');
    }

    const Save = () => {
        var question = $('#NewName').val();
        var multiple = $('#Multiple').val();
        if(question && multiple){
            Notiflix.Block.dots('#AddNewQuestionForm');
            $.ajax({
                type: "POST",
                url: "{{route('api.v1.question.create', [''])}}/{{$ServiceID}}",
                data: {
                    question: question,
                    multiple: multiple,
                },
            }).done(function(res){
                Notiflix.Block.dots('#AddNewQuestionForm');
                Notiflix.Notify.success(res.message);
                setTimeout(function() {
                    window.location.reload();
                }, 1300);
            }).fail(function(res){
                Notiflix.Block.remove('#AddNewQuestionForm');
                    var messages = JSON.parse(res.responseText);
                    // Lấy các trường lỗi do server trả về
                    messages = messages.data;
                    // Convert dữ liệu sang mảng
                    messages = Object.values(messages)
                    console.log(messages);
                    var string = '';
                    messages.map(function(item){
                        string += item[0]+'<br>';
                        // if(count(item) > 1){
                        //     item.map(function(i){
                        //         string += i;
                        //     })
                        // }
                    })
                    console.log(string);
                    $('#AddNewQuestionAlertContent').html(string);
                    $('#AddNewQuestionAlert').removeClass('hide');
                    $('#AddNewQuestionAlert').addClass('show');
            });
        }else{
            Notiflix.Report.failure(
            'Lỗi',
            'Vui lòng không để trống dữ liệu',
            'Đã hiểu',
            );
        }
    }</script>

@endsection