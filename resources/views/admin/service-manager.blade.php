@extends('layouts.admin')
@section('title', 'Quản lý dịch vụ')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Quản lý dịch vụ</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
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
                                <h4 class="card-title">Danh sách dịch vụ</h4>
                            </div>
                            <div class="col-6">
                                <button onclick="ServiceAdd()" class="btn btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="MySurveys" class="table table-bordered
                            dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dịch vụ</th>
                                    <th>Ngày tạo</th>
                                    <th>Cập nhật</th>
                                    <th>Tuỳ chọn</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(count($Services) == 0)
                                    <tr>
                                        <td colspan="4">
                                        Hiện tại chưa có dịch vụ nào.
                                        <td>
                                    </tr>
                                @endif
                                @foreach($Services as $key=>$item)
                                <tr>
                                    <td>#{{$item->service_id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->created_at)}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->updated_at)}}</td>
                                    <td>
                                        <a href="../admin/service/{{$item->service_id}}/report"class="btn btn-success">Report</a>
                                        <button onclick="ServiceUpdate('{{$item->service_id}}', '{{$item->name}}')" class="btn btn-primary">Cập nhật</button>
                                        <a href="../admin/service/{{$item->service_id}}/question"class="btn btn-warning">Quản lý câu hỏi</a>
                                        <a class="btn btn-danger">Xoá</a>
                                    </td>
                                </tr>
                                @endforeach()
                            </tbody>
                        </table>
                        {{ $Services->links() }}
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
    <!-- Scrollable modal -->
    <div class="modal fade" id="EditServiceModal" tabindex="-1" aria-labelledby="EditServiceModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" id="EditServiceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditServiceModalTitle">Cập nhật thông tin dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="EditServiceModalAlert" role="alert">
                            <i class="mdi mdi-block-helper label-icon"></i>
                            <div id="EditServiceModalAlertContent"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                        <div class="mb-3 d-none">
                            <label for="ServiceId" class="form-label">Service ID</label>
                            <input class="form-control" type="number" id="ServiceId">
                        </div>
                        <div class="mb-3">
                            <label for="Name" class="form-label">Dịch vụ</label>
                            <input class="form-control" type="text" placeholder="Tên dịch vụ" id="Name">
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
    <div class="modal fade" id="AddNewServiceModal" tabindex="-1" aria-labelledby="AddNewServiceModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" id="AddNewServiceForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddNewServiceModalTitle">Thêm dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="AddNewServiceModalAlert" role="alert">
                            <i class="mdi mdi-block-helper label-icon"></i>
                            <div id="AddNewServiceModalAlertContent"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="NewNam" class="form-label">Dịch vụ</label>
                            <input class="form-control" type="text" placeholder="Tên dịch vụ" id="NewName">
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
    const ServiceUpdate = (service_id, name) =>{
        $('#ServiceId').val(service_id);
        $('#Name').val(name);
        $('#EditServiceModal').modal('show');
    }
    const Update = () => {
        var service_id = $('#ServiceId').val();
        var name = $('#Name').val();
        if(service_id && name){
            Notiflix.Block.dots('#EditServiceForm');
            $.ajax({
                type: "POST",
                url: "../api/v1/service/"+service_id,
                data: {
                    service_id: service_id,
                    name: name
                },
            }).done(function(res){
                Notiflix.Notify.success(res.message);
                Notiflix.Block.remove('#EditServiceForm');
                setTimeout(function() {
                    window.location.reload();
                }, 1300);
            }).fail(function(res){
                Notiflix.Block.remove('#EditServiceForm');
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
                    $('#EditServiceModalAlertContent').html(string);
                    $('#EditServiceModalAlert').removeClass('hide');
                    $('#EditServiceModalAlert').addClass('show');
            });
        }else{
            Notiflix.Report.failure(
            'Lỗi',
            'Vui lòng không để trống dữ liệu',
            'Đã hiểu',
            );
        }
    }

    const ServiceAdd = () =>{

        $('#AddNewServiceModal').modal('show');
    }

    const Save = () => {
        var name = $('#NewName').val();
        if(name){
            Notiflix.Block.dots('#AddNewServiceForm');
            $.ajax({
                type: "POST",
                url: "../api/v1/service",
                data: {
                    name: name
                },
            }).done(function(res){
                Notiflix.Block.dots('#AddNewServiceForm');
                Notiflix.Notify.success(res.message);
                setTimeout(function() {
                    window.location.reload();
                }, 1300);
            }).fail(function(res){
                Notiflix.Block.remove('#AddNewServiceForm');
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