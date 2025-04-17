@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <input type="hidden" name="mp_id" class="form-control" placeholder="请输入公众号"
               value="{{request()->route()->parameter('id')}}">

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">模式</label>
			<div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="type_subscribe" name="type"
                           value="subscribe">
                    <label class="form-check-label" for="type_subscribe">
                        关注后回复
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="type_accurate_match" name="type"
                           value="accurate_match">
                    <label class="form-check-label" for="type_accurate_match">
                        精准匹配
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="type_fuzzy_match" name="type"
                           value="fuzzy_match">
                    <label class="form-check-label" for="type_fuzzy_match">
                        模糊匹配
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="not_match" name="type"
                           value="not_match">
                    <label class="form-check-label" for="not_match">
                        无匹配时回复
                    </label>
                </div>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">关键词</label>
			<div class="col-sm-10">
				<input type="text" name="keyword"  class="form-control" placeholder="请输入关键词" value="">
				<tip>填写关键词(模式为关注后回复时不需要填写)。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">回复类型</label>
			<div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="reply_type_content" name="reply_type"
                           value="content">
                    <label class="form-check-label" for="reply_type_content">
                        文本
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="reply_type_image" name="reply_type"
                           value="image">
                    <label class="form-check-label" for="reply_type_image">
                        图片
                    </label>
                </div>
			</div>
		</div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">回复内容</label>
            <div class="col-sm-10">
                <textarea name="reply_content" id="reply_content"  class="form-control" placeholder="请输入回复内容"></textarea>
                <tip>填写回复内容。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">回复图片</label>
            <div class="col-sm-10 cms-upload">
                <input name="reply_image" type="hidden" class="form-control" value="">
                <input type="file" class="form-control" data-name="reply_image" cms-upload data-max-size="2"
                       data-upload-exts=".ico,.png,.jpg,.jpeg">
                <div class="my-1 upload-thumb">
                </div>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
