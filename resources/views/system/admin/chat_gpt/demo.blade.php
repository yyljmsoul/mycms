@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">问题</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-10">
                        <input type="text" name="q" class="form-control"
                               placeholder="请输入问题" value="">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" id="btn" class="btn btn-primary waves-effect waves-light">提问</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3 layui-form-text">
            <label class="col-sm-2 col-form-label text-end-cms">答案</label>
            <div class="col-sm-10">
                <textarea name="a" class="form-control" rows="8" placeholder="请等待ChatGPT的回答..."></textarea>
            </div>
        </div>

    </form>
@endsection

@section('extend-javascript')
    <script>
        $('#btn').click(function () {
            let q = $('input[name="q"]').val();
            if (q.length === 0) {
                myAdmin.message.error("请输入问题");
                return false;
            }

            myAdmin.request.post("{{route('system.chatgpt.question')}}", {q}, function (response) {
                $('[name="a"]').val(response.result);
            })
        });
    </script>
@endsection
