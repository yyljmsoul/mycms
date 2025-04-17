@extends("layouts.common")
<body class="layui-layout-body layuimini-all">

<div class="layuimini-container">
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">菜单显示</label>
            <div class="col-sm-10">
                <input type="radio" class="form-check-input" name="menu_show_type"
                       @if(isset($config['menu_show_type']) && $config['menu_show_type'] == 1 ) checked @endif value="1"
                       title="模块模式">
                <input type="radio" class="form-check-input" name="menu_show_type"
                       @if(!isset($config['menu_show_type']) || $config['menu_show_type'] == 0 ) checked
                       @endif value="0" title="默认模式">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">默认展开</label>
            <div class="col-sm-10">
                <input type="radio" class="form-check-input" name="menu_default_open"
                       @if(isset($config['menu_default_open']) && $config['menu_default_open'] == 1 ) checked
                       @endif value="1" title="是">
                <input type="radio" class="form-check-input" name="menu_default_open"
                       @if(!isset($config['menu_default_open']) || $config['menu_default_open'] == 0 ) checked
                       @endif value="0" title="否">
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
