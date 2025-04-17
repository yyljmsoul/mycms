@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">数据表</label>
            <div class="col-sm-10">
                <input type="text" name="table_name"  class="form-control" placeholder="请输入数据表名称" value="">
                <tip>填写数据表名称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">数据字段</label>
            <div class="col-sm-10 params" style="height: 280px;overflow-y: scroll;">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">

                        <thead>
                        <tr>
                            <th>字段名</th>
                            <th>类型</th>
                            <th>默认值</th>
                            <th>描述</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="field_name[]" class="form-control" placeholder="字段名"
                                       value=""></td>
                            <td>
                                <select class="form-select" name="field_type[]">
                                    <option value="int">整数</option>
                                    <option value="bigint">大整数</option>
                                    <option value="decimal">浮点数</option>
                                    <option value="timestamp">日期时分秒</option>
                                    <option value="varchar">字符串</option>
                                    <option value="text">文本</option>
                                    <option value="longtext">长文本</option>
                                </select>
                            </td>
                            <td><input type="text" name="field_default_value[]" class="form-control" placeholder="参数默认值"
                                       value=""></td>
                            <td><input type="text" name="field_remark[]" class="form-control" placeholder="参数描述"
                                       value=""></td>
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


            $('#add_param_btn').click(function () {
                let html = `<tr>
                            <td><input type="text" name="field_name[]" class="form-control" placeholder="字段名"
                                       value=""></td>
                            <td>
                                <select class="form-select" name="field_type[]">
                                    <option value="int">整数</option>
                                    <option value="bigint">大整数</option>
                                    <option value="decimal">浮点数</option>
                                    <option value="timestamp">日期时分秒</option>
                                    <option value="varchar">字符串</option>
                                    <option value="text">文本</option>
                                    <option value="longtext">长文本</option>
                                </select>
                            </td>
                            <td><input type="text" name="field_default_value[]" class="form-control" placeholder="参数默认值"
                                       value=""></td>
                            <td><input type="text" name="field_remark[]" class="form-control" placeholder="参数描述"
                                       value=""></td>
                            <td><i class="dripicons-trash trash"></i></td>
                        </tr>`;
                $('#add_param_block').before(html);
            });

            $(document).on("click", ".trash", function () {
                $(this).parents('tr').remove();
            })
        });
    </script>
@endsection
