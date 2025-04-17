@extends("layouts.common")
@section('page-content-wrapper')

    <form id="app-form">
        @if($response)
            @if($response['code'] == 200)
                <table id="currentTable" class="layui-table">
                    <thead>
                    <tr>
                        <th>文件</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($files as $file)
                        @if(in_array($file['status'],array_keys($status)))
                            <tr>
                                <td>{{$file['filename']}}</td>
                                <td>{{$status[$file['status']]}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">更新版本</label>
                    <div class="col-sm-10">
                        <input type="text" name="upgrade_version" class="form-control" readonly
                               value="{{$response['result']['version']}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">更新包</label>
                    <div class="col-sm-10">
                        <input type="text" name="upgrade_package" class="form-control" readonly
                               value="{{$response['result']['zip_path']}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms"></label>
                    <div class="col-sm-10">
                        <p style="color: red">更新升级前，请确保已经备份好数据库及代码！！！</p>
                    </div>
                </div>

                <div class="hr-line"></div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">确认更新
                    </button>
                </div>

            @else
                <p>{{$response['msg']}}</p>
            @endif
        @else
            <p>该版本无法使用一键升级</p>
        @endif
    </form>

@endsection
