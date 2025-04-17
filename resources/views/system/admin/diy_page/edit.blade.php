@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#base" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">页面信息</span>
                </a>
            </li>
            @foreach(system_tap_lang() as $lg => $lang)
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#lang-{{$lg}}" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">{{$lang}}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="base" role="tabpanel">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">页面名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="page_name" class="form-control"
                               placeholder="请输入页面名称"
                               value="{{$data->page_name}}">
                        <tip>填写页面名称。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">页面地址</label>
                    <div class="col-sm-10">
                        <input type="text" name="page_path" class="form-control"
                               placeholder="请输入页面地址" value="{{$data->page_path}}">
                        <tip>填写页面地址(about/us)。</tip>
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">页面标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="page_title" class="form-control" placeholder="请输入页面标题"
                               value="{{$data->page_title}}">
                        <tip>填写页面标题。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">页面关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="page_keyword" class="form-control" placeholder="请输入页面关键词"
                               value="{{$data->page_keyword}}">
                        <tip>填写页面关键词。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">页面模板</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="page_template">
                            <option value="">请选择页面模板</option>
                            @foreach(system_theme_files() as $file)
                                <option value="{{$file['name']}}" {{$data->page_template == $file['name'] ? 'selected' : ''}}>{{$file['path']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">跳转链接</label>
                    <div class="col-sm-10">
                        <input type="text" name="redirect_url" class="form-control"
                               placeholder="请输入跳转链接" value="{{$data->redirect_url}}">
                        <tip>填写跳转链接。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">页面描述</label>
                    <div class="col-sm-10">
                        <textarea name="page_desc" class="form-control">{{$data->page_desc}}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">内容</label>
                    <div class="col-sm-10">
                        <textarea id="page_content" name="page_content" rows="20" class="editor"
                                  placeholder="请输入内容">{{$data->page_content}}</textarea>
                    </div>
                </div>
            </div>
            @foreach(system_tap_lang() as $abb => $lang)
                <div class="tab-pane" id="lang-{{$abb}}" role="tabpanel">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">页面名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][page_name]" class="form-control"
                                   placeholder="请输入页面名称"
                                   value="{{$langPage[$abb]['page_name'] ?? ''}}">
                            <tip>填写页面名称。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">页面标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][page_title]" class="form-control"
                                   placeholder="请输入页面标题"
                                   value="{{$langPage[$abb]['page_title'] ?? ''}}">
                            <tip>填写页面标题。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">页面关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][page_keyword]" class="form-control"
                                   placeholder="请输入页面关键词"
                                   value="{{$langPage[$abb]['page_keyword'] ?? ''}}">
                            <tip>填写页面关键词。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">页面描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][page_desc]"
                                          class="form-control">{{$langPage[$abb]['page_desc'] ?? ''}}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">内容</label>
                        <div class="col-sm-10">
                        <textarea id="lang[{{$abb}}][page_content]" name="lang[{{$abb}}][page_content]" rows="20"
                                  class="editor"
                                  placeholder="请输入内容">{{$langPage[$abb]['page_content'] ?? ''}}</textarea>
                        </div>
                    </div>

                    <input type="hidden" name="lang[{{$abb}}][id]" value="{{$langPage[$abb]['id'] ?? ''}}">
                </div>
            @endforeach
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$data->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
