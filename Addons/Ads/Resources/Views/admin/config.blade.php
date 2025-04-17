@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">入口Js路径</label>
            <div class="col-sm-10">
                <input type="text" name="entrance_js" id="entrance_js" class="form-control" lay-verify="required"
                       lay-reqtext="请输入入口Js路径" placeholder="请输入入口Js路径"
                       value="{{$config['entrance_js'] ?? bin2hex(random_bytes(10))}}">
                <tip>第一步加载的JS。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">内容JS路径</label>
            <div class="col-sm-10">
                <input type="text" name="content_js" id="content_js" class="form-control" lay-verify="required"
                       lay-reqtext="请输入内容JS路径" placeholder="请输入内容JS路径"
                       value="{{$config['content_js'] ?? bin2hex(random_bytes(10))}}">
                <tip>加载内容的JS。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">内容Ajax路径</label>
            <div class="col-sm-10">
                <input type="text" name="content_path" id="content_path" class="form-control" lay-verify="required"
                       lay-reqtext="请输入内容Ajax路径" placeholder="请输入内容Ajax路径"
                       value="{{$config['content_path'] ?? bin2hex(random_bytes(10))}}">
                <tip>请求加载内容的路径。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">生成随机字符</label>
            <div class="col-sm-10">
                <button type="button" class="btn btn-light waves-effect" onclick="makeRandStr();">
                    一键生成
                </button>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
    <script>
        function makeRandStr() {
            document.getElementById("entrance_js").value = randomString(10);
            document.getElementById("content_js").value = randomString(10);
            document.getElementById("content_path").value = randomString(10);
        }

        function randomString(length) {
            var str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var result = '';
            for (var i = length; i > 0; --i)
                result += str[Math.floor(Math.random() * str.length)];
            return result;
        }
    </script>
@endsection
