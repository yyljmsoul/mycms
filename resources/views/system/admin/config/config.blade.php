@extends("layouts.common")

@section('page-content-wrapper')

    <form id="app-form" method="post">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#system" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">系统设置</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="system" role="tabpanel">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">站点名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_name" class="form-control"
                               placeholder="请输入站点名称" value="{{$systemConfig['site_name']}}">
                        <tip>填写站点名称</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">站点网址</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_url" class="form-control"
                               placeholder="请输入站点网址" value="{{$systemConfig['site_url']}}">
                        <tip>填写站点网址</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">后台目录</label>
                    <div class="col-sm-10">
                        <input type="text" name="admin_prefix" class="form-control"
                               placeholder="请输入后台目录" value="{{$systemConfig['admin_prefix'] ?? ''}}">
                        <tip>填写后台目录</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">站点Logo</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="site_logo" type="hidden" class="form-control" placeholder="请上传LOGO图标"
                               value="{{$systemConfig['site_logo']}}">
                        <input type="file" class="form-control" data-name="site_logo" cms-upload data-max-size="2"
                               data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">备案号</label>
                    <div class="col-sm-10">
                        <input type="text" name="site_icp" class="form-control" placeholder="请输入站点网址"
                               value="{{$systemConfig['site_icp']}}">
                    </div>
                </div>

                @if ($themes = system_themes())
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">模板主题</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="cms_theme">
                                @foreach($themes as $theme)
                                    <option value="{{$theme['ident']}}"
                                            @if((!isset($systemConfig['cms_theme']) && $theme['ident'] == 'default') || (isset($systemConfig['cms_theme']) && $theme['ident'] == $systemConfig['cms_theme'])) selected @endif>{{$theme['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                @if ($lang = config('lang'))
                    <div class="row mb-3">
                        <label class="col-sm-2 pt-0 col-form-label text-end-cms">开启多语言</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach($lang as $lk => $la)
                                    <div class="form-check col-md-2">
                                        <input type="checkbox" class="form-check-input" id="lang_{{$lk}}"
                                               name="lang[{{$lk}}]"
                                               @if(in_array($lk,array_keys($systemConfig['lang'] ?? []))) checked
                                               @endif value="{{$la}}">
                                        <label class="form-check-label" for="lang_{{$lk}}">
                                            {{$la}}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 pt-0 col-form-label text-end-cms">默认语言</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach(system_lang() as $lk => $la)

                                    <div class="form-check col-md-2">
                                        <input type="radio" class="form-check-input" name="default_lang"
                                               id="default_lang_{{$lk}}"
                                               @if(isset($systemConfig['default_lang']) && $systemConfig['default_lang'] == $lk ) checked
                                               @endif value="{{$lk}}">
                                        <label class="form-check-label" for="default_lang_{{$lk}}">
                                            {{$la}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <label class="col-sm-2 pt-0 col-form-label text-end-cms">富文本编辑器</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" name="default_editor"
                                       id="default_editor_ck"
                                       @if(!isset($systemConfig['default_editor']) || $systemConfig['default_editor'] == 'ck' ) checked
                                       @endif value="ck">
                                <label class="form-check-label" for="default_editor_ck">
                                    CKEditor
                                </label>
                            </div>

                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" name="default_editor"
                                       id="default_editor_ue"
                                       @if(isset($systemConfig['default_editor']) && $systemConfig['default_editor'] == 'ue' ) checked
                                       @endif value="ue">
                                <label class="form-check-label" for="default_editor_ue">
                                    UEditor
                                </label>
                            </div>


                            <div class="form-check col-md-2">
                                <input type="radio" class="form-check-input" name="default_editor"
                                       id="default_editor_md"
                                       @if(isset($systemConfig['default_editor']) && $systemConfig['default_editor'] == 'md' ) checked
                                       @endif value="md">
                                <label class="form-check-label" for="default_editor_md">
                                    Markdown
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 layui-form-text">
                    <label class="col-sm-2 col-form-label text-end-cms">版权信息</label>
                    <div class="col-sm-10">
                                <textarea name="site_copyright"
                                          class="form-control">{{$systemConfig['site_copyright']}}</textarea>
                    </div>
                </div>

                <div class="row mb-3 layui-form-text">
                    <label class="col-sm-2 col-form-label text-end-cms">头部自定义js</label>
                    <div class="col-sm-10">
                                <textarea name="site_header_js"
                                          class="form-control">{{$systemConfig['site_header_js'] ?? ''}}</textarea>
                        <tip>常用于放置统计代码</tip>
                    </div>
                </div>

                <div class="row mb-3 layui-form-text">
                    <label class="col-sm-2 col-form-label text-end-cms">文件上传</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="site_upload_disk">
                            <option value="root"
                                    @if(isset($systemConfig['site_upload_disk']) && $systemConfig['site_upload_disk'] == 'root') selected @endif>
                                本地
                            </option>
                            <option value="oss"
                                    @if(isset($systemConfig['site_upload_disk']) && $systemConfig['site_upload_disk'] == 'oss') selected @endif>
                                阿里云OSS
                            </option>
                            <option value="qiniu"
                                    @if(isset($systemConfig['site_upload_disk']) && $systemConfig['site_upload_disk'] == 'qiniu') selected @endif>
                                七牛云存储
                            </option>
                        </select>
                    </div>

                </div>
            </div>

        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light" data-refresh="false">确认
            </button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>
    </form>

@endsection
