<div class="row mb-3">
    <label class="col-sm-2 col-form-label text-end-cms">代码</label>
    <div class="col-sm-10">
                    <textarea name="script" rows="10" class="form-control"
                              placeholder="请输入内容">@if(!empty($data) && $data->type == 'script')
                            {{$data->content ?? ''}}
                        @endif</textarea>
    </div>
</div>
