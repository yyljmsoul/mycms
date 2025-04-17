@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">微信号</label>
            <div class="col-sm-10">
                <input type="text" name="wx" class="form-control" placeholder="请输入微信号" value="">
                <tip>输入需要预览的微信号。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
