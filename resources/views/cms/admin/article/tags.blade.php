@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms required">标题</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control"
                       placeholder="请输入标题" value="{{$article->title}}">
                <tip>填写标题。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">标签</label>
            <div class="col-sm-10">
                <input type="text" name="tags" class="form-control" placeholder="请输入标签" value="{{$tags}}">
                <tip>多个标签请用英文逗号（,）分开。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$article->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
