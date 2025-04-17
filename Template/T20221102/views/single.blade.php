@include("template::T20221102.views.layouts._header")

<div class="k-main banner" style="background:#f5f5f5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 details">
                <div class="article">
                    <div class="breadcrumb-box" xmlns:v="https://schema.org/#">
                        <ol class="breadcrumb" xmlns:v="https://schema.org/#">
                            <li class="breadcrumb-item" typeof="v:Breadcrumb">
                                <a class="text-dark" rel="v:url" property="v:title"
                                   href="{{system_config('site_url')}}"> {{system_config('site_name')}}</a>
                            </li>
                            <li class="breadcrumb-item" typeof="v:Breadcrumb">
                                <a class="text-dark" rel="v:url" property="v:title"
                                   href="{{category_path($article->category_id)}}">{{$article->category->getModelLang('category','name')}}</a>
                            </li>
                        </ol>
                    </div>
                    <div class="header"><h1 class="title">{{$article->title}}</h1>
                        <div class="meta"><span>{{$article->created_at}} HKT</span><span>作者：{{$article->author}}</span></div>
                    </div>
                    <div class="content">

                        {!! $article->content !!}

                    </div>
                    <div class="footer clearfix">
                        标签：
                        @foreach(article_tags($article->id) as $tag)
                            <a href="{{tag_path($tag['id'])}}" class="tags-link">{{$tag['tag_name']}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            @include("template::T20221102.views.layouts._sidebar")
        </div>
    </div>
</div>

@include("template::T20221102.views.layouts._footer")
