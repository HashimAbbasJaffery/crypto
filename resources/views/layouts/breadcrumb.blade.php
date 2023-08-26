<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ env('APP_NAME') }}</a></li>
                    <li class="breadcrumb-item @if(!isset($title)) active @endif">@isset($title)<a
                            href="{{ route('home') }}">@endisset @lang('messages.Dashboard') @isset($title)</a>@endisset
                    </li>
                    @isset($title)
                        <li class="breadcrumb-item active">{{ $title }}</li>@endif
                </ol>
            </div>
            <h4 class="page-title">@isset($title) {{$title}} @else @lang('messages.Dashboard') @endisset</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
