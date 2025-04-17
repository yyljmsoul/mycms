@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#base" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">基本信息</span>
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
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#diy-config" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">自定义配置</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="base" role="tabpanel">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">上级分类</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="pid">
                            <option value="0">顶级分类</option>
                            @foreach($categories as $item)
                                <option value="{{$item['id']}}"
                                        @if($item['id']==$category->pid) selected @endif>{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control"

                               placeholder="请输入名称" value="{{$category->name}}">
                        <tip>填写名称。</tip>
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">副名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="sub_name" class="form-control"
                               placeholder="请输入副名称" value="{{$category->sub_name}}">
                        <tip>填写副名称。</tip>
                    </div>
                </div>

                @if(app('system')->addonEnabled('UrlFormat'))
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">别名</label>
                        <div class="col-sm-10">
                            <input type="text" name="alias" class="form-control" placeholder="请输入别名"
                                   value="{{url_format_alias_for_id($category->id,'category')}}">
                            <tip>用于URL优化。</tip>
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">缩略图</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="img" type="hidden" class="form-control" placeholder="请上传缩略图"
                               value="{{$category->img ?? ''}}">
                        <input type="file" class="form-control" data-name="img" cms-upload data-max-size="2"
                               data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">跳转链接</label>
                    <div class="col-sm-10">
                        <input type="text" name="redirect_url" class="form-control"
                               placeholder="请输入跳转链接" value="{{$category->redirect_url ?? ''}}">
                        <tip>填写跳转链接。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="keyword" class="form-control"
                               placeholder="请输入关键词" value="{{$category->keyword ?? ''}}">
                        <tip>填写关键词。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">描述</label>
                    <div class="col-sm-10">
                            <textarea name="description" class="form-control"
                                      placeholder="请输入描述">{{$category->description}}</textarea>
                        <tip>填写描述。</tip>
                    </div>
                </div>

            </div>
            @foreach(system_tap_lang() as $abb => $lang)
                <div class="tab-pane" id="lang-{{$abb}}" role="tabpanel">

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms required">名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][name]" class="form-control"

                                   placeholder="请输入名称"
                                   value="{{$categoryLang["lang_{$abb}_category"]['name'] ?? ''}}">
                            <tip>填写名称。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">副名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][sub_name]" class="form-control"
                                   placeholder="请输入副名称"
                                   value="{{$categoryLang["lang_{$abb}_category"]['sub_name'] ?? ''}}">
                            <tip>填写短题。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">缩略图</label>
                        <div class="col-sm-10 cms-upload">
                            <input name="lang[{{$abb}}][img]" type="hidden" class="form-control" placeholder="请上传缩略图"
                                   value="{{$categoryLang["lang_{$abb}_category"]['img'] ?? ''}}">
                            <input type="file" class="form-control" data-name="lang[{{$abb}}][img]" cms-upload
                                   data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                            <div class="my-1 upload-thumb">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][keyword]" class="form-control"
                                   placeholder="请输入关键词" value="{{$categoryLang["lang_{$abb}_category"]['keyword'] ?? ''}}">
                            <tip>填写关键词。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][description]" class="form-control"
                                          placeholder="请输入描述">{{$categoryLang["lang_{$abb}_category"]['description'] ?? ''}}</textarea>
                            <tip>填写描述。</tip>
                        </div>
                    </div>

                </div>
            @endforeach
            <div class="tab-pane" id="diy-config" role="tabpanel">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">分类页面模板</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="template">
                            <option value="">请选择指定的页面模板</option>
                            @foreach(system_theme_files() as $file)
                                <option value="{{$file['name']}}" {{$category->template == $file['name'] ? 'selected' : ''}}>{{$file['path']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">分类文章模板</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="single_template">
                            <option value="">请选择指定的页面模板</option>
                            @foreach(system_theme_files() as $file)
                                <option value="{{$file['name']}}"{{$category->single_template == $file['name'] ? 'selected' : ''}}>{{$file['path']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @foreach($meta as $item)
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms required">配置</label>
                        <div class="col-sm-10">
                            <div class="form-control-inline">
                                <input type="text" name="attr[ident][]" class="form-control" placeholder="配置标识"
                                       value="{{$item->meta_key}}">
                            </div>
                            <div class="form-control-inline">
                                <input type="text" name="attr[value][]" class="form-control" placeholder="配置值"
                                       value="{{$item->meta_value}}">
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">配置</label>
                    <div class="col-sm-10">
                        <div class="form-control-inline">
                            <input type="text" name="attr[ident][]" class="form-control" placeholder="配置标识"
                                   value="">
                        </div>
                        <div class="form-control-inline">
                            <input type="text" name="attr[value][]" class="form-control" placeholder="配置值"
                                   value="">
                        </div>
                    </div>
                </div>

                <div class="row mb-3" id="extend-div">
                    <label class="col-sm-2 col-form-label text-end-cms"></label>
                    <div class="col-sm-10">

                        <div class="form-check col-md-2">
                            <input type="checkbox" class="form-check-input" id="apply_to_category"
                                   name="apply_to_category" @if($category->apply_to_category == 1) checked @endif
                                   value="1">
                            <label class="form-check-label" for="apply_to_category">
                                应用到子分类
                            </label>
                        </div>
                        <div class="form-check col-md-2">
                            <input type="checkbox" class="form-check-input" id="apply_to_article"
                                   name="apply_to_article" @if($category->apply_to_article == 1) checked @endif
                                   value="1">
                            <label class="form-check-label" for="apply_to_article">
                                应用到文章
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3" id="diy-button">
                    <label class="col-sm-2 col-form-label text-end-cms"></label>
                    <div class="col-sm-10">
                        <button type="button" id="add-diy-button" class="btn btn-light waves-effect">
                            新增配置 +
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$category->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>


    </form>
    <div style="display: none" id="diy-tpl">
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms required">配置</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" name="attr[ident][]" class="form-control" placeholder="配置标识"
                               value="">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="attr[value][]" class="form-control" placeholder="配置值"
                               value="">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('extend-javascript')
    <script>
        myAdmin.listen();

        $('#add-diy-button').click(
            function () {
                const html = $('#diy-tpl').html();
                $('#extend-div').before(html);
            }
        );
    </script>
@endsection
