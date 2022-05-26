@extends('layouts.manager')
@section('title', 'Tạo khảo sát')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Tạo khảo sát</h4>

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
                        <h4 class="card-title">Mẫu khảo sát</h4>
                        <p class="card-title-desc">
                            <strong>Hướng dẫn</strong><br>
                            Bước 1: Nhập thông tin khách hàng<br>
                            Bước 2: Chọn dịch vụ cần lấy đánh giá của khách hàng<br>
                            Bước 3: Lấy khảo sát từ khách hàng
                        </p>
                    </div>
                    <div class="card-body p-4">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card" id="InformationCheck">
                                    <div class="card-header">
                                        <h4 class="card-title">Thông tin khách hàng</h4>
                                    </div>
                                    <div class="card-body">
                                        <label for="example-text-input" class="form-label">Số điện thoại khách hàng: </label>
                                        <div class="input-group mb-3">
                                            <input class="form-control" type="number" placeholder="Nhập số điện thoại khách hàng" id="CustomerPhone">
                                            <div class="input-group-append">
                                                <button id="CustomerPhoneCheckBtn" class="btn btn-primary" onclick="CustomerPhoneCheck()">Kiểm tra</button>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-none" id="CustomerNameField">
                                            <label for="example-search-input" class="form-label">Họ & tên: </label>
                                            <input class="form-control" type="text" disabled id="CustomerName">
                                        </div>
                                        <div class="mb-3 d-none" id="CustomerAddressField">
                                            <label for="example-email-input" class="form-label">Địa chỉ: </label>
                                            <input class="form-control" type="text" disabled id="CustomerAddress">
                                        </div>
                                        <div class="mb-3 d-none" id="CustomerIDField">
                                            <label for="example-email-input" class="form-label">ID: </label>
                                            <input class="form-control" type="number" disabled id="CustomerID">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button id="Step2" type="button" class="btn btn-primary" disabled>Chọn biểu mẫu <i class=" bx bx-right-arrow-alt font-size-16 align-middle me-2"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="card border border-primary">
                                        <div class="card-header bg-transparent border-primary">
                                            <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Hướng dẫn bước 1</h5>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Nhập số điện thoại khách hàng</h5>
                                            <p class="card-text">
                                                <ul>
                                                    <li>Nhập số điện thoại khách hàng</li>
                                                    <li>Trường hợp khách hàng đã có thông tin trên hệ thống, hãy kiểm tra và sang bước chọn dịch vụ cần khảo sát</li>
                                                    <li>Trường hợp khách hàng chưa có thông tin, hãy tạo thông tin cho khách và tiếp tục bước 2</li> 
                                                </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <!-- Start row -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card" id="SurveySelectFrom">
                                        <div class="card-header">
                                            <h4 class="card-title">Chọn biểu mẫu khảo sát</h4>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="default-input">Chọn dịch vụ cần khảo sát</label>
                                                    <select class="form-select" name="ServiceID" id="ServiceID">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button id="Step3" type="button" class="btn btn-primary" disabled>Làm khảo sát <i class=" bx bx-right-arrow-alt font-size-16 align-middle me-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-6">
                                    <div class="card border border-success">
                                        <div class="card-header bg-transparent border-success">
                                            <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Hướng dẫn bước 2</h5>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Chọn dịch vụ cần khảo sát</h5>
                                            <p class="card-text">
                                                <ul>
                                                    <li>Chọn dịch vụ cần lấy đánh giá từ khách hàng</li>
                                                    <li>Chọn tiếp tục</li>
                                                </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- End row -->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4" id="SurveyTitle"></h4>
                                            <div class="row">
                                                <div id="Questions">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button id="finish" type="button" class="btn btn-success">Hoàn thành<i class=" bx bx-right-arrow-alt font-size-16 align-middle me-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- container-fluid -->
                    </div>
                </div>
            <!-- Scrollable modal -->
            <div class="modal fade" id="NewCustomerModal" tabindex="-1" aria-labelledby="NewCustomerModalArea" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content" id="NewCustomerForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="NewCustomerModalTitle">Thêm khách hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade hide" id="NewCustomerModalAlert" role="alert">
                                    <i class="mdi mdi-block-helper label-icon"></i>
                                    <div id="NewCustomerModalAlertContent"></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label for="NewCustomerName" class="form-label">Họ và tên</label>
                                    <input class="form-control" type="text" placeholder="Họ và tên khách hàng" id="NewCustomerName">
                                </div>
                                <div class="mb-3">
                                    <label for="NewCustomerPhone" class="form-label">Số điện thoại</label>
                                    <input class="form-control" type="number" placeholder="Nhập số điện thoại khách hàng" id="NewCustomerPhone">
                                </div>
                                <div class="mb-3">
                                    <label for="NewCustomerAddress" class="form-label">Địa chỉ</label>
                                    <input class="form-control" type="text" placeholder="Nhập địa chỉ khách hàng" id="NewCustomerAddress">
                                </div>   
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary" onclick="AddNewCustomer()">Thêm</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            </div>
@endsection()

