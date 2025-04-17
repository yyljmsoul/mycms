@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        @foreach($columns as $col)
            @if(strstr($col['type'], 'text') !== false)
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">{{$col['name']}}</label>
                    <div class="col-sm-10">
                        <textarea name="{{$col['name']}}" class="form-control"
                                  placeholder="请输入{{$col['comment'] ?: $col['name']}}"></textarea>
                    </div>
                </div>
            @elseif($col['type'] == 'timestamp' || $col['type'] == 'datetime')
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">{{$col['name']}}</label>
                    <div class="col-sm-10">
                        <input type="text" id="{{$col['name']}}" name="{{$col['name']}}" class="form-control"
                               placeholder="请输入{{$col['comment'] ?: $col['name']}}" value="">
                    </div>
                </div>
                <script>

                </script>
            @else
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">{{$col['name']}}</label>
                    <div class="col-sm-10">
                        <input type="text" name="{{$col['name']}}" class="form-control"
                               placeholder="请输入{{$col['comment'] ?: $col['name']}}" value="">
                        <tip>请输入{{$col['comment'] ?: $col['name']}}。</tip>
                    </div>
                </div>
            @endif
        @endforeach


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

            @foreach($columns as $col)
                @if($col['type'] == 'timestamp' || $col['type'] == 'datetime')
                $('#{{$col['name']}}').datetimepicker({
                    format: 'yyyy-mm-dd hh:ii:ss',
                    language: 'zh-CN',
                });
                @endif
            @endforeach
        });
    </script>
@endsection
