@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms required">开启评论</label>
            <div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_allow_comment1" name="is_allow_comment" value="1"
                           @if(isset($config['is_allow_comment']) && $config['is_allow_comment'] == '1') checked
                        @endif>
                    <label class="form-check-label" for="is_allow_comment1">
                        开启
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_allow_comment0" name="is_allow_comment" value="-1"
                           @if(isset($config['is_allow_comment']) && $config['is_allow_comment'] == '-1') checked
                        @endif>
                    <label class="form-check-label" for="is_allow_comment0">
                        关闭
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms required">评论状态</label>
            <div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_auto_status1" name="is_auto_status" value="1"
                           @if(isset($config['is_auto_status']) && $config['is_auto_status'] == '1') checked
                        @endif>
                    <label class="form-check-label" for="is_auto_status1">
                        通过
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_auto_status0" name="is_auto_status" value="-1"
                           @if(isset($config['is_auto_status']) && $config['is_auto_status'] == '-1') checked
                        @endif>
                    <label class="form-check-label" for="is_auto_status0">
                        待审核
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
