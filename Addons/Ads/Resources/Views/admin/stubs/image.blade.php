@if(!empty($data) && $data->type == 'image')
    @foreach(json_decode($data->content, true) ?? [] as $key => $image)
        <fieldset>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label text-end-cms">图片</label>
                <div class="col-sm-10 cms-upload">
                    <input name="image[path][{{$key}}]" type="hidden" class="form-control" placeholder="请上传缩略图"
                           value="{{$image['path']}}">
                    <input type="file" class="form-control" data-name="image[path][{{$key}}]" cms-upload data-max-size="2"
                           data-upload-exts=".ico,.png,.jpg,.jpeg">
                    <div class="my-1 upload-thumb">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label text-end-cms">链接</label>
                <div class="col-sm-10">
                    <input type="text" name="image[url][{{$key}}]" class="form-control" placeholder="请输入链接"
                           value="{{$image['url']}}">
                </div>
            </div>
        </fieldset>
    @endforeach
@else
    <fieldset>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">图片</label>
            <div class="col-sm-10 cms-upload">
                <input name="image[path][0]" type="hidden" class="form-control" placeholder="请上传缩略图"
                       value="">
                <input type="file" class="form-control" data-name="image[path][0]" cms-upload data-max-size="2"
                       data-upload-exts=".ico,.png,.jpg,.jpeg">
                <div class="my-1 upload-thumb">
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">链接</label>
            <div class="col-sm-10">
                <input type="text" name="image[url][0]" class="form-control" placeholder="请输入链接" value="">
            </div>
        </div>
    </fieldset>
@endif


<div class="row mb-3" id="add-image">
    <label class="col-sm-2 col-form-label text-end-cms"></label>
    <div class="col-sm-10">
        <button type="button" id="add-image-button"
                class="btn btn-light waves-effect">新增链接 +
        </button>
    </div>
</div>
