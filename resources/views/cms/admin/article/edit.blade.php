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
                    <label class="col-sm-2 col-form-label text-end-cms required">分类</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="category_id" id="category_id">
                            @foreach($categories as $item)
                                <option value="{{$item['id']}}"
                                        @if($item['id']==$article->category_id) selected @endif>{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">分组</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="group_id" id="group_id">
                            <option value="0">请选择分组</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control"
                               placeholder="请输入标题" value="{{$article->title}}">
                        <tip>填写标题。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">短标题</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="attr[ident][]" value="short_title">
                        <input type="text" name="attr[value][]" class="form-control"
                               placeholder="请输入短标题" value="{{$article->short_title}}">
                        <tip>填写短标题。</tip>
                    </div>
                </div>

                @if(app('system')->addonEnabled('UrlFormat'))
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">别名</label>
                        <div class="col-sm-10">
                            <input type="text" name="alias" class="form-control" placeholder="请输入别名"
                                   value="{{url_format_alias_for_id($article->id,'single')}}">
                            <tip>用于URL优化。</tip>
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">作者</label>
                    <div class="col-sm-10">
                        <input type="text" name="author" class="form-control" placeholder="请输入作者"
                               value="{{$article->author}}">
                        <tip>填写作者。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">标签</label>
                    <div class="col-sm-10">
                        <input type="text" name="tags" class="form-control" placeholder="请输入标签"
                               value="{{$tags}}">
                        <tip>多个标签请用英文逗号（,）分开。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">缩略图</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="img" type="hidden" class="form-control" placeholder="请上传缩略图"
                               value="{{$article->img}}">
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
                               placeholder="请输入跳转链接" value="{{$article->redirect_url ?? ''}}">
                        <tip>填写跳转链接。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">描述</label>
                    <div class="col-sm-10">
                            <textarea name="description" class="form-control"
                                      placeholder="请输入描述">{{$article->description}}</textarea>
                        <tip>填写描述。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">属性</label>
                    <div class="col-sm-10">
                        @foreach($attributes as $item)
                            <div class="form-check col-md-2">
                                <input type="hidden" name="attr[ident][]" value="{{$item['ident']}}">
                                <input type="checkbox" class="form-check-input"
                                       id="form-check-input-{{$item['ident']}}" name="attr[value][]"
                                       value="1" @if($article->{$item['ident']} == 1) checked
                                    @endif>
                                <label class="form-check-label" for="form-check-input-{{$item['ident']}}">
                                    {{$item['name']}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">内容</label>
                    <div class="col-sm-10">
                            <textarea id="content" name="content" rows="20" class="editor"
                                      placeholder="请输入内容">{{$article->content}}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">状态</label>
                    <div class="col-sm-10">
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="status-0" name="status"
                                   @if($article->status == 0) checked @endif value="0">
                            <label class="form-check-label" for="status-0">
                                待发布
                            </label>
                        </div>
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="status-1"
                                   @if($article->status == 1) checked @endif name="status" value="1">
                            <label class="form-check-label" for="status-1">
                                已发布
                            </label>
                        </div>

                    </div>
                </div>

            </div>
            @foreach(system_tap_lang() as $abb => $lang)
                <div class="tab-pane" id="lang-{{$abb}}" role="tabpanel">

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][title]" class="form-control"
                                   placeholder="请输入标题"
                                   value="{{$articleLang["lang_{$abb}_single"]['title'] ?? ''}}">
                            <tip>填写标题。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">短标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][short_title]" class="form-control"
                                   placeholder="请输入短标题"
                                   value="{{$articleLang["lang_{$abb}_single"]['short_title'] ?? ''}}">
                            <tip>填写短标题。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">作者</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][author]" class="form-control"
                                   placeholder="请输入作者"
                                   value="{{$articleLang["lang_{$abb}_single"]['author'] ?? auth()->guard('admin')->user()->name}}">
                            <tip>填写作者。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">标签</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][tags]" class="form-control" placeholder="请输入标签"
                                   value="{{$articleLang["lang_{$abb}_single"]['tags'] ?? ''}}">
                            <tip>多个标签请用英文逗号（,）分开。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">缩略图</label>
                        <div class="col-sm-10 cms-upload">
                            <input name="lang[{{$abb}}][img]" type="hidden" class="form-control" placeholder="请上传缩略图"
                                   value="{{$articleLang["lang_{$abb}_single"]['img'] ?? ''}}">
                            <input type="file" class="form-control" data-name="lang[{{$abb}}][img]" cms-upload
                                   data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                            <div class="my-1 upload-thumb">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][description]" class="form-control"
                                          placeholder="请输入描述">{{$articleLang["lang_{$abb}_single"]['description'] ?? ''}}</textarea>
                            <tip>填写描述。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">内容</label>
                        <div class="col-sm-10">
                        <textarea id="lang[{{$abb}}][content]" name="lang[{{$abb}}][content]" rows="20" class="editor"
                                  placeholder="请输入内容">{{$articleLang["lang_{$abb}_single"]['content'] ?? ''}}</textarea>
                        </div>
                    </div>

                </div>
            @endforeach
            <div class="tab-pane" id="diy-config" role="tabpanel">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">页面模板</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="template">
                            <option value="">请选择指定的页面模板</option>
                            @foreach(system_theme_files() as $file)
                                <option value="{{$file['name']}}" {{$article->template == $file['name'] ? 'selected' : ''}}>{{$file['path']}}</option>
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

                <div class="row mb-3" id="diy-button">
                    <label class="col-sm-2 col-form-label text-end-cms"></label>
                    <div class="col-sm-10">
                        <button type="button" id="add-diy-button"
                                class="btn btn-light waves-effect">
                            新增配置 +
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$article->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>
    </form>


    <div style="display: none" id="diy-tpl">
        <div class="row mb-3 meta-item">
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
                var html = $('#diy-tpl').html();
                $('#diy-button').before(html);
            }
        );

        group({{$article->category_id}}, {{$article->group_id}});

        $('#category_id').change(function () {
            console.info($(this).val())
            group($(this).val(), {{$article->group_id}})
        });

        function group(cid, gid) {
            myAdmin.request.get("{!! myRoute('cms.article_group.json') !!}", {category_id: cid}, function (result) {
                let html = '<option value="0">请选择分组</option>';
                for (let i = 0; i < result.data.length; i++) {
                    html += '<option value="' + result.data[i].id + '" '+(gid == result.data[i].id ? 'selected' : '')+'>' + result.data[i].name + '</option>';
                }
                $('#group_id').html(html);
            });
        }

    </script>
@endsection
