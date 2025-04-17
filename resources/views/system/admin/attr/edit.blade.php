@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">分类</label>
            <div class="col-sm-10">
                <select class="form-select" name="type">
                    <option value="cms" @if($data->type == 'cms') selected @endif>CMS</option>
                    <option value="shop" @if($data->type == 'shop') selected @endif>SHOP</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">属性标识</label>
            <div class="col-sm-10">
                <input type="text" name="ident" class="form-control"
                       placeholder="请输入属性标识" value="{{$data->ident}}">
                <tip>填写属性标识。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">属性名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="请输入属性名称"
                       value="{{$data->name}}">
                <tip>填写属性名称。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$data->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
