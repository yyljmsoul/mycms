<div class="k-footer">
    <div class="f-toolbox">
        <div class="gotop ">
            <div class="gotop-btn"><span class="kicon i-up"></span></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                @if ($links = friend_link())
                <p class="social" style="line-height: 30px">
                    友情链接
                    @foreach($links as $link)
                        | <a href="{{$link->url}}" target="{{$link->target}}">{{$link->name}}</a>
                    @endforeach
                </p>
                @endif
                <p class="social" style="line-height: 30px">本站部分文章来自网络，仅代表原作者观点。如有发现侵权/违规内容，请向{{output_template_config('email','common')}}反馈，一经核实马上删除</p>
                <p>©{{date('Y')}} {{system_config('site_name')}}. ALL RIGHTS RESERVED. 本网站由<a href="https://www.mycms.net.cn/" target="_blank">MyCms</a>强力驱动 </p>
            </div>
        </div>
    </div>
</div>

<script src="/mycms/cms/theme/T20221102/static/js/cd0f65bfb7634fce92f14ac530c7c3da.js"></script>
<script src="/mycms/cms/theme/T20221102/static/js/4f5c704916ca5cde564a09dffce77594.js"></script>
</body>
</html>
