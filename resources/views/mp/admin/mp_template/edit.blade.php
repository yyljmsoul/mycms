@extends("layouts.common")
@section('page-content-wrapper')
    <style>
        .ds_type {
            display: none;
        }
    </style>
    <form id="app-form">

        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#base" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">基本信息</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#data-source" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">数据源</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="base" role="tabpanel">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="请输入名称"
                               value="{{$data->name}}">
                        <tip>填写名称。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" placeholder="请输入标题"
                               value="{{$data->title}}">
                        <tip>填写标题。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">备注</label>
                    <div class="col-sm-10">
                            <textarea name="description" id="description" class="form-control"
                                      placeholder="请输入备注">{{$data->description}}</textarea>
                        <tip>填写备注。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">内容</label>
                    <div class="col-sm-10">
                            <textarea name="content" id="content" class="editor"
                                      placeholder="请输入内容">{{$data->content}}</textarea>
                        <tip>填写内容。</tip>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="data-source" role="tabpanel">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">类型</label>
                    <div class="col-sm-10">
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="ds_type_json" name="ds_type"
                                   @if($data->ds_type == 'json') checked @endif
                                   value="json">
                            <label class="form-check-label" for="ds_type_json">
                                JSON数据
                            </label>
                        </div>
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="ds_type_db" name="ds_type"
                                   value="db" @if($data->ds_type == 'db') checked @endif>
                            <label class="form-check-label" for="ds_type_db">
                                连接数据库
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3 ds_type" @if($data->ds_type == 'json') style="display: block"
                     @endif id="json_type">
                    <label class="col-sm-2 col-form-label text-end-cms">JSON数据</label>
                    <div class="col-sm-10">
                            <textarea name="json_data" id="json_data" class="form-control"
                                      placeholder="请输入JSON数据">{{$data->json_data}}</textarea>
                        <tip>填写JSON数据。</tip>
                    </div>
                </div>

                <div class="ds_type" id="db_type" @if($data->ds_type == 'db') style="display: block" @endif>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">数据表</label>
                        <div class="col-sm-10">
                            <input type="text" name="db_table" class="form-control" placeholder="请输入数据表"
                                   value="{{$data->db_table}}">
                            <tip>填写数据表。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">过滤条件</label>
                        <div class="col-sm-10">
                                <textarea name="db_condition" class="form-control"
                                          placeholder="请输入过滤条件">{{$data->db_condition}}</textarea>
                            <tip>填写过滤条件。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">单次数量</label>
                        <div class="col-sm-10">
                            <input type="text" name="db_limit" class="form-control" placeholder="请输入单次数量"
                                   value="{{$data->db_limit}}">
                            <tip>填写单次数量，0为不限制。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">后置操作</label>
                        <div class="col-sm-10">
                                <textarea name="db_action" class="form-control"
                                          placeholder="请输入后置操作">{{$data->db_action}}</textarea>
                            <tip>填写后置操作。</tip>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
@section('extend-javascript')
    <script>
        myAdmin.listen();
        $('input[name="ds_type"]').change(function (){
            $('.ds_type').hide();
            $('#' + $(this).val() + '_type').show();
        });
    </script>
@endsection
