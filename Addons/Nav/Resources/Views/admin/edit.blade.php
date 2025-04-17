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
        </ul>

        <div class="tab-content p-3 text-muted">

            <div class="tab-pane active" id="base" role="tabpanel">
                <div class="layui-form-item  layui-row layui-col-xs12">
                    <label class="col-sm-2 col-form-label text-end-cms">上级导航</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="pid">
                            <option value="0">顶级导航</option>
                            @foreach($navs as $item)
                                <option value="{{$item['id']}}"
                                        @if($item['id'] == $nav->pid) selected @endif >{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" lay-verify="required" lay-reqtext="请输入名称"
                               placeholder="请输入名称" value="{{$nav->name}}">
                        <tip>填写名称。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">URL</label>
                    <div class="col-sm-10">
                        <input type="text" name="url" class="form-control" lay-verify="required" lay-reqtext="请输入URL"
                               placeholder="请输入URL" value="{{$nav->url}}">
                        <tip>填写URL。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">打开方式</label>
                    <div class="col-sm-10">
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="target1"
                                   name="target" @if($nav->target == '_blank') checked
                                   @endif
                                   value="_blank">
                            <label class="form-check-label" for="target1">
                                _blank
                            </label>
                        </div>
                        <div class="form-check col-md-2">
                            <input type="radio" class="form-check-input" id="target0"
                                   name="target" @if($nav->target == '_self') checked
                                   @endif
                                   value="_self">
                            <label class="form-check-label" for="target0">
                                _self
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">图标</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="ico" type="hidden" class="form-control" placeholder="请上传图标"
                               value="{{$nav->ico}}">
                        <input type="file" class="form-control" data-name="ico" cms-upload data-max-size="2"
                               data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">排序</label>
                    <div class="col-sm-10">
                        <input type="number" name="sort" class="form-control" placeholder="请输入排序"
                               value="{{$nav->sort}}">
                        <tip>填写排序。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">杂项</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="col-sm-3 col-form-label">内嵌样式</label>
                                <div class="col-sm-9">
                                    <input type="text" name="style_css" class="form-control" value="{{$nav->style_css}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-3 col-form-label">样式类名</label>
                                <div class="col-sm-9">
                                    <input type="text" name="style_class" class="form-control" value="{{$nav->style_class}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-3 col-form-label">样式ID</label>
                                <div class="col-sm-9">
                                    <input type="text" name="style_id" class="form-control" value="{{$nav->style_id}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label class="col-sm-3 col-form-label">Rel属性</label>
                                <div class="col-sm-9">
                                    <input type="text" name="rel" class="form-control" value="{{$nav->rel}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach(system_lang() as $abb => $lang)
                <div class="tab-pane" id="lang-{{$abb}}" role="tabpanel">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][name]" class="form-control" lay-reqtext="请输入名称"
                                   placeholder="请输入名称" value="{{$langPage[$abb]["name"] ?? ""}}">
                            <tip>填写名称。</tip>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">URL</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][url]" class="form-control" lay-reqtext="请输入URL"
                                   placeholder="请输入URL" value="{{$langPage[$abb]["url"] ?? ""}}">
                            <tip>填写URL。</tip>
                        </div>
                    </div>
                </div>

                <input name="lang[{{$abb}}][id]" type="hidden" value="{{$langPage[$abb]["id"] ?? ""}}">

            @endforeach

        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$nav->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
