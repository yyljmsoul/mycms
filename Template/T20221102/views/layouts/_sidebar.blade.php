<div class="col-lg-4 sidebar d-none d-lg-block">

    <div class="search_box_02">
        <input type="text" value="" name="keyword" id="keyword" placeholder="用搜索更简单"
                                      class="text_styles">
        <input type="button" value="立即搜索" class="btns" onclick="search();">
    </div>

    <script>
        function search() {
            location.href = '/search/' + $('#keyword').val();
        }
    </script>

    @if(is_home())
        <div class="widget popular-posts">
            <div class="title">热门文章</div>
            <ul class="wpp-list wpp-list-with-thumbnails">
                @foreach($articles = articles(1,15,'hot') as $article)
                    <li>
                        <a href="{{single_path($article->id)}}" target="_self">
                            <img src='{{$article->img ?: output_template_config('default-img','common')}}'
                                 style="width: 75px;height: 75px;"
                                 height="75px" alt="{{$article->title}}"
                                 class="lazyload wpp-thumbnail wpp_featured wpp_cached_thumb"/></a>
                        <a
                            href="{{single_path($article->id)}}"
                            class="wpp-post-title" target="_self" style="word-break: normal;">{{$article->title}}</a>
                        <span
                            class="wpp-meta post-stats"><span
                                class="wpp-author">{{$article->category->name}}</span> | <span
                                class="wpp-date">{{created_at_date($article->created_at)}}</span></span>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="widget popular-posts">
            <div class="title">最新文章</div>
            <ul class="wpp-list wpp-list-with-thumbnails">
                @foreach($articles = articles(1,15,'new') as $article)
                    <li>
                        <a href="{{single_path($article->id)}}" target="_self">
                            <img src='{{$article->img ?: ''}}'
                                 style="width: 75px;height: 75px;"
                                 height="75px" alt="{{$article->title}}"
                                 class="lazyload wpp-thumbnail wpp_featured wpp_cached_thumb"/></a>
                        <a
                            href="{{single_path($article->id)}}"
                            class="wpp-post-title" target="_self" style="word-break: normal;">{{$article->title}}</a>
                        <span
                            class="wpp-meta post-stats"><span
                                class="wpp-author">{{$article->category->name}}</span> | <span
                                class="wpp-date">{{created_at_date($article->created_at)}}</span></span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
