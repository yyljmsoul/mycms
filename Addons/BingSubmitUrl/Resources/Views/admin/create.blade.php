@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">网址</label>
            <div class="col-sm-10">
                <textarea type="text" name="urls" class="form-control" placeholder="请输入网址"></textarea>
                <tip>每行一条URL, 优先提交该处网址, 如果该项有填写内容, 将不会提交日期网址内容</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">日期</label>
            <div class="col-sm-10">
                <input type="text" name="date" data-date="yyyy-MM-dd" data-date-type="date" class="form-control"
                       placeholder="请选择日期" value="">
                <tip>提交指定日期资源</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
