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
                            <option value="0">请选择分类</option>
                            @foreach($categories as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
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
                        @if(!env('CG_KEY'))
                            <input type="text" name="title" class="form-control" placeholder="请输入标题" value="">
                            <tip>填写标题。</tip>
                        @else
                            <div class="row">
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control"
                                           placeholder="请输入标题" value="">
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="question" class="btn btn-primary waves-effect waves-light">向ChatGPT提问</button>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">短标题</label>
                    <div class="col-sm-10">
                        <input type="hidden" name="attr[ident][]" value="short_title">
                        <input type="text" name="attr[value][]" class="form-control"
                               placeholder="请输入短标题" value="">
                        <tip>填写短标题。</tip>
                    </div>
                </div>

                @if(app('system')->addonEnabled('UrlFormat'))
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">别名</label>
                        <div class="col-sm-10">
                            <input type="text" name="alias" class="form-control" placeholder="请输入别名"
                                   value="">
                            <tip>用于URL优化。</tip>
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">作者</label>
                    <div class="col-sm-10">
                        <input type="text" name="author" class="form-control" placeholder="请输入作者"
                               value="{{auth()->guard('admin')->user()->name}}">
                        <tip>填写作者。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">标签</label>
                    <div class="col-sm-10">
                        <input type="text" name="tags" class="form-control" placeholder="请输入标签" value="">
                        <tip>多个标签请用英文逗号（,）分开。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">缩略图</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="img" type="hidden" class="form-control" placeholder="请上传缩略图"
                               value="">
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
                               placeholder="请输入跳转链接" value="">
                        <tip>填写跳转链接。</tip>
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
                    <label class="col-sm-2 pt-0 col-form-label text-end-cms">属性</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach($attributes as $item)
                                <div class="form-check col-md-2">
                                    <input type="hidden" name="attr[ident][]" value="{{$item['ident']}}">
                                    <input type="checkbox" class="form-check-input"
                                           id="form-check-input-{{$item['ident']}}" name="attr[value][]"
                                           value="1">
                                    <label class="form-check-label" for="form-check-input-{{$item['ident']}}">
                                        {{$item['name']}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">内容</label>
                    <div class="col-sm-10">
                        <textarea id="content" name="content" rows="20" class="editor"
                                  placeholder="请输入内容"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms required">状态</label>
                    <div class="col-sm-10">
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="status-0" name="status"
                                   value="0">
                            <label class="form-check-label" for="status-0">
                                待发布
                            </label>
                        </div>
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="status-1" name="status" checked value="1">
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
                        <label class="col-sm-2 col-form-label text-end-cms required">标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][title]" class="form-control" placeholder="请输入标题"
                                   value="">
                            <tip>填写标题。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">短标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][short_title]" class="form-control"
                                   placeholder="请输入短标题" value="">
                            <tip>填写短标题。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">作者</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][author]" class="form-control"
                                   placeholder="请输入作者"
                                   value="{{auth()->guard('admin')->user()->name}}">
                            <tip>填写作者。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">标签</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][tags]" class="form-control" placeholder="请输入标签"
                                   value="">
                            <tip>多个标签请用英文逗号（,）分开。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">缩略图</label>
                        <div class="col-sm-10 cms-upload">
                            <input name="lang[{{$abb}}][img]" type="hidden" class="form-control" placeholder="请上传缩略图"
                                   value="">
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
                                          placeholder="请输入描述"></textarea>
                            <tip>填写描述。</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms required">内容</label>
                        <div class="col-sm-10">
                        <textarea id="lang[{{$abb}}][content]" name="lang[{{$abb}}][content]" rows="20" class="editor"
                                  placeholder="请输入内容"></textarea>
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
                                <option value="{{$file['name']}}">{{$file['path']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

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

    <div style="display: none" id="extend-tpl">
        <div class="row mb-3 meta-item">
            <label class="col-sm-2 col-form-label text-end-cms required">配置</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" name="attr[ident][]" class="form-control" placeholder="配置标识"
                               value="{ident}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" name="attr[value][]" class="form-control" placeholder="配置值"
                               value="{value}">
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

        $('#category_id').change(function () {
            $.get(
                "{!! myRoute('article.category.metaToArticle') !!}?id=" + $(this).val(),
                function (result) {

                    var html = '';
                    $('.tab-pane .meta-item').remove();

                    for (var i in result['data']) {
                        var obj = result['data'][i];
                        html += $('#extend-tpl').html().replace("{ident}", obj.meta_key).replace("{value}", obj.meta_value);
                    }

                    $('#diy-button').before(html);
                }
            );

            myAdmin.request.get("{!! myRoute('cms.article_group.json') !!}", {category_id: $(this).val()}, function (result) {
                let html = '<option value="0">请选择分组</option>';
                for (let i = 0; i < result.data.length; i++) {
                    html += '<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>';
                }
                $('#group_id').html(html);
            });
        });

        $('#question').click(function () {
            let q = $('input[name="title"]').val();
            if (q.length === 0) {
                myAdmin.message.error("请输入标题");
                return false;
            }

            myAdmin.request.post("{{route('system.chatgpt.question')}}", {q}, function (response) {
                $('[name="content"]').val(response.result);

                if (defaultEditor === '' || defaultEditor === 'ck') {
                    CKEDITOR.instances.content.setData(response.result);
                } else {
                    let ue = UE.getEditor('content');
                    ue.setContent(response.result);
                }

            })
        });

    </script>
@endsection
