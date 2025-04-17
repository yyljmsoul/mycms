@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">公众号</label>
			<div class="col-sm-10">
				<input type="text" name="mp_id"  class="form-control" placeholder="请输入公众号" value="">
				<tip>填写公众号。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">openid</label>
			<div class="col-sm-10">
				<input type="text" name="openid"  class="form-control" placeholder="请输入openid" value="">
				<tip>填写openid。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">unionid</label>
			<div class="col-sm-10">
				<input type="text" name="unionid"  class="form-control" placeholder="请输入unionid" value="">
				<tip>填写unionid。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">标签</label>
			<div class="col-sm-10">
				<input type="text" name="tagid_list"  class="form-control" placeholder="请输入标签" value="">
				<tip>填写标签。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">关注来源</label>
			<div class="col-sm-10">
				<input type="text" name="subscribe_scene"  class="form-control" placeholder="请输入关注来源" value="">
				<tip>填写关注来源。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">二维码</label>
			<div class="col-sm-10">
				<input type="text" name="qr_scene"  class="form-control" placeholder="请输入二维码" value="">
				<tip>填写二维码。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">关注时间</label>
			<div class="col-sm-10">
				<input type="text" name="subscribe_time"  class="form-control" placeholder="请输入关注时间" value="">
				<tip>填写关注时间。</tip>
			</div>
		</div>



        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
