@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">公众号</label>
			<div class="col-sm-10">
				<input type="text" name="mp_id"  class="form-control" placeholder="请输入公众号" value="{{$data->mp_id}}">
				<tip>填写公众号。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">素材地址</label>
			<div class="col-sm-10">
				<input type="text" name="url"  class="form-control" placeholder="请输入素材地址" value="{{$data->url}}">
				<tip>填写素材地址。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">素材ID</label>
			<div class="col-sm-10">
				<input type="text" name="media_id"  class="form-control" placeholder="请输入素材ID" value="{{$data->media_id}}">
				<tip>填写素材ID。</tip>
			</div>
		</div>



        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
