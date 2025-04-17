@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">配置标识</label>
            <div class="col-sm-10">
                <input type="text" name="cfg_key" class="form-control" placeholder="请输入配置标识" value="">
                <tip>填写配置标识。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">配置值</label>
            <div class="col-sm-10">
                <textarea name="cfg_val" class="form-control"></textarea>
                <tip>填写配置值。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">配置分组</label>
            <div class="col-sm-10">
                <input type="text" name="cfg_group" class="form-control" placeholder="请输入配置分组" value="">
                <tip>填写配置分组。</tip>
            </div>
        </div>


        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
