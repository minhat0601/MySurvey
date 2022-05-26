@extends('layouts.admin')
@section('title', 'Quản lý nhân sự')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Quản lý nhân sự</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Quản lý nhân sự</li>
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
                        <h4 class="card-title">Danh sách nhân sự</h4>
                    </div>
                    <div class="card-body">

                        <table id="MySurveys" class="table table-bordered
                            dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>ID</th>
                                    <th>Họ & tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Phân quyền</th>
                                    <th>Ngày tạo</th>
                                    <th>Tuỳ chọn</th>
                                </tr>
                            </thead>

                            {{-- {{dd($Users)}} --}}
                            <tbody>
                                @if(count($Users) == 0)
                                    <tr>
                                        <td colspan="5">
                                        Hiện tại chưa có nhân sự nào.
                                        <td>
                                    </tr>
                                @endif
                                @foreach($Users as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>#{{$item->user_id}}</td>
                                    <td>{{$item->fullname}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>0{{$item->phone}}</td>
                                    <td>{{($item->user_type == 1) ? 'Không': (($item->user_type == 2) ? 'Nhân viên' : (($item->user_type == 3) ? 'Super Admin': ''))}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->created_at)}}</td>
                                    <td>
                                        <button onclick="UserUpdate('{{$item->user_id}}', '{{$item->fullname}}', '{{$item->email}}', '{{$item->phone}}', '{{$item->user_type}}')" class="btn btn-primary">Cập nhật</button>
                                        <a class="btn btn-danger">Xoá</a>
                                    </td>
                                </tr>
                                @endforeach()
                            </tbody>
                        </table>
                        {{ $Users->links() }}
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
    <!-- Scrollable modal -->
    <div class="modal fade" id="EditUserModal" tabindex="-1" aria-labelledby="EditUserModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" id="EditUserForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditUserModalTitle">Cập nhật thông tin nhân sự</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="EditUserModalAlert" role="alert">
                            <i class="mdi mdi-block-helper label-icon"></i>
                            <div id="EditUserModalAlertContent"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                        <div class="mb-3 d-none">
                            <label for="Fullname" class="form-label">User ID</label>
                            <input class="form-control" type="number" id="UserId">
                        </div>
                        <div class="mb-3">
                            <label for="Fullname" class="form-label">Họ và tên</label>
                            <input class="form-control" type="text" placeholder="Họ và tên người dùng" id="Fullname">
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input class="form-control" type="text" placeholder="Email người dùng" id="Email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="default-input">Phân quyền</label>
                            <select class="form-select" name="UserType" id="UserType">
                                <option value="1" selected="">Không</option>
                                <option value="2">Nhân viên</option>
                                <option value="3">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Phone" class="form-label">Số điện thoại</label>
                            <input class="form-control" type="number" placeholder="Nhập số điện thoại khách hàng" id="Phone">
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
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script>
    const UserUpdate = (user_id, fullname, email, phone, user_type) =>{
        $('#UserId').val(user_id);
        $('#Fullname').val(fullname);
        $('#Email').val(email);
        $('#Phone').val(phone);
        $("#UserType").val(user_type).change();
        $('#EditUserModal').modal('show');
    }
    const Update = () => {
        var user_id = $('#UserId').val();
        var fullname = $('#Fullname').val();
        var email = $('#Email').val();
        var phone = $('#Phone').val();
        var user_type = $('#UserType').val();
        if(user_id && fullname && email && phone && user_type){
            $.ajax({
                type: "POST",
                url: "../api/v1/user/"+user_id,
                data: {
                    fullname: fullname,
                    email: email,
                    phone: phone,
                    user_type: user_type
                },
            }).done(function(res){
                Notiflix.Notify.success(res.message);
                setTimeout(function() {
                    window.location.reload();
                }, 1300);
            }).fail(function(res){
                Notiflix.Block.remove('#NewCustomerForm');
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
                    $('#EditUserModalAlertContent').html(string);
                    $('#EditUserModalAlert').removeClass('hide');
                    $('#EditUserModalAlert').addClass('show');
                    $('#Step2').removeAttr('disabled');
            });
        }else{
            Notiflix.Report.failure(
            'Lỗi',
            'Vui lòng không để trống dữ liệu',
            'Đã hiểu',
            );
        }
    }
</script>

@endsection