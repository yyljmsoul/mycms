@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">标题</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" placeholder="请输入标题" value="{{$data->title}}">
                <tip>填写标题。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">作者</label>
            <div class="col-sm-10">
                <input type="text" name="author" class="form-control" placeholder="请输入作者"
                       value="{{$data->author}}">
                <tip>填写作者。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">缩略图</label>
            <div class="col-sm-10 cms-upload">
                <input name="thumb" type="hidden" class="form-control" placeholder="请上传缩略图"
                       value="{{$data->thumb}}">
                <input type="file" class="form-control" data-name="thumb" cms-upload data-max-size="2"
                       data-upload-exts=".ico,.png,.jpg,.jpeg">
                <div class="my-1 upload-thumb">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">摘要</label>
            <div class="col-sm-10">
                <textarea name="digest" class="form-control" placeholder="请输入摘要">{{$data->digest}}</textarea>
                <tip>填写摘要。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">内容</label>
            <div class="col-sm-10">
                <textarea name="content" id="content" class="editor"
                          placeholder="请输入内容">{{$data->content}}</textarea>
                <tip>填写内容。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">原文地址</label>
            <div class="col-sm-10">
                <input type="text" name="content_source_url" class="form-control" placeholder="请输入原文地址"
                       value="{{$data->content_source_url}}">
                <tip>填写原文地址。</tip>
            </div>
        </div>


        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
