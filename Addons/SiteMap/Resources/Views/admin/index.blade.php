@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">网站地图</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" readonly value="{{url("/sitemap/sitemap.xml")}}">
                <tip>网站地图访问地址.</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">总生成地址</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{route('admin.addon.site_map.make')}}">
                <tip>可添加到服务器定时任务.</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">生成分类XML</label>
            <div class="col-sm-10">
                <input type="text" class="form-control"
                       value="{{route('admin.addon.site_map.makeIdent',['ident'=>'category'])}}">
                <tip>可以单独生成网站分类地图.</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">生成文章XML</label>
            <div class="col-sm-10">
                <input type="text" class="form-control"
                       value="{{route('admin.addon.site_map.makeIdent',['ident'=>'article'])}}">
                <tip>可以单独生成网站分类地图.</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">生成标签XML</label>
            <div class="col-sm-10">
                <input type="text" class="form-control"
                       value="{{route('admin.addon.site_map.makeIdent',['ident'=>'tag'])}}">
                <tip>可以单独生成网站标签地图.</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">生成商品XML</label>
            <div class="col-sm-10">
                <input type="text" class="form-control"
                       value="{{route('admin.addon.site_map.makeIdent',['ident'=>'goods'])}}">
                <tip>可以单独生成网站商品地图.</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">马上生成</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection

