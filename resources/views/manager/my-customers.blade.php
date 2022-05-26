@extends('layouts.manager')
@section('title', 'Khách hàng đã thêm')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Khách hàng đã thêm</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Khách hàng</li>
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
                        <h4 class="card-title">Danh sách khách hàng</h4>
                    </div>
                    <div class="card-body">

                        <table id="MyCustomers" class="table table-bordered
                            dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ & tên</th>
                                    <th>Điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Ngày tạo</th>
                                    <th></th>
                                </tr>
                            </thead>


                            <tbody>
                                @if(count($Customers) == 0)
                                    <tr>
                                        <td colspan="5">
                                        Bạn hiện chưa tạo khách hàng nào
                                        <td>
                                    </tr>
                                @endif
                                @foreach($Customers as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->fullname}}</td>
                                    <td>0{{$item->phone}}</td>
                                    <td>{{$item->address}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->created_at)}}</td>
                                    <td>
                                        <a class="btn btn-warning" onclick="OpenUpdateForm('{{$item->customer_id}}', '{{$item->fullname}}', '{{$item->phone}}', '{{$item->address}}')">Cập nhật</a>
                                        <a class="btn btn-danger" onclick="CustomerDelete('{{$item->customer_id}}', '{{$item->fullname}}')">Xoá</a>
                                    </td>
                                </tr>
                                @endforeach()
                            </tbody>
                        </table>
                        {{ $Customers->render() }}
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        <!-- Scrollable modal -->
    <div class="modal fade" id="CustomerUpdateModal" tabindex="-1" role="dialog" aria-labelledby="CustomerUpdateModalArea" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" id="CustomerUpdateForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="CustomerUpdateModalTitle">Cập nhật khách hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="CustomerUpdateAlert" role="alert">
                            <i class="mdi mdi-block-helper label-icon"></i>
                            <div id="CustomerUpdateAlertContent"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                        <div class="mb-3 d-none">
                            <label for="Fullname" class="form-label"><i class="fa fa-id-card" aria-hidden="true"></i></label>
                            <input class="form-control" type="text" placeholder="Họ và tên khách hàng" id="CustomerID">
                        </div>
                        <div class="mb-3">
                            <label for="Fullname" class="form-label">Họ và tên</label>
                            <input class="form-control" type="text" placeholder="Họ và tên khách hàng" id="Fullname">
                        </div>
                        <div class="mb-3">
                            <label for="Phone" class="form-label">Số điện thoại</label>
                            <input class="form-control" type="number" placeholder="Nhập số điện thoại khách hàng" id="Phone">
                        </div>
                        <div class="mb-3">
                            <label for="Address" class="form-label">Địa chỉ</label>
                            <input class="form-control" type="text" placeholder="Nhập địa chỉ khách hàng" id="Address">
                        </div>   
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="CustomerUpdate()">Cập nhật</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div> <!-- container-fluid -->
</div>

@endsection

@section('scripts')
    <script type="text/javascript" src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        const OpenUpdateForm = (customer_id, fullname, phone, address) => {
            $('#CustomerID').val(customer_id);
            $('#Fullname').val(fullname);
            $('#Phone').val(phone);
            $('#Address').val(address);
            $('#CustomerUpdateModal').modal('show');
        }

        const CustomerUpdate = () => {
            Notiflix.Block.dots('#CustomerUpdateForm');
            var customer_id = $('#CustomerID').val();
            var fullname = $('#Fullname').val();
            var phone = $('#Phone').val();
            var address = $('#Address').val();
            $.ajax({
                url: "../api/v1/customer/"+customer_id,
                dataType: 'json',
                method: 'POST',
                data: {
                    customer_id: customer_id,
                    fullname: fullname,
                    phone: phone,
                    address: address
                }
            }).done( function(res){
                Notiflix.Block.remove('#CustomerUpdateForm');
                Notiflix.Notify.success(res.message)

                setTimeout(() => {
                    window.location.reload();
                }, 1300);

            }).fail( function(res){
                Notiflix.Block.remove('#CustomerUpdateForm');
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
                    $('#CustomerUpdateAlertContent').html(string);
                    $('#CustomerUpdateAlert').removeClass('hide');
                    $('#CustomerUpdateAlert').addClass('show');
            });
        }

        const CustomerDelete = (customer_id, fullname) => {
            Notiflix.Confirm.show(
                'Quan trọng',
                'Bạn muốn xoá người dùng '+fullname+'?',
                'Xoá',
                'Huỷ bỏ',
                function aFunc(){
                    $.ajax({
                        url: "../api/v1/customer/"+customer_id,
                        dataType: 'json',
                        method: 'DELETE'
                    }).done( function(res){
                        Notiflix.Notify.success(res.messages);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1300);
                    });
                }
            );
        }

    //     $(document).ready( function () {
    //         $('#MyCustomers').DataTable({
    //             "processing": true,
    //             "severSide": true,
    //             "ajax":{
    //                 "url": '../api/v1/customerTest',
    //                 "method": 'GET',
    //                 "type": 'json'
    //             }
    //         });
    // } );
    </script>
@endsection