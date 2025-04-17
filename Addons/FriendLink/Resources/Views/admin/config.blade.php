@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">显示页面</label>
            <div class="col-sm-10">

                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="friend_link_show1"
                           name="friend_link_show"
                           value="all">
                    <label class="form-check-label" for="friend_link_show1">
                        全部页面
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="friend_link_show0"
                           name="friend_link_show" checked
                           value="home">
                    <label class="form-check-label" for="friend_link_show0">
                        首页
                    </label>
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
