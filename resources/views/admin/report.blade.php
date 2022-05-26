@extends('layouts.admin')
@section('title', 'Quản lý dịch vụ')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Thống kê</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Quản lý dịch vụ</a></li>
                            <li class="breadcrumb-item active">Thống kê</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                @if(count($Questions) == 0)
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Báo cáo</h4>
                    </div>
                    <div class="card-body">
                        <h4>Dịch vụ này chưa có báo cáo chi tiết do bạn chưa thêm câu hỏi nào.</h4>
                    </div>
                </div>
                @endif
                @foreach ($Questions as $i=>$item)
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">{{($i+1)}}. {{$item->question}}</h4>
                            <label for="daterange_{{$item->question_id}}">Chọn theo ngày</small>
                            <input type="text" class="form-control" id="daterange_{{$item->question_id}}" value="" />
                        </div>
                        <div class="card-body">
                            <div id="chart-{{$item->question_id}}"></div>
                        </div>
                    </div>
                @endforeach
                <!-- end card -->
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
@endsection

@section('scripts')

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.16.0/d3.min.js" integrity="sha512-FHsFVKQ/T1KWJDGSbrUhTJyS1ph3eRrxI228ND0EGaEp6v4a/vGwPWd3Dtd/+9cI7ccofZvl/wulICEurHN1pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js" integrity="sha512-+IpCthlNahOuERYUSnKFjzjdKXIbJ/7Dd6xvUp+7bEw0Jp2dg6tluyxLs+zq9BMzZgrLv8886T4cBSqnKiVgUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
@foreach ($Questions as $i=>$item)

    var data_{{$item->question_id}} = <?= json_encode($item->analytics); ?>;
    var chart_{{$item->question_id}} = c3.generate({
        bindto: '#chart-{{$item->question_id}}',
        data: {
            // iris data from R
            columns: data_{{$item->question_id}},
            type : 'pie',
            // onclick: function (d, i) { console.log("onclick", d, i); },
            // onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            // onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        pie: {
        label: {
                format: function (value, ratio, id) {
                    return value+' lượt';
                }
            }
        }
    });



    $(function() {
        $('input[id="daterange_{{$item->question_id}}"]').daterangepicker({
            opens: 'left',
            maxDate: new Date()
        },function(start, end, label) {
                $.ajax({
                    url: '{{route("api.v1.question.getQuestionReport")}}/{{$item->question_id}}/report',
                    type: 'POST',
                    data: {
                        start: start.format('MM-DD-YYYY'), 
                        end: end.format('MM-DD-YYYY'),
                    }
                }).done(function(res){
                    setTimeout(function() {
                        chart_{{$item->question_id}}.load({
                            columns: res.data
                        });
                    })
                })
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    });
@endforeach()
    // setTimeout(function () {
    //     chart.load({
    //         columns: [
    //             ['data3', 130, -150, 200, 300, -200, 100]
    //         ]
    //     });
    // }, 1000);
</script>
@endsection()
