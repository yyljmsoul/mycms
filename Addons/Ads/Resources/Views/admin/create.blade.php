@extends("layouts.common")
@section('page-content-wrapper')
    <style>
        .stub-type {
            display: none
        }

        fieldset {
            padding: 10px 0;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px
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
                    <a class="nav-link" data-bs-toggle="tab" href="#diy-config" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">防屏蔽设置</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="base" role="tabpanel">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" lay-verify="required" lay-reqtext="请输入名称"
                                   placeholder="请输入名称" value="">
                            <tip>填写名称。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">标识</label>
                        <div class="col-sm-10">
                            <input type="text" name="code" class="form-control" lay-verify="required" lay-reqtext="请输入标识"
                                   placeholder="请输入标识" value="">
                            <tip>填写标识（字母）。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">描述</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" placeholder="请输入描述"></textarea>
                            <tip>填写描述。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">类型</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="type" id="type" lay-filter="type">
                                <option value="">选择素材类型</option>
                                @foreach(config('ads.types') as $key => $item)
                                    <option value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @foreach(config('ads.types') as $key => $item)
                        <div id="tpl-{{$key}}" class="stub-type">
                            @include("ads::admin.stubs.{$key}")
                        </div>
                    @endforeach

                </div>
                <div class="tab-pane" id="diy-config" role="tabpanel">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">备用图片</label>
                        <div class="col-sm-10 cms-upload">
                            <input name="forbid_img" type="hidden" class="form-control" placeholder="请上传备用图片"
                                   value="">
                            <input type="file" class="form-control" data-name="forbid_img" cms-upload data-max-size="2"
                                   data-upload-exts=".ico,.png,.jpg,.jpeg">
                            <div class="my-1 upload-thumb">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">备用链接</label>
                        <div class="col-sm-10">
                            <input type="text" name="forbid_url" class="form-control" placeholder="请输入备用链接"
                                   value="">
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
    <div id="link-res" style="display: none">
        <div class="row mb-3">

            <label class="col-sm-2 col-form-label text-end-cms">超链接</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" name="link[text][]" placeholder="文本" autocomplete="off"
                               class="form-control" value="">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="link[url][]" placeholder="链接" autocomplete="off"
                               class="form-control" value="">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="image-res" style="display: none">
        <fieldset>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                <div class="col-sm-10 cms-upload">
                    <input name="image[path][{num}]" type="hidden" class="form-control" placeholder="请上传缩略图"
                           value="">
                    <input type="file" class="form-control" data-name="image[path][{num}]" cms-upload data-max-size="2"
                           data-upload-exts=".ico,.png,.jpg,.jpeg">
                    <div class="my-1 upload-thumb">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label text-end-cms">链接</label>
                <div class="col-sm-10">
                    <input type="text" name="image[url][{num}]" class="form-control" placeholder="请输入链接" value="">
                </div>
            </div>
        </fieldset>

    </div>

@endsection
@section('extend-javascript')
    <script>
        myAdmin.form();
        myAdmin.upload();

        $('#type').change(function () {
            $('.stub-type').hide();

            if ($(this).val()) {
                $('#tpl-' + $(this).val()).show();
            }

        });

        $('#add-link-button').click(function () {

            let html = $('#link-res').html();

            $('#add-link').before(html);
        });

        $('#add-image-button').click(function () {

            let html = $('#image-res').html();

            let len = $('#tpl-image').find('fieldset').length;
            html = html.replaceAll("{num}", len);

            $('#add-image').before(html);

            myAdmin.upload();
        });
    </script>
@endsection
