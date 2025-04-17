@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#base" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">SEO设置</span>
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
                    <label class="col-sm-2 col-form-label text-end-cms">分页标识</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_current_page_title" class="form-control"
                               placeholder="填写分页标题"
                               value="{{$seoConfig['seo_current_page_title'] ?? ''}}">
                        <tip>填写分页标识，<em style="color: red">{num}</em>:为第几页</tip>
                    </div>
                </div>

                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">站点标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_site_title" class="form-control" placeholder="填写站点标题"
                               value="{{$seoConfig['seo_site_title'] ?? ''}}">
                        <tip>填写站点标题，<em style="color: red">{page}</em>:为分页标识</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">站点关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_site_keyword" class="form-control" placeholder="请输入站点关键词"
                               value="{{$seoConfig['seo_site_keyword'] ?? ''}}">
                        <tip>请输入站点关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">站点描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_site_description"
                                          class="form-control">{{$seoConfig['seo_site_description'] ?? ''}}</textarea>
                    </div>
                </div>

                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">分类标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_category_title" class="form-control" placeholder="填写分类标题"
                               value="{{$seoConfig['seo_category_title'] ?? ''}}">
                        <tip>填写分类名称.<em style="color: red">{name}</em>:为分类名称，<em style="color: red">{sub_name}</em>为分类子名称，<em style="color: red">{description}</em>为分类描述，<em
                                style="color: red">{page}</em>:为 " - 第X页"
                        </tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">分类关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_category_keyword" class="form-control"
                               placeholder="请输入分类关键词"
                               value="{{$seoConfig['seo_category_keyword'] ?? ''}}">
                        <tip>请输入分类关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">分类描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_category_description"
                                          class="form-control">{{$seoConfig['seo_category_description'] ?? ''}}</textarea>
                    </div>
                </div>

                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">文章标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_single_title" class="form-control" placeholder="填写文章标题"
                               value="{{$seoConfig['seo_single_title'] ?? ''}}">
                        <tip>填写文章标题.<em style="color: red">{name}</em>:为文章标题，<em style="color: red">{description}</em>为文章描述，<em
                                style="color: red">{tags}</em>:为文章标签，<em style="color: red">{category}</em>:为文章分类，<em
                                style="color: red">{author}</em>:为文章作者
                        </tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">文章关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_single_keyword" class="form-control" placeholder="请输入文章关键词"
                               value="{{$seoConfig['seo_single_keyword'] ?? ''}}">
                        <tip>请输入文章关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">文章描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_single_description"
                                          class="form-control">{{$seoConfig['seo_single_description'] ?? ''}}</textarea>
                    </div>
                </div>


                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">标签标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_tag_title" class="form-control" placeholder="填写标签标题"
                               value="{{$seoConfig['seo_tag_title'] ?? ''}}">
                        <tip>填写标签标题.<em style="color: red">{name}</em>:为标签名称，<em style="color: red">{description}</em>为标签描述，<em
                                style="color: red">{page}</em>:为 " - 第X页"
                        </tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">标签关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_tag_keyword" class="form-control" placeholder="请输入标签关键词"
                               value="{{$seoConfig['seo_tag_keyword'] ?? ''}}">
                        <tip>请输入标签关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">标签描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_tag_description"
                                          class="form-control">{{$seoConfig['seo_tag_description'] ?? ''}}</textarea>
                    </div>
                </div>


                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">搜索标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_search_title" class="form-control" placeholder="填写搜索标题"
                               value="{{$seoConfig['seo_search_title'] ?? ''}}">
                        <tip>填写搜索标题.<em style="color: red">{keyword}</em>:为关键词，<em
                                style="color: red">{page}</em>:为
                            " - 第X页"
                        </tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">搜索关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_search_keyword" class="form-control" placeholder="请输入搜索关键词"
                               value="{{$seoConfig['seo_search_keyword'] ?? ''}}">
                        <tip>请输入关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">搜索描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_search_description"
                                          class="form-control">{{$seoConfig['seo_search_description'] ?? ''}}</textarea>
                    </div>
                </div>


                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商城标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_store_title" class="form-control" placeholder="填写商城标题"
                               value="{{$seoConfig['seo_store_title'] ?? ''}}">
                        <tip>填写商城标题.<em style="color: red">{page}</em>:为分页标识</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商城关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_store_keyword" class="form-control" placeholder="请输入商城关键词"
                               value="{{$seoConfig['seo_store_keyword'] ?? ''}}">
                        <tip>请输入关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商城描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_store_description"
                                          class="form-control">{{$seoConfig['seo_store_description'] ?? ''}}</textarea>
                    </div>
                </div>


                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商城分类标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_store_category_title" class="form-control"
                               placeholder="填写商城分类标题"
                               value="{{$seoConfig['seo_store_category_title'] ?? ''}}">
                        <tip>填写商城分类标题.<em style="color: red">{name}</em>:为分类名，<em
                                style="color: red">{description}</em>为分类描述，<em
                                style="color: red">{page}</em>:为 " - 第X页"
                        </tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商城分类关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_store_category_keyword" class="form-control"
                               placeholder="请输入商城关键词"
                               value="{{$seoConfig['seo_store_category_keyword'] ?? ''}}">
                        <tip>请输入分类关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商城分类描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_store_category_description"
                                          class="form-control">{{$seoConfig['seo_store_category_description'] ?? ''}}</textarea>
                    </div>
                </div>


                <hr/>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商品标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_store_goods_title" class="form-control" placeholder="填写商品标题"
                               value="{{$seoConfig['seo_store_goods_title'] ?? ''}}">
                        <tip>填写商品标题.<em style="color: red">{name}</em>:为商品标题，<em style="color: red">{description}</em>为商品描述，<em
                                style="color: red">{category}</em>:为商品分类
                        </tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商品关键词</label>
                    <div class="col-sm-10">
                        <input type="text" name="seo_store_goods_keyword" class="form-control"
                               placeholder="请输入商品关键词"
                               value="{{$seoConfig['seo_store_goods_keyword'] ?? ''}}">
                        <tip>请商品关键词</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商品描述</label>
                    <div class="col-sm-10">
                                <textarea name="seo_store_goods_description"
                                          class="form-control">{{$seoConfig['seo_store_goods_description'] ?? ''}}</textarea>
                    </div>
                </div>


            </div>
            @foreach(system_lang() as $abb => $lang)
                <div class="tab-pane" id="lang-{{$abb}}" role="tabpanel">

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">分页标识</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_current_page_title]" class="form-control"
                                   placeholder="填写分页标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_current_page_title'] ?? ''}}">
                            <tip>填写分页标识，<em style="color: red">{num}</em>:为第几页</tip>
                        </div>
                    </div>

                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">站点标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_site_title]" class="form-control"
                                   placeholder="填写站点标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_site_title'] ?? ''}}">
                            <tip>填写站点标题，<em style="color: red">{page}</em>:为分页标识</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">站点关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_site_keyword]" class="form-control"
                                   placeholder="请输入站点关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_site_keyword'] ?? ''}}">
                            <tip>请输入站点关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">站点描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_site_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_site_description'] ?? ''}}</textarea>
                        </div>
                    </div>

                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">分类标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_category_title]" class="form-control"
                                   placeholder="填写分类标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_category_title'] ?? ''}}">
                            <tip>填写分类标题.<em style="color: red">{name}</em>:为分类名，<em
                                    style="color: red">{description}</em>为分类描述，<em
                                    style="color: red">{page}</em>:为 " - 第X页"
                            </tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">分类关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_category_keyword]" class="form-control"
                                   placeholder="请输入分类关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_category_keyword'] ?? ''}}">
                            <tip>请输入分类关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">分类描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_category_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_category_description'] ?? ''}}</textarea>
                        </div>
                    </div>

                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">文章标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_single_title]" class="form-control"
                                   placeholder="填写文章标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_single_title'] ?? ''}}">
                            <tip>填写文章标题.<em style="color: red">{name}</em>:为文章标题，<em
                                    style="color: red">{description}</em>为文章描述，<em
                                    style="color: red">{tags}</em>:为文章标签，<em
                                    style="color: red">{category}</em>:为文章分类，<em
                                    style="color: red">{author}</em>:为文章作者
                            </tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">文章关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_single_keyword]" class="form-control"
                                   placeholder="请输入文章关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_single_keyword'] ?? ''}}">
                            <tip>请输入文章关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">文章描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_single_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_single_description'] ?? ''}}</textarea>
                        </div>
                    </div>


                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">标签标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_tag_title]" class="form-control"
                                   placeholder="填写标签标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_tag_title'] ?? ''}}">
                            <tip>填写标签标题.<em style="color: red">{name}</em>:为标签名称，<em
                                    style="color: red">{description}</em>为标签描述，<em
                                    style="color: red">{page}</em>:为 " - 第X页"
                            </tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">标签关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_tag_keyword]" class="form-control"
                                   placeholder="请输入标签关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_tag_keyword'] ?? ''}}">
                            <tip>请输入标签关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">标签描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_tag_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_tag_description'] ?? ''}}</textarea>
                        </div>
                    </div>


                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">搜索标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_search_title]" class="form-control"
                                   placeholder="填写搜索标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_search_title'] ?? ''}}">
                            <tip>填写搜索标题.<em style="color: red">{keyword}</em>:为关键词，<em
                                    style="color: red">{page}</em>:为
                                " - 第X页"
                            </tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">搜索关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_search_keyword]" class="form-control"
                                   placeholder="请输入搜索关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_search_keyword'] ?? ''}}">
                            <tip>请输入关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">搜索描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_search_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_search_description'] ?? ''}}</textarea>
                        </div>
                    </div>


                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商城标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_store_title]" class="form-control"
                                   placeholder="填写商城标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_store_title'] ?? ''}}">
                            <tip>填写商城标题.<em style="color: red">{page}</em>:为分页标识</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商城关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_store_keyword]" class="form-control"
                                   placeholder="请输入商城关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_store_keyword'] ?? ''}}">
                            <tip>请输入关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商城描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_store_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_store_description'] ?? ''}}</textarea>
                        </div>
                    </div>


                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商城分类标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_store_category_title]"
                                   class="form-control"
                                   placeholder="填写商城分类标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_store_category_title'] ?? ''}}">
                            <tip>填写商城分类标题.<em style="color: red">{name}</em>:为分类名，<em
                                    style="color: red">{description}</em>为分类描述，<em
                                    style="color: red">{page}</em>:为 " - 第X页"
                            </tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商城分类关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_store_category_keyword]"
                                   class="form-control"
                                   placeholder="请输入商城关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_store_category_keyword'] ?? ''}}">
                            <tip>请输入分类关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商城分类描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_store_category_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_store_category_description'] ?? ''}}</textarea>
                        </div>
                    </div>


                    <hr/>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商品标题</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_store_goods_title]" class="form-control"
                                   placeholder="填写商品标题"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_store_goods_title'] ?? ''}}">
                            <tip>填写商品标题.<em style="color: red">{name}</em>:为商品标题，<em
                                    style="color: red">{description}</em>为商品描述，<em
                                    style="color: red">{category}</em>:为商品分类
                            </tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商品关键词</label>
                        <div class="col-sm-10">
                            <input type="text" name="lang[{{$abb}}][seo_store_goods_keyword]"
                                   class="form-control"
                                   placeholder="请输入商品关键词"
                                   value="{{$seoConfig["lang"]["{$abb}"]['seo_store_goods_keyword'] ?? ''}}">
                            <tip>请商品关键词</tip>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label text-end-cms">商品描述</label>
                        <div class="col-sm-10">
                                <textarea name="lang[{{$abb}}][seo_store_goods_description]"
                                          class="form-control">{{$seoConfig["lang"]["{$abb}"]['seo_store_goods_description'] ?? ''}}</textarea>
                        </div>
                    </div>


                </div>
            @endforeach
            <hr/>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary waves-effect waves-light">确认
                </button>
                <button type="reset" class="btn btn-light waves-effect">重置</button>
            </div>

        </div>
    </form>
@endsection
