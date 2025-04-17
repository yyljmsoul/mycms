@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms required">分类</label>
            <div class="col-sm-10">
                <select class="form-select" name="category_id" id="category_id">
                    <option value="0">请选择分类</option>
                    @foreach($data['categories'] as $item)
                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">分组名称</label>
			<div class="col-sm-10">
				<input type="text" name="name"  class="form-control" placeholder="请输入分组名称" value="">
				<tip>填写分组名称。</tip>
			</div>
		</div>

		<div class="row mb-3">
			<label class="col-sm-2 col-form-label text-end-cms">排序</label>
			<div class="col-sm-10">
				<input type="text" name="sort"  class="form-control" placeholder="请输入排序" value="0">
				<tip>填写排序。</tip>
			</div>
		</div>



        <div class="hr-line"></div>
        <div class="layui-form-item text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