@section('scripts')
    <script>
        var QuestionsId = [];
        // Kiểm tra số điện thoại đã tồn tại trên hệ thống chưa
        const CustomerPhoneCheck = () => {
            let PhoneNumer = $('#CustomerPhone').val();
            if(PhoneNumer){
                Notiflix.Block.dots('#InformationCheck');
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{route('api.v1.customerCheck')}}",
                        data: {phone: PhoneNumer},
                        dataType: "json",
                    }).done(function(res){
                        // Xoá blocking
                        Notiflix.Block.remove('#InformationCheck');
                        Notiflix.Notify.success(res.message);
                        // Nếu API trả về giá trị là null thì mở modal tạo mới khách hàng.
                        if(res.data == null){
                            Notiflix.Confirm.show(
                                'Thông báo',
                                'Số điện thoại này chưa tồn tại trên hệ thống',
                                'Tạo mới',
                                'Huỷ',
                                function AddNew() {
                                    $('#NewCustomerPhone').val(PhoneNumer);
                                    // Xoá dữ liệu cũ trong Form tạo khách hàng
                                    $('#NewCustomerName').val('');
                                    $('#NewCustomerAddress').val('');
                                    // Ẩn thông báo lỗi
                                    $('#NewCustomerModalAlert').removeClass('show');
                                    $('#Step2').attr('disabled');
                                    $('#NewCustomerModalAlert').addClass('hide');
                                    $('#NewCustomerModal').modal('show');
                                }
                            );
                             // Xoá dữ liệu và ẩn form
                            $('#CustomerName').val(null);
                            $('#CustomerAddress').val(null)
                            $('#CustomerID').val(null)
                            $('#CustomerNameField').addClass('d-none');
                            $('#CustomerAddressField').addClass('d-none');
                            $('#Step2').attr('disabled');
                        }else{
                            // Nếu trả về dữ liệu khách hàng
                            // Hiển thị thông tin khách hàng
                            $('#CustomerName').val(res.data.fullname);
                            $('#CustomerAddress').val(res.data.address)
                            $('#CustomerID').val(res.data.customer_id)
                            $('#CustomerNameField').removeClass('d-none');
                            $('#CustomerAddressField').removeClass('d-none');
                            $('#Step2').removeAttr('disabled');

                        }
                    }).fail(function(res){
                        // Xoá blocking
                        Notiflix.Block.remove('#InformationCheck');
                        var msg = JSON.parse(res.responseText);
                        msg = msg.message;
                        Notiflix.Report.failure(
                        'Lỗi',
                        msg,
                        'Đã hiểu'
                        );
                        // Xoá dữ liệu và ẩn form
                        $('#CustomerName').val(null);
                        $('#CustomerAddress').val(null)
                        $('#CustomerID').val(null)
                        $('#CustomerNameField').addClass('d-none');
                        $('#CustomerAddressField').addClass('d-none');
                        $('#Step2').removeAttr('disabled');
                    });
            }else{
                Notiflix.Report.failure(
                    'Lỗi',
                    'Bạn chưa nhập số điện thoại',
                    'Đã hiểu'
                );
            }
        }

        // Post dữ liệu khách hàng mới
        const AddNewCustomer = () => {
            let PhoneNumer = $('#NewCustomerPhone').val();
            let Fullname = $('#NewCustomerName').val();
            let Address = $('#NewCustomerAddress').val();

            // Validate not null
            if(PhoneNumer && Fullname && Address){
                Notiflix.Block.dots('#NewCustomerForm');
                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                $.ajax({
                    type: "POST",
                    url: "{{url('api/v1/customer')}}",
                    data: {
                        phone: PhoneNumer,
                        fullname: Fullname,
                        address: Address
                    },
                    dataType: "json",
                }).done(function(res){
                    Notiflix.Block.remove('#NewCustomerForm');
                    Notiflix.Notify.success(res.message);
                    // Nhập số điện thoại và tiến hành làm khảo sát
                    $('#CustomerPhone').val(res.data['phone']);
                    $('#CustomerName').val(res.data.fullname);
                    $('#CustomerAddress').val(res.data.address)
                    $('#CustomerID').val(res.data.customer_id)
                    $('#CustomerNameField').removeClass('d-none');
                    $('#CustomerAddressField').removeClass('d-none');
                    $('#Step2').removeAttr('disabled');

                    // Disable form check sđt
                    // $('#CustomerPhone').attr('disabled', '');
                    // $('#CustomerPhoneCheckBtn').attr('disabled', '');

                    // Ẩn modal
                    $('#NewCustomerModal').modal('hide');

                }).fail(function(res){
                    Notiflix.Block.remove('#NewCustomerForm');
                    var messages = JSON.parse(res.responseText);
                    // Lấy các trường lỗi do server trả về
                    messages = messages.data;
                    // Convert dữ liệu sang mảng
                    messages = Object.values(messages)
                    // console.log(messages);
                    var string = '';
                    messages.map(function(item){
                        string += item[0]+'<br>';
                        // if(count(item) > 1){
                        //     item.map(function(i){
                        //         string += i;
                        //     })
                        // }
                    })
                    // console.log(string);
                    $('#NewCustomerModalAlertContent').html(string);
                    $('#NewCustomerModalAlert').removeClass('hide');
                    $('#NewCustomerModalAlert').addClass('show');
                    $('#Step2').removeAttr('disabled');
                });
            }else{
                Notiflix.Report.failure(
                    'Lỗi',
                    'Tất cả dữ liệu là bắt buộc',
                    'Đã hiểu'
                );
            }
        }


        // Lấy danh sách biểu mẫu
        $("#Step2").click(function() {
            var string = '<option disabled selected>Bạn vui lòng chọn biểu mẫu</option>';
            $('#Step3').attr('disabled');
            Notiflix.Block.dots('#SurveySelectFrom');
            Notiflix.Block.dots('#InformationCheck');
            $.ajax({
                type: "GET",
                url: "{{route('api.v1.surveyList')}}",
                dataType: "json",
            }).done(function(res){
                var data = res.data;
                QuestionsId = data;

                data.map(item => {
                    string += `<option value="${item.service_id}">${item.name}</option>`;
                });
                $('select[name="ServiceID"]').html(string);
                Notiflix.Block.remove('#SurveySelectFrom');
                Notiflix.Block.remove('#InformationCheck');

                $("#Step2").get(0).scrollIntoView(); // Scroll tới trang chọn khảo sát

            }).fail(function(res){
                Notiflix.Block.remove('#SurveySelectFrom');
                Notiflix.Block.remove('#InformationCheck');

                Notiflix.Report.failure(
                'Lỗi',
                'Có lỗi trong quá trình xử lý, bạn vui lòng thử lại sau',
                'Đã hiểu'
                );
            });
        });

        // Khi chọn biểu mẫu xoá attr disable button
        $('#ServiceID').on('change', function () {
            $('#Step3').removeAttr('disabled');
        });

        // Lấy dữ liệu form khảo sát
        $('#Step3').on('click', function () {
            let ServiceID = $('#ServiceID').val();

            // console.log(ServiceID);
            if(ServiceID){
            Notiflix.Block.dots('#SurveySelectFrom');
            $.ajax({
                type: "GET",
                url: "/api/v1/service/"+ServiceID,
                dataType: "json",
            }).done(function(res){
                Notiflix.Block.remove('#SurveySelectFrom');
                // Group by question id
                var QuestionList = res.data.questions.groupBy('question_id');
                QuestionsId = QuestionList;
                // console.log(QuestionList);
                var string = '';
                // Lặp QuestionList Obj
                Object.keys(QuestionList).forEach(function(key, index) {
                    var anwsers =`<h5 class="font-size-14 mb-4">${index+1}. ${QuestionList[key][0].question}</h5>`;
                    // console.log(QuestionList[key]);
                    for(i = 0; i < QuestionList[key].length; i++){
                        if(QuestionList[key][i].multiple == 0){

                            if(QuestionList[key][i].note_require == 0){
                                anwsers += `
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" value="${QuestionList[key][i].anwser_id}" type="radio" name="${QuestionList[key][i].question_id}" id="${QuestionList[key][i].anwser_id}">
                                            <label class="form-check-label" for="${QuestionList[key][i].anwser_id}">${QuestionList[key][i].name}</label>
                                        </div>`;
                            }else{
                                anwsers += 
                                    `<div class="form-check mb-3">
                                        <input class="form-check-input" value="${QuestionList[key][i].anwser_id}" type="radio" name="${QuestionList[key][i].question_id}" id="${QuestionList[key][i].anwser_id}" option="true">
                                        <label class="form-check-label" for="${QuestionList[key][i].anwser_id}">${QuestionList[key][i].name}</label>
                                    </div
                                    <div class="form-check mb-3">
                                        <label class="form-check-label" for="option-${QuestionList[key][i].anwser_id}">${QuestionList[key][i].option_question}</label>
                                        <textarea class="form-control" row="3" value="" type="text" name="option-${QuestionList[key][i].anwser_id}" id="option-${QuestionList[key][i].anwser_id}"></textarea>
                                    </div>`;
                            }

                        }else{
                            anwsers +=
                            `<div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="${QuestionList[key][i].anwser_id}" name="${QuestionList[key][i].question_id}" id="${QuestionList[key][i].anwser_id}">
                                <label class="form-check-label" for="${QuestionList[key][i].anwser_id}">${QuestionList[key][i].name}</label>
                            </div>`;
                        }
                    }
                    if(res.data.questions.length < 1){
                        anwsers += '<br>Hiện tại chưa có câu hỏi nào cho phiếu đánh giá giá này. Vui lòng liên hệ với quản lý của bạn.';
                    }
                    string += anwsers;
                });
                $('#SurveyTitle').html('Phiếu đánh giá về chất lượng dịch vụ '+res.data.service)
                $('#Questions').html(string);
                $("#Step3").get(0).scrollIntoView(); // Scroll tới trang chọn khảo sát



            }).fail(function(res){
                Notiflix.Block.dots('#SurveySelectFrom');

            });
            }else{
                Notiflix.Report.failure(
                    'Lỗi',
                    'Bạn chưa chọn bài mẫu khảo sát',
                    'Đã hiểu'
                );
            }
        });

        // Group by key
        Array.prototype.groupBy = function(k) {
            return this.reduce((acc, item) => ((acc[item[k]] = [...(acc[item[k]] || []), item]), acc),{});
        };


        // Xử lý dữ liệu gửi lên server
        $('#finish').on('click', function(){
            // Mảng anwser_id khách hàng chọn
            var ArrSelected = [];
            
            var CustomerID = $('#CustomerID').val();

            var OptionAnwser= new Object();
            // Mảng question_id & anwser_id khách chọn
            var data = [];
            // Push anwser_id khách hàng chọn vào mảng
            $(':radio:checked').each(function(){
                ArrSelected.push($(this).val());
                // alert($(this).val());
            });

            // Xử lý lấy câu hỏi tuỳ chọn của khách hàng
            $('input[option="true"]:checked').each(function(){            
                OptionAnwser[$(this).val()] = $('#option-'+$(this).val()).val();
            });

            // Xủ lý lấy đáp án loại câu hỏi multiple
            $("input[type=checkbox]:checked").each(function(){
                ArrSelected.push($(this).val());
                // alert($(this).val());
            });

            // console.log(ArrSelected);



            // Lặp qua mảng khách hàng chọn
            Object.keys(QuestionsId).forEach(function(key, index) {
                for(i = 0; i<QuestionsId[key].length; i++){
                    for(j = 0; j<ArrSelected.length; j++){
                        if(ArrSelected[j] == QuestionsId[key][i].anwser_id){
                            // console.log('Câu '+(index + 1)+' Có ID câu hỏi là: '+QuestionsId[key][i].question_id+' Khách chọn câu trả lời có ID là: '+ArrSelected[j]);
                            var temp = {};
                            temp['question_id'] = QuestionsId[key][i].question_id;
                            temp['anwser_id'] = Number(ArrSelected[j]);
                            temp['option_anwser'] = OptionAnwser[Number(ArrSelected[j])];
                            data.push(temp);
                        }
                    }
                }
            });
            // console.log(data)
            if(data.length == 0){
                Notiflix.Report.failure(
                    'Lỗi',
                    'Bạn chưa hoàn thành câu khảo sát nào',
                    'Đã hiểu'
                );
                exit();
            }
            if(CustomerID){
                Notiflix.Block.dots('body');
                $.ajax({
                    type: "POST",
                    url: "{{route('api.v1.surveySubmit')}}",
                    dataType: "json",
                    data: {
                        customer_id: CustomerID,
                        data: JSON.stringify(data),
                        service_id: $('#ServiceID').val()
                    }
                }).done(function(res){                
                    Notiflix.Block.remove('body');
                    $('#finish').attr('disabled', 'disabled');
                    Notiflix.Confirm.show(
                        'Thành công',
                        'Phiếu khảo sát của bạn đã được lưu lại thành công',
                        'Thêm phiếu mới',
                        'Chi tiết',
                        function reload(){
                            location.reload()
                        },
                        function detail(){
                            window.location.replace("/manager/survey/"+res.data.survey_id);
                        }
                    )
                }).fail(function(res){
                    Notiflix.Block.remove('body');
                    Notiflix.Report.failure(
                        'Lỗi',
                        'Có lỗi xảy ra. Bạn vui lòng báo cho admin nhé.',
                        'Đã hiểu'
                    )
                })
            }else{
                Notiflix.Report.failure(
                    'Lỗi',
                    'Khách hàng này không hợp lệ, vui lòng kiểm tra lại thông tin',
                    'Đã hiểu'
                );
            }
        });
    </script>
@endsection()