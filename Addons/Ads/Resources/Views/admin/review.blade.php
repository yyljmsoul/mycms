@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">
        <div class="row mb-3">
            <div class="col-sm-10">
                {!! $ad->content !!}
            </div>
        </div>
    </form>
@endsection
