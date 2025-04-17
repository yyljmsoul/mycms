@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">角色名称</label>
            <div class="col-sm-10">
                <input type="text" name="role_name" class="form-control"
                       placeholder="请输入角色名称" value="{{$role->role_name}}">
                <tip>填写角色名称。</tip>
            </div>
        </div>

        <div class="row mb-3 layui-form-text">
            <label class="col-sm-2 col-form-label text-end-cms">角色说明</label>
            <div class="col-sm-10">
                <textarea name="role_desc" class="form-control"
                          placeholder="请输入角色说明">{{$role->role_desc}}</textarea>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$role->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
