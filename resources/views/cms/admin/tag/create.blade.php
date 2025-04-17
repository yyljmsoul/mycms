@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms required">名称</label>
            <div class="col-sm-10">
                <input type="text" name="tag_name" class="form-control"
                       placeholder="请输入名称" value="">
                <tip>填写名称。</tip>
            </div>
        </div>

        @if(app('system')->addonEnabled('UrlFormat'))
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label text-end-cms">别名</label>
                <div class="col-sm-10">
                    <input type="text" name="alias" class="form-control" placeholder="请输入别名"
                           value="">
                    <tip>用于URL优化。</tip>
                </div>
            </div>
        @endif

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">描述</label>
            <div class="col-sm-10">
                <textarea name="description" class="form-control" placeholder="请输入描述"></textarea>
                <tip>填写描述。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
