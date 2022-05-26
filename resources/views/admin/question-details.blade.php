@extends('layouts.admin')
@section('title', $Questions->question)

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Quản lý câu trả lời</h4>

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
                                <h4 class="card-title">Hỏi. {{$Questions->question}}</h4>
                            </div>
                            <div class="col-6">
                                <button onclick="AnwserNew()" class="btn btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="MySurveys" class="table table-bordered
                            dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Trả lời</th> 
                                    <th>Hỏi thêm</th>
                                    <th>Ngày tạo</th>
                                    <th>Cập nhật</th>
                                    <th>Tuỳ chọn</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($Anwsers) == 0)
                                    <tr>
                                        <td colspan="4">
                                            Bạn chưa thêm câu trả lời nào cho câu hỏi này
                                        <td>
                                    </tr>
                                @endif
                                @foreach($Anwsers as $key=>$item)
                                <tr>
                                    <td>#{{($key+1)}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{($item->note_require)? $item->option_question: ''}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->created_at)}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->updated_at)}}</td>
                                    <td>
                                        <button onclick="EditMode('{{$item->anwser_id}}','{{$item->name}}', '{{$item->note_require}}', '{{$item->option_question}}')" class="btn btn-warning">Cập nhật</button>
                                        <a class="btn btn-danger">Xoá</a>
                                    </td>
                                </tr>
                                @endforeach()
                            </tbody>
                        </table>
                        {{ $Anwsers->links() }}
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
    <!-- Scrollable modal -->
    <div class="modal fade" id="EditAnwserModal" tabindex="-1" aria-labelledby="EditAnwserModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" id="EditAnwserForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditAnwserModalTitle">Cập nhật câu trả lời</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="EditAnwserModalAlert" role="alert">
                            <i class="mdi mdi-block-helper label-icon"></i>
                            <div id="EditAnwserModalAlertContent"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                        <div class="mb-3 d-none">
                            <label for="AnwserId" class="form-label">Anwser ID</label>
                            <input class="form-control" type="number" id="AnwserId">
                        </div>
                        <div class="mb-3">
                            <label for="Anwser" class="form-label">Trả lời</label>
                            <textarea class="form-control" type="text" placeholder="Nhập câu trả lời" id="Anwser"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="NoteRequire">Hỏi thêm?</label>
                            <select class="form-select" name="NoteRequire" id="NoteRequire">
                                <option value="0" selected="">Không</option>
                                <option value="1">Có</option>
                            </select>
                        </div>
                        <div class="mb-3" id="Note">
                            <label for="OptionQuestion" class="form-label">Nội dung hỏi thêm</label>
                            <textarea class="form-control" type="text" placeholder="Nhập nội dung bạn muốn hỏi thêm" id="OptionQuestion"></textarea>
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
        <div class="modal fade" id="AnwserNewModal" tabindex="-1" aria-labelledby="AnwserNewModalArea" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content" id="AnwserNewForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="AddNewServiceModalTitle">Thêm câu trả lời</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="AnwserNewModalAlert" role="alert">
                                <i class="mdi mdi-block-helper label-icon"></i>
                                <div id="AnwserNewModalAlertContent"></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                            <div class="mb-3">
                                <label for="NewAnwser" class="form-label">Trả lời</label>
                                <textarea class="form-control" type="text" placeholder="Nhập câu trả lời" id="NewAnwser"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="NewNoteRequire">Hỏi thêm?</label>
                                <select class="form-select" name="NewNoteRequire" id="NewNoteRequire">
                                    <option value="0" selected="">Không</option>
                                    <option value="1">Có</option>
                                </select>
                            </div>
                            <div class="mb-3 d-none" id="NewNote">
                                <label for="OptionQuestion" class="form-label">Nội dung hỏi thêm</label>
                                <textarea class="form-control" type="text" placeholder="Nhập nội dung bạn muốn hỏi thêm" id="NewOptionQuestion"></textarea>
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
    $( "#NoteRequire" ).change(function() {
        if($('#NoteRequire').val() == 0){
            $('#Note').addClass('d-none');
            $('#OptionQuestion').val('');

        }else{
            $('#Note').removeClass('d-none');
        }
    });
    $( "#NewNoteRequire" ).change(function() {
        if($('#NewNoteRequire').val() == 0){
            $('#NewNote').addClass('d-none');
            $('#NewOptionQuestion').val('');

        }else{
            $('#NewNote').removeClass('d-none');
        }
    });
    const EditMode = (anwser_id, anwser, note_require, option_question) =>{
        $('#AnwserId').val(anwser_id);
        $('#Anwser').val(anwser);
        $("#NoteRequire").val(note_require).change();
        if($('#NoteRequire').val() == 0){
            $('#OptionQuestion').val(option_question);
            $('#Note').addClass('d-none');
        }else{
            $('#OptionQuestion').val(option_question);
        }
        $('#EditAnwserModal').modal('show');
    }
    const Update = () => {
        var anwser_id = $('#AnwserId').val();
        var name = $('#Anwser').val();
        var note_require = $('#NoteRequire').val()
        var option_question = $('#OptionQuestion').val();
        if(anwser_id && name && note_require){
            Notiflix.Block.dots('#EditAnwserForm');
            $.ajax({
                type: "POST",
                url: "{{ route('api.v1.anwser.update', "") }}/"+anwser_id,
                data: {
                    anwser_id: anwser_id,
                    name: name,
                    note_require: note_require,
                    option_question: option_question
                },
            }).done(function(res){
                Notiflix.Notify.success(res.message);
                Notiflix.Block.remove('#EditAnwserForm');
                setTimeout(function() {
                    window.location.reload();
                }, 1300);
            }).fail(function(res){
                Notiflix.Block.remove('#EditAnwserForm');
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
                    $('#EditAnwserModalAlertContent').html(string);
                    $('#EditAnwserModalAlert').removeClass('hide');
                    $('#EditAnwserModalAlert').addClass('show');
            });
        }else{
            Notiflix.Report.failure(
            'Lỗi',
            'Vui lòng không để trống dữ liệu',
            'Đã hiểu',
            );
        }
    }

    const AnwserNew = () =>{
        $('#AnwserNewModal').modal('show');
    }

    const Save = () => {
        var name = $('#NewAnwser').val();
        var note_require = $('#NewNoteRequire').val();
        var option_question = $('#NewOptionQuestion').val();
        if(name && note_require){
            Notiflix.Block.dots('#AnwserNewForm');
            $.ajax({
                type: "POST",
                url: "{{ route('api.v1.anwser.create', "") }}/{{$id}}",
                data: {
                    name: name,
                    note_require: note_require,
                    option_question: ((option_question==null)? '': option_question)
                },
            }).done(function(res){
                Notiflix.Block.dots('#AnwserNewForm');
                Notiflix.Notify.success(res.message);
                setTimeout(function() {
                    window.location.reload();
                }, 1300);
            }).fail(function(res){
                Notiflix.Block.remove('#AnwserNewForm');
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
                    $('#AddNewServiceAlertContent').html(string);
                    $('#AddNewServiceAlert').removeClass('hide');
                    $('#AddNewServiceAlert').addClass('show');
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