<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{$breadcrumbs[count($breadcrumbs - 1)]->title}}</h4>
            @if($breadcrumbs)
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @foreach ($breadcrumbs as $breadcrumb)
                    @if (!$breadcrumb->last)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                    @else()
                    <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
                    @endif()
                </ol>
            </div>

        </div>
    </div>
</div>