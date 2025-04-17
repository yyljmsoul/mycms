<div class="row mb-3">
    <label class="col-sm-2 col-form-label text-end-cms">富文本</label>
    <div class="col-sm-10">
        <textarea id="html" name="html" rows="20" class="editor"
                  placeholder="请输入内容">@if(!empty($data) && ($data->type == 'html' || $data->type == ''))
                {{$data->content ?? ''}}
            @endif</textarea>
    </div>
</div>
