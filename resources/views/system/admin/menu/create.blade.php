@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">上级菜单</label>
            <div class="col-sm-10">
                <select class="form-select" name="pid">
                    <option value="0">顶级菜单</option>
                    @foreach($menus as $menu)
                        <option value="{{$menu['id']}}">{{$menu['title']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">菜单名称</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control"
                       placeholder="请输入菜单名称" value="">
                <tip>填写菜单名称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">菜单链接</label>
            <div class="col-sm-10">
                <input type="text" id="href" name="url" class="form-control"
                       placeholder="请输入菜单链接" value="">
                <tip>填写菜单链接。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">图标类名</label>
            <div class="col-sm-10">
                <input type="text" id="icon" name="icon" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">打开方式</label>
            <div class="col-sm-10">
                @foreach(['_self','_blank'] as $vo)
                    <div class="form-check col-md-2">
                        <input type="radio" class="form-check-input" id="target_{{$vo}}" name="target" value="{{$vo}}">
                        <label class="form-check-label" for="target_{{$vo}}">
                            {{$vo}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">菜单排序</label>
            <div class="col-sm-10">
                <input type="number" name="sort" placeholder="请输入菜单排序" value="0"
                       class="form-control">
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
