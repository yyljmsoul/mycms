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
                                   href="javascript:">{{$diyPage->page_name}}</a>
                            </li>
                        </ol>
                    </div>
                    <div class="header"><h1 class="title">{{$diyPage->page_name}}</h1>
                    </div>
                    <div class="content">

                        {!! $diyPage->page_content !!}

                    </div>

                </div>
            </div>
            @include("template::T20221102.views.layouts._sidebar")
        </div>
    </div>
</div>

@include("template::T20221102.views.layouts._footer")
