@extends("layouts.common")
@section('page-content-wrapper')
    <style>
        #spec-table th {
            text-align: center;
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
                <a class="nav-link" data-bs-toggle="tab" href="#goods-albums" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">商品图册</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#mobile-images" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">移动端详情</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="base" role="tabpanel">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="lang[goods_name]" class="form-control"
                               placeholder="请输入名称" value="{{$goods->goods_name}}">
                        <tip>填写名称。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">短标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="lang[short_title]" class="form-control"
                               placeholder="请输入短标题" value="{{$goods->short_title ?? ''}}">
                        <tip>填写短标题。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">主图</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="lang[goods_image]" type="hidden" class="form-control" placeholder="请上传主图"
                               value="{{$goods->goods_image ?? ''}}">
                        <input type="file" class="form-control" data-name="lang[goods_image]" cms-upload
                               data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">描述</label>
                    <div class="col-sm-10">
                            <textarea name="lang[description]" class="form-control"
                                      placeholder="请输入描述">{{$goods->description ?? ''}}</textarea>
                        <tip>填写描述。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">详情</label>
                    <div class="col-sm-10">
                            <textarea id="lang[content]" name="lang[content]" rows="20" class="editor"
                                      placeholder="请输入内容">{{$goods->content ?? ''}}</textarea>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="goods-albums" role="tabpanel">
                @if(isset($goods->goods_albums))
                    @foreach($goods->goods_albums as $key => $albums)
                        <div class="layui-card">
                            <div class="layui-card-header">商品图册<a href="javascript:"
                                                                      style="color: #1e9fff;margin-left: 5px;"
                                                                      class="delete-item">[ - ]</a></div>
                            <div class="layui-card-body">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                                    <div class="col-sm-10 cms-upload">
                                        <input name="lang[goods_albums][{{$key}}]" type="hidden" class="form-control"
                                               placeholder="请上传图片"
                                               value="{{$albums}}">
                                        <input type="file" class="form-control" data-name="lang[goods_albums][{{$key}}]"
                                               cms-upload data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                                        <div class="my-1 upload-thumb">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="row mb-3" id="albums-button">
                    <label class="col-sm-2 col-form-label text-end-cms"></label>
                    <div class="col-sm-10">
                        <button type="button" id="add-albums-button"
                                class="btn btn-light waves-effect">
                            增加图片 +
                        </button>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="mobile-images" role="tabpanel">

                @foreach($goods->mobile_images ?? [] as $key => $image)
                    <div class="layui-card">
                        <div class="layui-card-header">详情图片<a href="javascript:"
                                                                  style="color: #1e9fff;margin-left: 5px;"
                                                                  class="delete-spec-item">[ - ]</a></div>
                        <div class="layui-card-body">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                                <div class="col-sm-10 cms-upload">
                                    <input name="lang[mobile_images][{{$key}}]" type="hidden" class="form-control"
                                           placeholder="请上传详情图片"
                                           value="{{$image}}">
                                    <input type="file" class="form-control" data-name="lang[mobile_images][{{$key}}]"
                                           cms-upload data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                                    <div class="my-1 upload-thumb">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="row mb-3" id="mobile-button">
                    <label class="col-sm-2 col-form-label text-end-cms"></label>
                    <div class="col-sm-10">
                        <button type="button" id="add-mobile-button"
                                class="btn btn-light waves-effect">
                            增加图片 +
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

    <div style="display: none" id="mobile-tpl">
        <div class="layui-card">
            <div class="layui-card-header">详情图片<a href="javascript:" style="color: #1e9fff;margin-left: 5px;"
                                                      class="delete-item">[ - ]</a></div>
            <div class="layui-card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="mobile_images[{num}]" type="hidden" class="form-control" placeholder="请上传详情图片"
                               value="">
                        <input type="file" class="form-control" data-name="mobile_images[{num}]" cms-upload
                               data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none" id="albums-tpl">
        <div class="layui-card">
            <div class="layui-card-header">商品图册<a href="javascript:" style="color: #1e9fff;margin-left: 5px;"
                                                      class="delete-item">[ - ]</a></div>
            <div class="layui-card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="goods_albums[{num}]" type="hidden" class="form-control" placeholder="请上传图片"
                               value="">
                        <input type="file" class="form-control" data-name="goods_albums[{num}]" cms-upload
                               data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('extend-javascript')
    <script src="/mycms/admin/js/pages/goods.js"></script>
    <script>
        goods.langEdit();
    </script>
@endsection
