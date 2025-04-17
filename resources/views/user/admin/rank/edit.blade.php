@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">等级名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control"
                       placeholder="请输入等级名称" value="{{$rank->name}}">
                <tip>填写等级名称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">等级编码</label>
            <div class="col-sm-10">
                <input type="text" name="number" class="form-control" value="{{$rank->number}}">
                <tip>越小越靠前</tip>
            </div>
        </div>

        <div class="row mb-3 layui-form-text">
            <label class="col-sm-2 col-form-label text-end-cms">备注信息</label>
            <div class="col-sm-10">
                <textarea name="description" class="form-control"
                          placeholder="请输入备注信息">{{$rank->description}}</textarea>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$rank->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
