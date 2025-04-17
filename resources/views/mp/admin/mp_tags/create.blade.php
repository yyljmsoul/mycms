@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">标签名称</label>
			<div class="col-sm-10">
				<input type="text" name="name"  class="form-control" placeholder="请输入标签名称" value="">
				<tip>填写标签名称。</tip>
			</div>
		</div>

        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
