@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">登录账户</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" readonly value="{{$admin->name}}">
                <tip>填写登录账户。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">角色权限</label>
            <div class="col-sm-10">
                @foreach ($roles as $role)
                    <div class="form-check col-md-2">
                        <input type="radio" class="form-check-input" @if($role->id == $admin->role_id) checked
                               @endif id="role_id_{{$role->id}}" name="role_id" value="{{$role->id}}">
                        <label class="form-check-label" for="role_id_{{$role->id}}">
                            {{$role->role_name}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row mb-3 layui-form-text">
            <label class="col-sm-2 col-form-label text-end-cms">备注信息</label>
            <div class="col-sm-10">
                <textarea name="remark" class="form-control" placeholder="请输入备注信息">{{$admin->remark}}</textarea>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$admin->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
