@extends("layouts.common")
@section('page-content-wrapper')

    <style>
        .params::-webkit-scrollbar {
            width: 6px;
        }

        .params::-webkit-scrollbar-thumb {
            border-radius: 8px;
            background-color: #ddd;
        }
    </style>

    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">项目选择</label>
            <div class="col-sm-10">
                <select class="form-select" name="project_ident" id="project_ident">
                    <option value="">默认项目</option>
                    @foreach($data as $project)
                        <option value="{{$project['ident']}}">{{$project['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">接口名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" required class="form-control" placeholder="请输入接口名称" value="">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">接口地址</label>
            <div class="col-sm-10">
                <input type="text" name="path" required class="form-control" placeholder="请输入API接口地址" value="">
                <tip>填写API接口地址。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">API请求方法</label>
            <div class="col-sm-10">
                <select class="form-select" name="method" id="method">
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">数据源</label>
            <div class="col-sm-10">
                <select class="form-select" name="source_type" id="source_type">
                    <option value="table">数据表</option>
                    <option value="request">接口转发</option>
                    <option value="content">固定内容</option>
                    <option value="diy">自定义</option>
                </select>
                <tip>选择数据源。</tip>
            </div>
        </div>

        <div class="row mb-3 type-diy" style="display: none">
            <label class="col-sm-2 col-form-label text-end-cms">自定义接口</label>
            <div class="col-sm-10">
                <select class="form-select" name="handle" id="handle">
                    @foreach(apiDiyHandles() as $handle)
                        <option value="{{$handle}}">{{$handle}}</option>
                    @endforeach
                </select>
                <tip>选择自定义接口。</tip>
            </div>
        </div>

        <div class="row mb-3 type-table">
            <label class="col-sm-2 col-form-label text-end-cms">数据表</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-10">
                        <input type="text" name="table_name" class="form-control" placeholder="请输入数据表" value="">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="import" class="btn btn-primary waves-effect waves-light">导入表字段
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="row mb-3 type-table">
            <label class="col-sm-2 col-form-label text-end-cms">数据格式</label>
            <div class="col-sm-10">
                <select class="form-select" name="return_type" id="return_type">
                    <option value="list">列表</option>
                    <option value="object">对象</option>
                </select>
                <tip>选择数据格式。</tip>
            </div>
        </div>

        <div class="row mb-3 type-table">
            <label class="col-sm-2 col-form-label text-end-cms">响应字段</label>
            <div class="col-sm-10 ">
                <div class="table-responsive params" style="max-height: 280px;overflow-y: scroll;">
                    <table class="table table-striped mb-0">

                        <thead>
                        <tr>
                            <th><input class="form-check-input" type="checkbox" id="checkAllFields"></th>
                            <th>字段名</th>
                            <th>排序方式</th>
                            <th>关联表</th>
                        </tr>
                        </thead>
                        <tbody id="response_fields">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mb-3 count-field" style="display: none">
            <label class="col-sm-2 col-form-label text-end-cms">统计次数字段</label>
            <div class="col-sm-10">
                <input type="text" name="count_field" class="form-control" placeholder="请输入统计次数字段"
                       value="">
                <tip>填写统计次数字段。</tip>
            </div>
        </div>

        <div class="row mb-3 type-api" style="display: none">
            <label class="col-sm-2 col-form-label text-end-cms">转发地址</label>
            <div class="col-sm-10">
                <input type="text" name="request_url" class="form-control" placeholder="请输入转发地址"
                       value="">
                <tip>填写转发地址。</tip>
            </div>
        </div>

        <div class="row mb-3 type-content" style="display: none">
            <label class="col-sm-2 col-form-label text-end-cms">响应内容</label>
            <div class="col-sm-10">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <thead>
                        <tr>
                            <th>参数名</th>
                            <th>参数值</th>
                            <th>参数描述</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="content_name[]" class="form-control" placeholder="参数名"
                                       value=""></td>
                            <td><textarea name="content_value[]" class="form-control" placeholder="参数值"></textarea></td>
                            <td><input type="text" name="content_remark[]" class="form-control" placeholder="参数描述"
                                       value=""></td>
                            <td><i class="dripicons-trash trash"></i></td>
                        </tr>
                        <tr id="add_content_block">
                            <td colspan="5">
                                <div class="button-items d-grid gap-2">
                                    <button type="button" id="add_content_btn"
                                            class="btn btn-outline-secondary waves-effect waves-light btn-block">增加参数
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">请求参数</label>
            <div class="col-sm-10 params" style="max-height: 280px;overflow-y: scroll;">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <thead>
                        <tr>
                            <th style="color: red">*</th>
                            <th>参数名</th>
                            <th>默认值</th>
                            <th>参数描述</th>
                            <th>筛选方式</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row">
                                <select class="form-select" name="param_required[]">
                                    <option value="1">是</option>
                                    <option value="0">否</option>
                                </select>
                            </th>
                            <td><input type="text" name="param_name[]" class="form-control" placeholder="参数名"
                                       value=""></td>
                            <td><input type="text" name="param_default_value[]" class="form-control" placeholder="参数默认值"
                                       value=""></td>
                            <td><input type="text" name="param_remark[]" class="form-control" placeholder="参数描述"
                                       value=""></td>
                            <td>
                                <select class="form-select" name="param_filter_type[]">
                                    <option value="=">等于</option>
                                    <option value="like">包含</option>
                                </select>
                            </td>
                            <td><i class="dripicons-trash trash"></i></td>
                        </tr>
                        <tr id="add_param_block">
                            <td colspan="5">
                                <div class="button-items d-grid gap-2">
                                    <button type="button" id="add_param_btn"
                                            class="btn btn-outline-secondary waves-effect waves-light btn-block">增加参数
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">请求头参数</label>
            <div class="col-sm-10 params" style="max-height: 280px;overflow-y: scroll;">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <thead>
                        <tr>
                            <th>参数名</th>
                            <th>参数值</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="header_name[]" class="form-control" placeholder="参数名"
                                       value=""></td>
                            <td><input type="text" name="header_value[]" class="form-control" placeholder="参数值"
                                       value=""></td>
                            <td><i class="dripicons-trash trash"></i></td>
                        </tr>
                        <tr id="add_header_block">
                            <td colspan="3">
                                <div class="button-items d-grid gap-2">
                                    <button type="button" id="add_header_btn"
                                            class="btn btn-outline-secondary waves-effect waves-light btn-block">增加参数
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
@section('extend-javascript')
    <script>
        myAdmin.listen();

        $(document).ready(function () {

            $('#source_type').change(function () {
                let value = $(this).val();
                if (value === 'table') {
                    $('.type-table').show();
                    $('.type-api').hide();
                    $('.type-content').hide();
                    $('.type-diy').hide();
                } else if (value === 'request') {
                    $('.type-api').show();
                    $('.type-table').hide();
                    $('.type-content').hide();
                    $('.type-diy').hide();
                } else if(value === 'diy') {
                    $('.type-api').hide();
                    $('.type-diy').show();
                    $('.type-table').hide();
                    $('.type-content').hide();
                } else {
                    $('.type-api').hide();
                    $('.type-diy').hide();
                    $('.type-table').hide();
                    $('.type-content').show();
                }
            });

            $('#add_param_btn').click(function () {
                let html = `<tr>
                            <th scope="row">
                                <select class="form-select" name="param_required[]">
                                    <option value="1">是</option>
                                    <option value="0">否</option>
                                </select>
                            </th>
                            <td><input type="text" name="param_name[]" class="form-control" placeholder="参数名"
                                       value=""></td>
                            <td><input type="text" name="param_default_value[]" class="form-control" placeholder="参数默认值"
                                       value=""></td>
                            <td><input type="text" name="param_remark[]" class="form-control" placeholder="参数描述"
                                       value=""></td>
                            <td>
                                <select class="form-select" name="param_filter_type[]">
                                    <option value="=">等于</option>
                                    <option value="like">包含</option>
                                </select>
                            </td>
                            <td><i class="dripicons-trash trash"></i></td>
                        </tr>`;
                $('#add_param_block').before(html);
            });

            $('#add_header_btn').click(function () {
                let html = `<tr>
                            <td><input type="text" name="header_name[]" class="form-control" placeholder="参数名"
                                       value=""></td>
                            <td><input type="text" name="header_value[]" class="form-control" placeholder="参数值"
                                       value=""></td>
                            <td><i class="dripicons-trash trash"></i></td>
                        </tr>`;
                $('#add_header_block').before(html);
            });

            $('#add_content_btn').click(function () {
                let html = `<tr>
                            <td><input type="text" name="content_name[]" class="form-control" placeholder="参数名"
                                       value=""></td>
<td><textarea name="content_value[]" class="form-control" placeholder="参数值"></textarea></td>
                            <td><input type="text" name="content_remark[]" class="form-control" placeholder="参数描述"
                                       value=""></td>
                            <td><i class="dripicons-trash trash"></i></td>
                        </tr>`;
                $('#add_content_block').before(html);
            });

            $('#import').click(function () {
                let table = $('input[name="table_name"]').val();
                myAdmin.request.get("{{route('api.api.fields')}}", {table}, function (response) {
                    if (response.data.length > 0) {
                        let html = '';
                        for (let i = 0; i < response.data.length; i++) {
                            html += `<tr>
                                        <th scope="row"><input class="form-check-input" type="checkbox" name="response_fields[]" value="${response.data[i]}"></th>
                                        <td>${response.data[i]}</td>
                                        <td><select name="order_fields[${response.data[i]}]"><option value="">不参与排序</option><option value="desc">倒序</option><option value="asc">升序</option></select></td>
                                        <td><input type="text" name="rel_table[${response.data[i]}]" value=""></td>
                                    </tr>`;
                        }
                        $('#response_fields').html(html)
                    }
                });
            });

            $('#checkAllFields').click(function () {
                let element = $("[name='response_fields[]']");
                if ($(this).is(":checked")) {
                    element.attr("checked", true);
                } else {
                    element.attr("checked", false);
                }
            });

            $(document).on("click", ".trash", function () {
                $(this).parents('tr').remove();
            });

            $('#return_type').change(function () {
                if ($(this).val() === 'object') {
                    $('.count-field').show();
                } else {
                    $('.count-field').hide();
                }
            });
        });
    </script>
@endsection
