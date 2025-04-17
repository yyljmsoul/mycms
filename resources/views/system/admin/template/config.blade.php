@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            @foreach($configs as $key => $cfg)
                <li class="nav-item">
                    <a class="nav-link @if($key == 0) active @endif" data-bs-toggle="tab" href="#tab-{{$key}}"
                       role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">{{$cfg['name']}}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content p-3 text-muted">
            @if(count($lang) > 0)
                @foreach($configs as $key => $cfg)
                    <div class="tab-pane @if($key == 0) active @endif" id="tab-{{$key}}" role="tabpanel">
                        @foreach($cfg['elements'] as $ele)

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">{{$ele['label']}}</h4>
                                    <div>

                                        @foreach($lang as $lk => $la)
                                            @if($ele['type'] == 'input')
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end-cms">{{$la}}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text"
                                                               name="{{$cfg['page']}}[{{$lk}}][{{$ele['ident']}}]"
                                                               class="form-control"
                                                               value="{{template_config($cfg['page'],$ele['ident'], $lk)}}">
                                                    </div>
                                                </div>
                                            @endif

                                            @if($ele['type'] == 'textarea')
                                                <div class="row mb-3 layui-form-text">
                                                    <label class="col-sm-2 col-form-label text-end-cms">{{$la}}</label>
                                                    <div class="col-sm-10">
                                <textarea name="{{$cfg['page']}}[{{$lk}}][{{$ele['ident']}}]"
                                          class="form-control">{{template_config($cfg['page'],$ele['ident'], $lk)}}</textarea>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($ele['type'] == 'upload')

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label text-end-cms">{{$la}}</label>
                                                    <div class="col-sm-10 cms-upload">
                                                        <input name="{{$cfg['page']}}[{{$lk}}][{{$ele['ident']}}]"
                                                               type="hidden" class="form-control"
                                                               value="{{template_config($cfg['page'],$ele['ident'],$lk)}}">
                                                        <input type="file" class="form-control"
                                                               data-name="{{$cfg['page']}}[{{$lk}}][{{$ele['ident']}}]"
                                                               cms-upload data-max-size="2"
                                                               data-upload-exts=".ico,.png,.jpg,.jpeg">
                                                        <div class="my-1 upload-thumb">
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                @endforeach
            @else
                @foreach($configs as $key => $cfg)
                    <div class="tab-pane @if($key == 0) active @endif" id="tab-{{$key}}" role="tabpanel">
                        @foreach($cfg['elements'] as $ele)

                            @if($ele['type'] == 'input')
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label text-end-cms">{{$ele['label']}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="{{$cfg['page']}}[{{$ele['ident']}}]"
                                               class="form-control"
                                               placeholder="请输入{{$ele['label']}}"
                                               value="{{template_config($cfg['page'],$ele['ident'])}}">
                                        <tip>{{$ele['tips'] ?? "填写{$ele['label']}"}}</tip>
                                    </div>
                                </div>
                            @endif

                            @if($ele['type'] == 'textarea')
                                <div class="row mb-3 layui-form-text">
                                    <label class="col-sm-2 col-form-label text-end-cms">{{$ele['label']}}</label>
                                    <div class="col-sm-10">
                                <textarea name="{{$cfg['page']}}[{{$ele['ident']}}]"
                                          class="form-control">{{template_config($cfg['page'],$ele['ident'])}}</textarea>
                                        {{$ele['tips'] ?? "填写{$ele['label']}"}}
                                    </div>
                                </div>
                            @endif

                            @if($ele['type'] == 'upload')
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label text-end-cms">{{$ele['label']}}</label>
                                    <div class="col-sm-10 cms-upload">
                                        <input name="{{$cfg['page']}}[{{$ele['ident']}}]" type="hidden"
                                               class="form-control" placeholder="请上传{{$ele['label']}}"
                                               value="{{template_config($cfg['page'],$ele['ident'])}}">
                                        <input type="file" class="form-control"
                                               data-name="{{$cfg['page']}}[{{$ele['ident']}}]" cms-upload
                                               data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                                        <div class="my-1 upload-thumb">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>
                @endforeach
            @endif
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light" data-refresh="false">
                确认
            </button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>
    </form>
@endsection
