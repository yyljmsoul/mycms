@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">项目名称</label>
			<div class="col-sm-10">
				<input type="text" name="name"  class="form-control" placeholder="请输入项目名称" value="{{$data->name}}">
				<tip>填写项目名称。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">项目key</label>
			<div class="col-sm-10">
				<input type="text" name="ident"  class="form-control" placeholder="请输入项目key" value="{{$data->ident}}">
				<tip>填写项目key。</tip>
			</div>
		</div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">项目描述</label>
            <div class="col-sm-10">
                <textarea type="text" name="description"  class="form-control" placeholder="请输入项目描述">{{$data->description}}</textarea>
                <tip>填写项目描述。</tip>
            </div>
        </div>


        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
