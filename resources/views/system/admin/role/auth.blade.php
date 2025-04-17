@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">角色名称</label>
            <div class="col-sm-10">
                <input type="text" name="title" readonly class="form-control" value="{{$role->role_name}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 pt-0 col-form-label text-end-cms">一键全选</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="form-check col-md-2">
                        <input type="checkbox" class="form-check-input node-check-all"
                               id="checkAll">
                        <label class="form-check-label" for="checkAll">
                            一键全选
                        </label>
                    </div>
                </div>
            </div>
        </div>

        @foreach($nodes as $fk => $node)
            <div class="row mb-3">
                <label class="col-sm-2 pt-0 col-form-label text-end-cms">{{$node['title']}}</label>
                <div class="col-sm-10">
                    @if(isset($node['children']) && !empty($node['children']))
                        <div class="row">
                            @foreach($node['children'] as $sk => $children)
                                <div class="form-check col-md-2">
                                    <input type="checkbox" class="form-check-input node-check-all"
                                           id="node_{{$fk}}_{{$sk}}"
                                           name="nodes[]"
                                           @if($children['checked']) checked @endif value="{{$children['id']}}">
                                    <label class="form-check-label" for="node_{{$fk}}_{{$sk}}">
                                        {{$children['title']}}
                                    </label>
                                </div>
                                @if(isset($children['children']) && !empty($children['children']))
                                    <div class="row mb-2">
                                        <div class="col-sm-10">
                                            <div class="row">
                                                @foreach($children['children'] as $tk => $sub)
                                                    <div class="form-check col-md-2">
                                                        <input type="checkbox"
                                                               class="form-check-input node_{{$fk}}_{{$sk}}"
                                                               id="node_{{$fk}}_{{$sk}}_{{$tk}}"
                                                               name="nodes[]"
                                                               @if($sub['checked']) checked
                                                               @endif value="{{$sub['id']}}">
                                                        <label class="form-check-label"
                                                               for="node_{{$fk}}_{{$sk}}_{{$tk}}">
                                                            {{$sub['title']}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <input type="hidden" name="id" readonly class="form-control" value="{{$role->id}}">

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
@section('extend-javascript')
    <script>

        myAdmin.listen();

        $('.node-check-all').click(function () {
            let nodeId = $(this).attr('id');
            if ($(this).is(":checked")) {
                $('.' + nodeId).attr('checked', true);
            } else {
                $('.' + nodeId).attr('checked', false);
            }
        });

        $('#checkAll').click(function () {
            if ($(this).is(":checked")) {
                $('input[name="nodes[]"]').attr('checked', true);
            } else {
                $('input[name="nodes[]"]').attr('checked', false);
            }
        });
    </script>
@endsection
