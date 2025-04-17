@extends("layouts.common")
@section('page-content-wrapper')
    <style>
        #spec-table th {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <script>
        specArray = [];
    </script>
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
                <a class="nav-link" data-bs-toggle="tab" href="#tab-specs" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">规格配置</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#mobile-images" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">移动端详情</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#diy-config" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">自定义配置</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="base" role="tabpanel">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商品分类</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="category_id" id="category_id">
                            <option value="0">选择商品分类</option>
                            @foreach($categories as $item)
                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="goods_name" class="form-control"
                               placeholder="请输入名称" value="">
                        <tip>填写名称。</tip>
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

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">主图</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="goods_image" type="hidden" class="form-control" placeholder="请上传主图"
                               value="">
                        <input type="file" class="form-control" data-name="goods_image" cms-upload
                               data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">售价</label>
                    <div class="col-sm-10">
                        <input type="text" name="shop_price" class="form-control"
                               placeholder="请输入售价" value="">
                        <tip>填写售价。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">市场价</label>
                    <div class="col-sm-10">
                        <input type="text" name="market_price" class="form-control"
                               placeholder="请输入市场价" value="">
                        <tip>填写市场价。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">库存</label>
                    <div class="col-sm-10">
                        <input type="text" name="stock" class="form-control"
                               placeholder="请输入库存" value="0">
                        <tip>填写库存。</tip>
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

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">详情</label>
                    <div class="col-sm-10">
                            <textarea id="content" name="content" rows="20" class="editor"
                                      placeholder="请输入内容"></textarea>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="goods-albums" role="tabpanel">

                <div class="layui-card">
                    <div class="layui-card-header">商品图册<a href="javascript:"
                                                              style="color: #1e9fff;margin-left: 5px;"
                                                              class="delete-item">[ - ]</a></div>
                    <div class="layui-card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                            <div class="col-sm-10 cms-upload">
                                <input name="goods_albums[0]" type="hidden" class="form-control" placeholder="请上传图片"
                                       value="">
                                <input type="file" class="form-control" data-name="goods_albums[0]" cms-upload
                                       data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                                <div class="my-1 upload-thumb">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
            <div class="tab-pane" id="tab-specs" role="tabpanel">

                <div class="layui-card">
                    <div class="layui-card-header">商品规格项<a href="javascript:"
                                                                style="color: #1e9fff;margin-left: 5px;"
                                                                class="delete-spec-item">[ - ]</a></div>
                    <div class="layui-card-body">
                        <div class="row mb-3">

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label text-end-cms">规格名</label>
                                <div class="col-sm-10">
                                    <div class="col-sm-3">
                                        <input type="text" name="spec[0]" class="form-control spec-item"
                                               data-num="0"
                                               placeholder="规格名称" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label text-end-cms">规格值</label>
                                <div class="col-sm-10 specVal">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <input type="text" name="specVal[0][]" class="form-control"
                                                   placeholder="规格值"
                                                   value="">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="specVal[0][]" class="form-control"
                                                   placeholder="规格值"
                                                   value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label text-end-cms"></label>
                                <div class="col-sm-10">
                                    <button type="button" class="add-spec-val-btn btn btn-light waves-effect">
                                        新增规格值
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row mb-3" id="spec-button">
                    <label class="col-sm-2 col-form-label text-end-cms"></label>
                    <div class="col-sm-10">
                        <button type="button" id="add-spec-button" class="btn btn-light waves-effect">
                            增加规格 +
                        </button>

                        <button type="button" id="make-spec-button"
                                class="btn btn-light waves-effect">
                            刷新规格表格
                        </button>
                    </div>
                </div>

                <div class="layui-form">
                    <table class="table table-striped" id="spec-table" style="display: none">

                    </table>
                </div>

            </div>
            <div class="tab-pane" id="mobile-images" role="tabpanel">

                <div class="layui-card">
                    <div class="layui-card-header">详情图片<a href="javascript:"
                                                              style="color: #1e9fff;margin-left: 5px;"
                                                              class="delete-item">[ - ]</a></div>
                    <div class="layui-card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                            <div class="col-sm-10 cms-upload">
                                <input name="mobile_images[0]" type="hidden" class="form-control"
                                       placeholder="请上传详情图片"
                                       value="">
                                <input type="file" class="form-control" data-name="mobile_images[0]" cms-upload
                                       data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">
                                <div class="my-1 upload-thumb">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
            <div class="tab-pane" id="diy-config" role="tabpanel">

                <div class="row mb-3 meta-item">
                    <label class="col-sm-2 col-form-label text-end-cms">配置</label>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" name="attr[ident][]" class="form-control" placeholder="配置标识"
                                       value="">
                            </div>
                            <div class="col-sm-3">
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

    <div style="display: none" id="spec-tpl">
        <div class="layui-card">
            <div class="layui-card-header">商品规格项<a href="javascript:" style="color: #1e9fff;margin-left: 5px;"
                                                        class="delete-spec-item">[ - ]</a></div>
            <div class="layui-card-body">
                <div class="row mb-3">

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">规格名</label>
                        <div class="col-sm-10">
                            <div class="col-sm-3">
                                <input type="text" name="spec[{num}]" class="form-control spec-item"
                                       data-num="0"
                                       placeholder="规格名称" value="">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">规格值</label>
                        <div class="col-sm-10 specVal">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="specVal[{num}][]" class="form-control"
                                           placeholder="规格值"
                                           value="">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="specVal[{num}][]" class="form-control"
                                           placeholder="规格值"
                                           value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms"></label>
                        <div class="col-sm-10">
                            <button type="button" class="add-spec-val-btn btn btn-light waves-effect">
                                新增规格值
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none" id="diy-tpl">
        <div class="row mb-3 meta-item">
            <label class="col-sm-2 col-form-label text-end-cms">配置</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-3">
                        <input type="text" name="attr[ident][]" class="form-control" placeholder="配置标识" value="">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="attr[value][]" class="form-control" placeholder="配置值" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none" id="extend-tpl">
        <div class="row mb-3 meta-item">
            <label class="col-sm-2 col-form-label text-end-cms">配置</label>
            <div class="col-sm-10">
                <div class="col-sm-3">
                    <input type="text" name="attr[ident][]" class="form-control" placeholder="配置标识" value="{ident}">
                </div>
                <div class="col-sm-3">
                    <input type="text" name="attr[value][]" class="form-control" placeholder="配置值" value="{value}">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extend-javascript')
    <script src="/mycms/admin/js/pages/goods.js"></script>
    <script>
        $(document).ready(function () {
            goods.create();
        });
    </script>
@endsection
