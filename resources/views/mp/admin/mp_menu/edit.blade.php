@extends("layouts.common")
@section('page-content-wrapper')

    <style>
        .type-item {
            display: none;
        }
    </style>

    <form id="app-form">

        <input type="hidden" name="mp_id"  class="form-control" placeholder="请输入公众号" value="{{$data->mp_id}}">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">上级菜单</label>
            <div class="col-sm-10">
                <select class="form-select" name="pid" id="pid">
                    <option value="0">顶级菜单</option>
                    @foreach(mp_menus($data->mp_id) as $m)
                        <option value="{{$m->id}}" {{$data->pid == $m->id ? 'selected' : ''}}>{{$m->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">菜单名称</label>
			<div class="col-sm-10">
				<input type="text" name="name"  class="form-control" placeholder="请输入菜单名称" value="{{$data->name}}">
				<tip>填写菜单名称。</tip>
			</div>
		</div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">菜单类型</label>
            <div class="col-sm-10">
                <select class="form-select" name="type" id="type">
                    <option value="view" {{$data->type == 'view' ? 'selected' : ''}}>跳转页面</option>
                    <option value="click" {{$data->type == 'click' ? 'selected' : ''}}>回复内容</option>
                    <option value="miniprogram" {{$data->type == 'miniprogram' ? 'selected' : ''}}>打开小程序</option>
                </select>
            </div>
        </div>

        <div class="row mb-3 type-item type-item-view" {!! $data->type == 'view' ? 'style="display: flex"' : '' !!}>
            <label class="col-sm-2 col-form-label text-end-cms">链接</label>
            <div class="col-sm-10">
                <input type="text" name="url"  class="form-control" placeholder="请输入链接" value="{{$data->url}}">
                <tip>填写链接。</tip>
            </div>
        </div>

        <div class="row mb-3 type-item type-item-miniprogram" {!! $data->type == 'miniprogram' ? 'style="display: flex"' : '' !!}>
            <label class="col-sm-2 col-form-label text-end-cms">appid</label>
            <div class="col-sm-10">
                <input type="text" name="appid"  class="form-control" placeholder="请输入appid" value="{{$data->appid}}">
                <tip>填写appid。</tip>
            </div>
        </div>

        <div class="row mb-3 type-item type-item-miniprogram" {!! $data->type == 'miniprogram' ? 'style="display: flex"' : '' !!}>
            <label class="col-sm-2 col-form-label text-end-cms">小程序地址</label>
            <div class="col-sm-10">
                <input type="text" name="path"  class="form-control" placeholder="请输入小程序地址" value="{{$data->path}}">
                <tip>填写小程序地址。</tip>
            </div>
        </div>

        <div class="row mb-3 type-item type-item-click" {!! $data->type == 'click' ? 'style="display: flex"' : '' !!}>
            <label class="col-sm-2 col-form-label text-end-cms">回复内容</label>
            <div class="col-sm-10">
                <textarea name="event_text"
                          class="form-control">{{$data->event_text}}</textarea>
            </div>
        </div>

        <div class="row mb-3 type-item type-item-click" {!! $data->type == 'click' ? 'style="display: flex"' : '' !!}>
            <label class="col-sm-2 col-form-label text-end-cms">回复图片</label>
            <div class="col-sm-10 cms-upload">
                <input name="event_image" type="hidden" class="form-control" value="{{$data->event_image}}">
                <input type="file" class="form-control" data-name="event_image" cms-upload data-max-size="2"
                       data-upload-exts=".ico,.png,.jpg,.jpeg">
                <div class="my-1 upload-thumb">
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">排序</label>
            <div class="col-sm-10">
                <input type="text" name="sort"  class="form-control" placeholder="请输入排序" value="{{$data->sort}}">
                <tip>填写排序(大数排在前面)。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection

@section('extend-javascript')
    <script>
        myAdmin.listen();

        $(document).ready(function () {
            $('#type').change(function () {
                $('.type-item').hide();
                $('.type-item-' + $(this).val()).css('display', 'flex');
            });
        });
    </script>
@endsection
