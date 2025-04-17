
@if(!empty($data) && $data->type == 'link')
    @foreach(json_decode($data->content, true) ?? [] as $link)
        <div class="row mb-3">
            <div class="layui-inline">
                <label class="col-sm-2 col-form-label text-end-cms">超链接</label>
                <div class="layui-input-inline">
                    <input type="text" name="link[text][]" placeholder="文本" autocomplete="off"
                           class="form-control" value="{{$link['text']}}">
                </div>
            </div>

            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" name="link[url][]" placeholder="链接" autocomplete="off"
                           class="form-control" value="{{$link['url']}}">
                </div>
            </div>

        </div>

    @endforeach
@endif
<div class="row mb-3">

    <label class="col-sm-2 col-form-label text-end-cms">超链接</label>
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-6">
                <input type="text" name="link[text][]" placeholder="文本" autocomplete="off"
                       class="form-control" value="">
            </div>
            <div class="col-sm-6">
                <input type="text" name="link[url][]" placeholder="链接" autocomplete="off"
                       class="form-control" value="">
            </div>
        </div>
    </div>

</div>

<div class="row mb-3" id="add-link">
    <label class="col-sm-2 col-form-label text-end-cms"></label>
    <div class="col-sm-10">
        <button type="button" id="add-link-button"
                class="btn btn-light waves-effect">新增链接 +
        </button>
    </div>
</div>


