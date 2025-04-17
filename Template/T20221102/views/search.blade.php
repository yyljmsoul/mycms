@include("template::T20221102.views.layouts._header")

<div class="k-main banner" style="background:#f5f5f5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 board">
                <div class="breadcrumb-box" xmlns:v="https://schema.org/#">
                    <ol class="breadcrumb" xmlns:v="https://schema.org/#">
                        <li class="breadcrumb-item" typeof="v:Breadcrumb">
                            <a class="text-dark" rel="v:url" property="v:title"
                               href="{{system_config('site_url')}}"> {{system_config('site_name')}}</a>
                        </li>
                        <li class="breadcrumb-item" typeof="v:Breadcrumb">
                            <h1 style="font-size: 18px;margin: 0;"><a class="text-dark" rel="v:url" property="v:title"
                                                                      href="">搜索「{{$keyword}}」的结果</a>
                            </h1>
                        </li>
                    </ol>
                </div>
                @foreach($articles = articles($page,20,'',['search'=>$keyword]) as $article)
                    <div class="article-panel">
                        <div class="a-thumb">
                            <a href="{{single_path($article->id)}}">
                                <img src='{{$article->img ?: output_template_config('default-img','common')}}'
                                     alt="{{$article->title}}"/> </a></div>
                        <div class="a-post ">
                            <div class="header"><a class="label"
                                                   href="{{category_path($article->category_id)}}">{{$article->category->name}}
                                    <i
                                        class="label-arrow"></i></a>
                                <h3 class="title"><a href="{{single_path($article->id)}}">{{$article->title}}</a>
                                </h3></div>
                            <div class="content"><p>{{$article->description}}</p></div>
                        </div>
                        <div class="a-meta"><span class="float-left d-none d-md-block"> <span class="mr-2"><i
                                        class="kicon i-calendar"></i>{{created_at_date($article->created_at)}}</span> </span>
                            <span
                                class="float-left d-block"> <span class="mr-2"><i class="kicon i-hot"></i>{{$article->view}} views</span> </span>
                            <span class="float-right"> <a
                                    href="{{single_path($article->id)}}">more<i
                                        class="kicon i-rightbutton"></i></a> </span></div>
                    </div>
                @endforeach

                {{ $articles->links('template::T20221102.views.layouts._page') }}

            </div>
            @include("template::T20221102.views.layouts._sidebar")
        </div>
    </div>
</div>

@include("template::T20221102.views.layouts._footer")
