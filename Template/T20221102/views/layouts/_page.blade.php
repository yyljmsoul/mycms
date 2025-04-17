<div class='paginations'>
    @if (($paginator->currentPage()) > 1)
        <a href="{{page_path($paginator->currentPage() - 1)}}" class="prev" title="上一頁"><i
                class="kicon i-larrows"></i></a>
    @endif

    @for($i = $paginator->currentPage() - 2;$i < $paginator->currentPage();$i++)
        @if ($i >= 1)
            <a href='{{page_path($i)}}'>{{$i}}</a>
        @endif
    @endfor

    <span class="page-numbers current">{{$paginator->currentPage()}}</span>

    @for($i = $paginator->currentPage() + 1;$i <= min(10, $paginator->lastPage());$i++)
        @if ($i <= $paginator->currentPage() + 3)
            <a href='{{page_path($i)}}'>{{$i}}</a>
        @endif
    @endfor

    @if ($paginator->currentPage() < min(10, $paginator->lastPage()))
        <a
            href="{{page_path($paginator->currentPage() + 1)}}" class="next" title="下一頁"><i
                class="kicon i-rarrows"></i></a>
    @endif
</div>
