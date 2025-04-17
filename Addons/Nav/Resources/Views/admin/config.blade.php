@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">设为首页</label>
            <div class="col-sm-10">
                <input type="checkbox" name="site_home_theme" lay-skin="primary" value="nav"
                       @if(isset($config['site_home_theme']) && $config['site_home_theme'] == 'nav') checked
                       @endif title="设为首页">
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
