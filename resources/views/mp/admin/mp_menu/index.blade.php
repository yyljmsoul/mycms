@extends("layouts.common")
@section('page-content-wrapper')

    <style>
        .preview_box {
            width: 300px;
        }

        .type-item {
            display: none;
        }

        .preview_box .mp_name {
            background-color: #323232;
            color: white;
            text-align: center;
            width: 100%;
            height: 40px;
            line-height: 40px;
        }

        .preview_box .mp_body {
            background-color: #f2f2f2;
            width: 100%;
            height: 400px;
        }

        .preview_box .mp_handle {
            width: 100%;
            height: 50px;
            border: 1px solid #dee5e7;
        }

        .preview_box .mp_keyboard {
            border-right: 1px solid #dee5e7;
            background: url(/mycms/admin/images/keyboard.png) no-repeat center;
            height: 50px;
            width: 40px;
            float: left;
        }

        .preview_box .mp_menus {
            float: right;
            width: 234px;
        }

        .preview_box .mp_menu {
            width: 33.33%;
            float: left;
            height: 50px;
            line-height: 50px;
            text-align: center;
            border-right: 1px solid #dee5e7;
            cursor: pointer;
        }

        .preview_box .menu_active {
            background-color: #eee;
        }

        .preview_box .menu_sub {
            width: 100%;
            background-color: white;
            padding-left: 0;
            position: relative;
            border-left: 1px solid #dee5e7;
            border-right: 1px solid #dee5e7;
            border-top: 1px solid #dee5e7;
            margin-bottom: 0;
        }

        .menu_sub li {
            list-style: none;
            width: 100%;
            border-bottom: 1px solid #dee5e7;
        }

    </style>
    <div class="row">
        <div class="col-sm-6 preview_box">
            <div class="mp_name">公众号名称</div>
            <div class="mp_body"></div>
            <div class="mp_handle">
                <div class="mp_keyboard"></div>
                <div class="mp_menus">

                </div>
            </div>
        </div>
        <div class="col-sm-6 edit_box">
            <form id="app-form">

                <input type="hidden" name="mp_id" class="form-control" value="{{request()->route()->parameter('id')}}">
                <input type="hidden" name="pid" class="form-control" value="0">
                <input type="hidden" name="id" class="form-control" value="">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">菜单名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="请输入菜单名称" value="">
                        <tip>填写菜单名称。</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">菜单类型</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="type" id="type">
                            <option value="view">跳转页面</option>
                            <option value="click">回复内容</option>
                            <option value="miniprogram">打开小程序</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3 type-item type-item-view" style="display: flex">
                    <label class="col-sm-2 col-form-label text-end-cms">链接</label>
                    <div class="col-sm-10">
                        <input type="text" name="url" class="form-control" placeholder="请输入链接" value="">
                        <tip>填写链接。</tip>
                    </div>
                </div>

                <div class="row mb-3 type-item type-item-miniprogram">
                    <label class="col-sm-2 col-form-label text-end-cms">appid</label>
                    <div class="col-sm-10">
                        <input type="text" name="appid" class="form-control" placeholder="请输入appid" value="">
                        <tip>填写appid。</tip>
                    </div>
                </div>

                <div class="row mb-3 type-item type-item-miniprogram">
                    <label class="col-sm-2 col-form-label text-end-cms">小程序地址</label>
                    <div class="col-sm-10">
                        <input type="text" name="path" class="form-control" placeholder="请输入小程序地址" value="">
                        <tip>填写小程序地址。</tip>
                    </div>
                </div>

                <div class="row mb-3 type-item type-item-click">
                    <label class="col-sm-2 col-form-label text-end-cms">回复内容</label>
                    <div class="col-sm-10">
                        <textarea name="event_text" class="form-control"></textarea>
                    </div>
                </div>

                <div class="row mb-3 type-item type-item-click">
                    <label class="col-sm-2 col-form-label text-end-cms">回复图片</label>
                    <div class="col-sm-10 cms-upload">
                        <input name="event_image" type="hidden" class="form-control" value="">
                        <input type="file" class="form-control" data-name="event_image" cms-upload data-max-size="2"
                               data-upload-exts=".ico,.png,.jpg,.jpeg">
                        <div class="my-1 upload-thumb">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="sort" class="form-control" placeholder="请输入排序" value="0">

                <div class="hr-line"></div>
                <div class="layui-form-item text-center">
                    <button type="submit" class="btn btn-primary waves-effect waves-light" data-refresh="false">保存
                    </button>
                    <button type="reset" class="btn btn-light waves-effect">重置</button>
                    <button type="button" id="delete" class="btn btn-danger waves-effect">删除此菜单</button>
                    <button type="button" id="release" class="btn btn-success waves-effect">一键发布菜单</button>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('extend-javascript')
    <script>

        var result = [];
        var menus = [];

        myAdmin.form('#app-form', function (response) {
            myAdmin.message.success(response.msg, function () {
                location.reload();
            })
        });

        myAdmin.request.get('/admin/mp/mp_menu/{{request()->route()->parameter('id')}}', {}, function (response) {

            let menuHtml = '';
            let data = response.data;
            for (let i = 0; i < data.length; i++) {
                if (result[data[i].pid] === undefined) {
                    result[data[i].pid] = [];
                }
                if (menus[data[i].id] === undefined) {
                    menus[data[i].id] = [];
                }
                result[data[i].pid].push(data[i]);
                menus[data[i].id] = data[i];
            }


            for (let i = 0; i < 3; i++) {
                menuHtml += '';
                menuHtml += result[0] && result[0][i]
                    ? '<div class="mp_menu" data-id="' + result[0][i]['id'] + '"><div class="menu_text" data-id="' + result[0][i]['id'] + '" data-level="1">' + result[0][i]['name'] + '<\/div>'
                    : '<div class="mp_menu" data-id="0"><div class="menu_text" data-id="0_' + i + '" data-level="1"><i class="dripicons-plus"><\/i><\/div>';

                let id = result[0] && result[0][i] ? result[0][i]['id'] : 'tmp';
                let childCount = result[id] ? result[id].length : 0;
                let top = (childCount + 1) * 51 + (childCount < 5 ? 53 : 0) + 5;

                menuHtml += '<ul class="menu_sub" style="top: -' + top + 'px">';
                for (let ii = 0; ii < childCount; ii++) {
                    menuHtml += '<li data-id="' + result[id][ii]['id'] + '" data-level="2">' + result[id][ii]['name'] + '<\/li>';
                }
                if (5 - childCount > 0) {
                    menuHtml += '<li data-id="' + i + '_plus" data-pid="' + id + '" data-level="2"><i class="dripicons-plus"><\/i><\/li>';
                }
                menuHtml += '<\/ul>';
                menuHtml += '<\/div>';
            }

            $('.preview_box .mp_menus').html(menuHtml);

            $(".mp_menus").sortable({
                update: function (event, ui) {
                    let data = [];
                    $(ui.item).parents(".mp_menus").find('.mp_menu').each(function () {
                        if ($(this).attr('data-id').indexOf('_') === -1) {
                            data.push($(this).attr('data-id'));
                        }
                    });
                    myAdmin.request.post("{{route('mp.mp_menu.sort', ['id' => request()->route()->parameter('id')])}}", {ids: data}, function () {
                        console.info(data)
                    });
                }
            });
            $(".menu_sub").sortable({
                update: function (event, ui) {
                    let data = [];
                    $(ui.item).parents(".menu_sub").find('li').each(function () {
                        if ($(this).attr('data-id').indexOf('_') === -1) {
                            data.push($(this).attr('data-id'));
                        }
                    });
                    myAdmin.request.post("{{route('mp.mp_menu.sort', ['id' => request()->route()->parameter('id')])}}", {ids: data}, function () {
                        console.info(data)
                    });
                }
            });
        });

        $('body').on('click', '.menu_text,.menu_sub li', function () {
            $('.menu_sub li,.menu_text').removeClass('menu_active');
            $(this).addClass('menu_active');
            let id = $(this).data('id');
            let formObj;

            if (typeof id == 'string' && id.indexOf('_') > -1) {
                let level = $(this).data('level');
                formObj = {
                    "id": '',
                    "mp_id": '{{request()->route()->parameter('id')}}',
                    "pid": 0,
                    "sort": 0,
                    "name": "",
                    "type": "view",
                    "url": "",
                    "appid": "",
                    "path": "",
                    "event_text": "",
                    "event_image": "",
                    "event_key": "",
                };
                if (level === 2) {
                    formObj.pid = $(this).data('pid');
                }

                $('#app-form').attr('action', '{{route('mp.mp_menu.store', ['id' => request()->route()->parameter('id')])}}')
            } else {
                formObj = menus[id];
                $('#app-form').attr('action', '{{route('mp.mp_menu.update', ['id' => request()->route()->parameter('id')])}}')
            }

            for (const idKey in formObj) {
                if (idKey === 'type') {
                    $('#app-form select[name="' + idKey + '"] option').removeAttr('selected');
                    $('#app-form select[name="' + idKey + '"]').find('option[value="' + formObj[idKey] + '"]').attr('selected', 'selected');
                } else if (idKey === 'event_text') {
                    $('#app-form textarea[name="' + idKey + '"]').val(formObj[idKey]);
                } else {
                    $('#app-form input[name="' + idKey + '"]').val(formObj[idKey]);
                }
            }

            $('.type-item').hide();
            $('.type-item-' + formObj['type']).css('display', 'flex');
        });

        $('#type').change(function () {
            $('.type-item').hide();
            $('.type-item-' + $(this).val()).css('display', 'flex');
        });

        $('#release').click(function () {
            myAdmin.request.post("/admin/mp/mp_menu/release", {mp_id: '{{request()->route()->parameter('id')}}'}, function (response) {
                myAdmin.message.success(response.msg);
            });
        });

        $('#delete').click(function () {
            let id = $('input[name="id"]').val();
            if (id) {
                myAdmin.message.confirm("是否确认删除该菜单？", function () {
                    myAdmin.request.post('/admin/mp/mp_menu/destroy', {id: id}, function () {
                        myAdmin.message.success("删除成功", function () {
                            location.reload();
                        })
                    });
                })
            } else {
                myAdmin.message.error('未选中需要删除的菜单');
            }
        });
    </script>
@endsection
