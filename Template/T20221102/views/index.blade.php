@include("template::T20221102.views.layouts._header")
<div class="k-main banner" style="background:#f5f5f5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 board">
                @foreach($articles = articles(1,10,'new') as $article)
                <div class="article-panel">
                    <div class="a-thumb">
                        <a href="{{single_path($article->id)}}">
                            <img src='{{$article->img ?: output_template_config('default-img','common')}}' alt="{{$article->title}}" /> </a></div>
                    <div class="a-post ">
                        <div class="header"><a class="label" href="{{category_path($article->category_id)}}">{{$article->category->name}}<i
                                    class="label-arrow"></i></a>
                            <h3 class="title"><a href="{{single_path($article->id)}}">{{$article->title}}</a>
                            </h3></div>
                        <div class="content"><p>{{$article->description}}</p></div>
                    </div>
                    <div class="a-meta"><span class="float-left d-none d-md-block"> <span class="mr-2"><i
                                    class="kicon i-calendar"></i>{{created_at_date($article->created_at)}}</span> </span> <span
                            class="float-left d-block"> <span class="mr-2"><i class="kicon i-hot"></i>{{$article->view}} views</span> </span>
                        <span class="float-right"> <a
                                href="{{single_path($article->id)}}">more<i
                                    class="kicon i-rightbutton"></i></a> </span></div>
                </div>
                @endforeach
            </div>
            @include("template::T20221102.views.layouts._sidebar")
        </div>
    </div>
</div>
@include("template::T20221102.views.layouts._footer")
