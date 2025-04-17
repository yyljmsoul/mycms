@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" lay-verify="required" lay-reqtext="请输入名称"
                       placeholder="请输入名称" value="{{$data->name}}">
                <tip>填写名称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">URL</label>
            <div class="col-sm-10">
                <input type="text" name="url" class="form-control" lay-verify="required" lay-reqtext="请输入URL"
                       placeholder="请输入URL" value="{{$data->url}}">
                <tip>填写URL。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">打开方式</label>
            <div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="target1"
                           name="target" @if($data->target == '_blank') checked @endif
                           value="_blank">
                    <label class="form-check-label" for="target1">
                        _blank
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="target0"
                           name="target" @if($data->target == '_self') checked @endif
                           value="_self">
                    <label class="form-check-label" for="target0">
                        _self
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">排序</label>
            <div class="col-sm-10">
                <input type="number" name="sort" class="form-control" lay-verify="required" lay-reqtext="请输入排序"
                       placeholder="请输入排序" value="{{$data->sort}}">
                <tip>填写排序。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$data->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
