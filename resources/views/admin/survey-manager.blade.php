@extends('layouts.admin')
@section('title', 'Quản lý khảo sát')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center
                    justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Tất cả khảo sát</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:
                                    void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Khảo sát của bạn</li>
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
                        <h4 class="card-title">Khảo sát của bạn</h4>
                        <p class="card-title-desc">DataTables has most features
                            enabled by
                            default, so all you need to do to use it with your
                            own tables is to call
                            the construction function: <code>$().DataTable();</code>.
                        </p>
                    </div>
                    <div class="card-body">

                        <table id="MySurveys" class="table table-bordered
                            dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Khách hàng</th>
                                    <th>Dịch vụ</th>
                                    <th>Ngày tạo</th>
                                    <th>Tuỳ chọn</th>
                                </tr>
                            </thead>


                            <tbody>
                                @if(count($Surveys) == 0)
                                    <tr>
                                        <td colspan="5">
                                        Bạn hiện chưa có phiếu khảo sát nào
                                        <td>
                                    </tr>
                                @endif
                                @foreach($Surveys as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->customer}}</td>
                                    <td>{{$item->service}}</td>
                                    <td>{{gmdate("H:i d/m/Y", $item->created_at)}}</td>
                                    <td><a href="survey/{{$item->survey_id}}" class="btn btn-primary">Chi tiết</a></td>
                                </tr>
                                @endforeach()
                            </tbody>
                        </table>
                        {{ $Surveys->links() }}
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script>

</script>

@endsection