let myAdmin = {
    history: [],
    uploadObjArray: [],
    listen: function () {
        this.uploadObjArray = [];
        this.form();
        this.editor();
        this.upload();
    },
    form: function (selector, callback) {

        selector = selector ? selector : '#app-form';

        $(selector).parsley().on('form:submit', function (form) {

            let url = form.element.action;
            if (url === undefined || url === '' || url === null) {
                url = window.location.href;
            }

            let data = $(form.element).serializeArray();
            let editorList = document.querySelectorAll(".editor");

            if (editorList.length > 0) {
                $.each(editorList, function (i, v) {
                    let name = $(this).attr("id");
                    if (name) {
                        let content = '';
                        if (defaultEditor === '' || defaultEditor === 'ck') {
                            content = CKEDITOR.instances[name].getData();
                        } else {
                            content = UE.getEditor(name).getContent()
                        }

                        data.push({name: name, value: content})
                    }
                });
            }

            myAdmin.request.post(url, data, function (res) {
                if (callback === undefined) {
                    myAdmin.message.success(res.msg, function (res) {
                        let refresh = $(selector).find('[type="submit"]').data('refresh');
                        if (refresh == undefined || refresh != false) {
                            $.pjax({url: myAdmin.history[myAdmin.history.length - 1], container: '#main-content'})
                        }
                    });
                } else {
                    callback(res);
                }
            });

            return false;
        });
    },
    editor: function () {

        let editorList = document.querySelectorAll(".editor");

        if (editorList.length > 0) {
            if (defaultEditor === '' || defaultEditor === 'ck') {
                $.each(editorList, function (i, v) {
                    CKEDITOR.replace(
                        $(this).attr("name"),
                        {
                            height: 400,
                            filebrowserImageUploadUrl: '/' + SYSTEM_PREFIX + '/upload',
                            fileTools_requestHeaders: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                });
            } else if (defaultEditor === 'md') {
                $.each(editorList, function (i, v) {
                    $(this).parent().html('<div id="'+$(this).attr("name")+'"><textarea name="content" rows="20" class="editor">'+$(this).val()+'</textarea></div>');
                    editormd($(this).attr("name"), {
                        height: 500,
                        path: "/mycms/admin/editormd/lib/",
                        imageUpload    : true,
                        imageFormats   : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                        imageUploadURL : '/' + SYSTEM_PREFIX + '/upload',
                    });
                });
            } else {
                $.each(editorList, function (i, v) {
                    UE.delEditor($(this).attr("name"))
                    UE.getEditor($(this).attr("name"), {
                        initialFrameWidth: null,
                        initialFrameHeight: 400,
                        serverUrl: '/' + SYSTEM_PREFIX + '/upload'
                    });
                });
            }
        }

    },
    upload: function () {

        $('input[cms-upload]').each(function (index, item) {
            let object = $(item);

            let exts = object.data("upload-exts");
            let maxFilesize = object.data("max-size");
            let number = object.data("upload-number");
            let name = object.data("name");
            let paramName = object.data("param-name");

            if (myAdmin.uploadObjArray[name] === undefined) {

                object.dropzone({
                    url: '/' + SYSTEM_PREFIX + '/upload',
                    //maxFiles: number ? null : 1,
                    paramName: paramName ? paramName : "file",
                    maxFilesize: maxFilesize ? maxFilesize : 2,
                    acceptedFiles: exts ? exts : ".ico,.png,.jpg,.jpeg",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function () {
                        this.on("success", function (file, data) {
                            data = eval('(' + data + ')');
                            let element = $('input[name="' + name + '"]');
                            let field = element.attr('data-field');
                            element.val(data[field ? field : 'url']);
                            element.parents(".cms-upload").find(".upload-thumb")
                                .html('<img class="img-thumbnail mx-1" style="width: 100px;max-height: 100px" src="' + data.url + '" data-holder-rendered="true">');
                        });
                        this.on("error", function (file, data) {
                            myAdmin.message.error(data.msg ? data.msg : data);
                        });
                    }
                });

                let img = $('input[name="' + name + '"]').val();

                if (img) {

                    $('input[name="' + name + '"]')
                        .parents(".cms-upload").find(".upload-thumb")
                        .html('<img class="img-thumbnail mx-1" style="width: 100px;max-height: 100px" src="' + img + '" data-holder-rendered="true">');
                }

                object.click(function (e) {
                    e.preventDefault();
                });

                myAdmin.uploadObjArray[name] = 1;
            }

        });
    },
    table: function (init, cols, toolbar, page, params) {

        page = page ? page : 1;
        params = params !== undefined ? params : {};
        params = Object.assign(params, {page: page});

        page === 1 && $('.btn-toolbar .button-items').html(myAdmin.tableToolBar(init, toolbar, params));

        $('.search-bar').html(myAdmin.tableSearchBar(init, cols));

        $('#search-btn').click(function () {

            let searchParams = {};
            $('.search-field').each(function () {
                searchParams[$(this).attr('id').replace("search-filter-", "")] = $(this).val();
            });

            myAdmin.table(init, cols, toolbar, page, {filter: JSON.stringify(searchParams)});
        });

        myAdmin.request.get(init.index_url, params, function (res) {

            let colsLength = cols.length;
            let theadHtml = '<thead><tr>';
            let tbody = '<tbody>';

            for (let i = 0; i < colsLength; i++) {
                if (cols[i].type === 'checkbox') {
                    theadHtml += '<th><input class="form-check-input" type="checkbox" id="checkAll"></th>';
                } else if (cols[i]['title'] !== undefined) {
                    theadHtml += '<th>' + cols[i].title + '</th>';
                }
            }

            theadHtml += '</tr></thead>';

            if (res.total > 0) {
                for (let i in res.data) {

                    tbody += '<tr>';
                    let data = res.data[i];

                    for (let cl = 0; cl < colsLength; cl++) {

                        if (cols[cl]['field'] !== undefined) {

                            let value = '';
                            let fields = cols[cl]['field'].split(".");

                            if (fields.length === 1) {
                                value = data[fields[0]] !== undefined ? data[fields[0]] : '';
                            } else {
                                value = data[fields[0]] ? data[fields[0]][fields[1]] : '';
                            }

                            if (cols[cl]['callback'] !== undefined) {
                                value = cols[cl]['callback'](value, data);
                            } else if (cols[cl]['selectList'] !== undefined) {
                                value = '<div class="form-check form-switch mb-3" dir="ltr">\n' +
                                    '   <input type="checkbox" class="form-check-input customSwitch" data-id="' + data['id'] + '" data-field="' + cols[cl]['field'] + '" ' + (value ? 'checked=""' : '') + '>\n' +
                                    '</div>';
                            } else if (cols[cl].type === 'image') {

                                if (value) {
                                    value = '<img src="' + value + '" class="rounded avatar-sm">';
                                }
                            }

                            tbody += '<td>' + value + '</td>';

                        } else if (cols[cl].type === 'checkbox') {

                            let field = cols[cl].name ? cols[cl].name : 'id';
                            tbody += '<td><input class="form-check-input" type="checkbox" name="ids[]" value="' + (data[field] ? data[field] : '') + '"></td>';

                        } else if (cols[cl]['operate'] !== undefined) {
                            tbody += myAdmin.tableOperate(init, cols[cl]['operate'], data, {});
                        }
                    }

                    tbody += '</tr>';
                }
            }

            tbody += '</tbody>';

            $(init.table_elem).html(theadHtml + tbody);

            $(".table-responsive").responsiveTable({addDisplayAllBtn: false, addFocusBtn: false});

            $(init.table_elem).DataTable({
                "searching": false,
                "ordering": false,
                "lengthChange": false,
                "pageLength": res.per_page,
                "initUrl": init.index_url,
                "pageTotal": res.total,
                "currentPage": res.current_page,
                "lastPage": res.last_page,
                "destroy": true,
                "language": {
                    "info": "共" + res.total + "条记录，当前是第" + res.current_page + "页，共" + res.last_page + "页",
                    "infoEmpty": "共0条记录",
                    "infoFiltered": "",
                    "emptyTable": "没有找到数据记录",
                    "paginate": {
                        "first": "首页",
                        "last": "末页",
                        "next": "下一页",
                        "previous": "上一页"
                    },
                }
            });

            $('.page-item').on('click', function () {
                let page = $(this).text();
                switch (page) {
                    case "上一页":
                        page = res.current_page - 1;
                        break;
                    case "下一页":
                        page = res.current_page + 1;
                        break;
                }

                if (page > 0 && page <= res.last_page) {
                    myAdmin.table(init, cols, toolbar, page, params);
                }
            });

            $("#checkAll").click(function () {
                let element = $(init.table_elem).find("[name='ids[]']");
                if ($(this).is(":checked")) {
                    element.attr("checked", true);
                } else {
                    element.attr("checked", false);
                }
            });

            $('.customSwitch').change(function () {
                if (init.modify_url !== undefined) {
                    let data = {
                        id: $(this).data('id'),
                        field: $(this).data('field'),
                        value: $(this).is(':checked') ? 1 : 0,
                    };
                    myAdmin.request.post(init.modify_url, data)
                }
            });

            $('.btn[data-request]').click(function () {
                let title = $(this).data('title');
                let request = $(this).data('request');

                myAdmin.message.confirm(title, function () {
                    myAdmin.request.get(request, {}, function (res) {
                        myAdmin.message.success(res.msg, function () {
                            location.reload();
                        });
                    });
                })
            });

            $('.copy-btn').click(function () {
                myAdmin.copyText($(this).data('text'));
                myAdmin.message.success('复制成功');
            });

            $('.ajaxRequest').click(function (e) {
                e.preventDefault();
                let reqPath = $(this).attr('href');
                myAdmin.request.post(reqPath, {}, function (response) {
                    myAdmin.message.success(response.msg);
                });
            });

            myAdmin.deleteOperate(init);

            if (typeof toolbar === 'function') {
                toolbar();
            }
        });
    },
    tableOperate: function (init, operate, data, params) {

        let operateHtml = '<td>';

        for (let i = 0; i < operate.length; i++) {

            if (operate[i] === 'edit') {
                if (myAdmin.rolePermission(init.edit_url)) {
                    operateHtml += '<a href="' + myAdmin.concatQueryParam(init.edit_url, Object.assign(params, {
                        id: data['id']
                    })) + '" class="mx-1 btn btn-sm btn-primary waves-effect waves-light">编辑</a>';
                }

            } else if (operate[i] === 'delete') {
                if (myAdmin.rolePermission(init.delete_url)) {
                    operateHtml += '<a href="javascript:" data-id="' + data['id'] + '" class="deleteOperate mx-1 btn btn-sm btn-danger waves-effect waves-light">删除</a>';
                }
            } else if (typeof operate[i] === 'object') {
                if (myAdmin.rolePermission(operate[i]['url'])) {
                    let target = operate[i]['target'] ? operate[i]['target'] : '_self';
                    let paramKey = operate[i]['param_key'] ? operate[i]['param_key'] : "id";
                    let param = {};
                    param[paramKey] = data[operate[i]['value_key'] ? operate[i]['value_key'] : 'id'];
                    operateHtml += '<a href="' + myAdmin.concatQueryParam(operate[i]['url'], Object.assign(params, param)) + '" class="mx-1 btn btn-sm ' + operate[i]['class'] + ' waves-effect waves-light" target="' + target + '">' + operate[i]['text'] + '</a>';
                }
            } else if (typeof operate[i] === 'function') {
                operateHtml += operate[i](data, params);
            }
        }

        operateHtml += '</td>';

        return operateHtml;
    },
    tableToolBar: function (init, toolbar, params) {

        toolbar = toolbar ? toolbar : ['add', 'delete'];

        let toolbarHtml = '';

        for (let i = 0; i < toolbar.length; i++) {

            if (toolbar[i] === 'add') {
                if (myAdmin.rolePermission(init.add_url)) {
                    toolbarHtml += '<a href="' + myAdmin.concatQueryParam(init.add_url, params) + '" class="mx-1 btn btn-primary waves-effect waves-light">添加</a>';
                }
            } else if (toolbar[i] === 'delete') {
                if (myAdmin.rolePermission(init.delete_url)) {
                    toolbarHtml += '<a href="javascript:" id="deleteToolBar" class="mx-1 btn btn-danger waves-effect waves-light">删除</a>';
                }
            } else if (toolbar[i] === 'config') {
                if (myAdmin.rolePermission(init.config_url)) {
                    toolbarHtml += '<a href="' + myAdmin.concatQueryParam(init.config_url, params) + '" class="mx-1 btn btn-light waves-effect waves-light">配置</a>';
                }
            } else if (typeof toolbar[i] === 'object') {
                if (myAdmin.rolePermission(toolbar[i]['url'])) {
                    toolbarHtml += '<a href="' + myAdmin.concatQueryParam(toolbar[i]['url'], params) + '" class="mx-1 btn ' + toolbar[i]['class'] + ' waves-effect waves-light">' + toolbar[i]['text'] + '</a>';
                }
            } else if (typeof toolbar[i] === 'function') {
                toolbarHtml += toolbar[i](params);
            }
        }

        toolbarHtml += '';

        return toolbarHtml;
    },
    deleteOperate: function (init) {

        $('#deleteToolBar').click(function () {
            if ($('input[name="ids[]"]:checked').length > 0) {
                myAdmin.message.confirm("是否确认删除这些记录？", function () {
                    let ids = [];
                    $('input[name="ids[]"]:checked').each(function () {
                        ids.push($(this).val());
                    });
                    myAdmin.request.post(init.delete_url, {id: ids}, function () {
                        myAdmin.message.success("删除成功", function () {
                            location.reload();
                        })
                    });
                });
            } else {
                myAdmin.message.error("请选择要删除的记录")
            }
        });

        $('.deleteOperate').click(function () {
            let id = $(this).data('id');
            myAdmin.message.confirm("是否确认删除该记录？", function () {
                myAdmin.request.post(init.delete_url, {id: id}, function () {
                    myAdmin.message.success("删除成功", function () {
                        location.reload();
                    })
                });
            });
        });
    },
    tableSearchBar: function (init, cols) {

        let html = '';
        let searchFields = [];

        for (let i = 0; i < cols.length; i++) {
            if (cols[i]['search'] === true) {
                searchFields.push(cols[i]);
            }
        }

        if (searchFields.length > 0) {
            for (let i = 0; i < searchFields.length; i++) {
                if (searchFields[i].selectList !== undefined) {
                    html += '<div class="row" style="min-width: 100px"><label class="col-sm-4 col-form-label text-end-cms" style="padding-left: 0;padding-right: 0">' + searchFields[i].title + '</label><div class="col-sm-8"><select class="form-select search-field" id="search-filter-' + searchFields[i].field + '">';
                    html += '<option value="">请选择' + searchFields[i].title + '</option>';
                    for (let ii in searchFields[i].selectList) {
                        html += '<option value="' + ii + '">' + searchFields[i].selectList[ii] + '</option>';
                    }
                    html += '</select></div></div>';
                } else {
                    html += '<div class="row" style="max-width: 220px;justify-content: flex-end;"><label class="col-sm-2 col-form-label text-end-cms" style="padding-left: 0;padding-right: 0">' + searchFields[i].title + '</label>' + '<div class="col-sm-8"><input type="text" class="form-control search-field" placeholder="请输入搜索' + searchFields[i].title + '" id="search-filter-' + searchFields[i].field + '" value=""></div></div>';
                }
            }

            html += '<div class="row" style="margin-left: 15px"><button type="button"  id="search-btn" class="btn btn-primary waves-effect waves-light btn-sm">搜索</button></div>';
        }

        return html;
    },
    message: {
        common: function (message, icon, callback, title) {
            let alert = Swal.fire({
                title: title ? title : '系统提示',
                text: message ? message : '操作失败',
                icon: icon ? icon : "success",
                confirmButtonColor: "#525ce5",
            });

            if (callback !== undefined) {
                alert.then(callback);
            }
        },
        success: function (message, callback, title) {
            myAdmin.message.common(message, "success", callback, title);
        },
        error: function (message, callback, title) {
            myAdmin.message.common(message, "warning", callback, title);
        },
        confirm: function (message, callback) {
            let alert = Swal.fire({
                title: '系统提示',
                text: message,
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#1cbb8c",
                cancelButtonColor: "#f14e4e",
                confirmButtonText: "确定",
                cancelButtonText: "取消",
            });

            if (callback !== undefined) {
                alert.then(function (t) {
                    t.value && callback();
                });
            }
        }
    },
    request: {
        post: function (url, data, callback) {
            myAdmin.request.ajax(url, "POST", data, callback);
        },
        get: function (url, data, callback) {
            myAdmin.request.ajax(url, "GET", data, callback);
        },
        ajax: function (url, method, data, callback) {
            url = url.replace("/admin/", '/' + SYSTEM_PREFIX + '/');
            $.ajax({
                url: url,
                type: method,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                dataType: "json",
                data: data,
                timeout: 60000,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (callback !== undefined) {
                        callback(res);
                    }
                },
                error: function (res) {
                    myAdmin.message.error(res.responseJSON.msg);
                }
            });
        }
    },
    getQueryParam: function (key, defaultVal) {
        let url = location.search; //获取url中"?"符后的字串
        let theRequest = new Object();
        if (url.indexOf("?") !== -1) {
            let str = url.substr(1);
            let strArray = str.split("&");
            for (let i = 0; i < strArray.length; i++) {
                theRequest[strArray[i].split("=")[0]] = unescape(strArray[i].split("=")[1]);
            }
        }
        return theRequest[key]
            ? theRequest[key]
            : (defaultVal !== undefined ? defaultVal : '');
    },
    concatQueryParam: function (url, array) {

        let delimiter = '?';
        if (url.indexOf("?") !== -1) {
            delimiter = '&';
        }

        url = url + delimiter;
        for (let i in array) {
            url += i + '=' + array[i] + '&';
        }

        return url.substring(0, url.length - 1);
    },
    copyText: function (text) {
        const t = document.createElement("textarea");
        t.value = text,
            document.body.appendChild(t), t.select(),
            document.execCommand("copy"),
            document.body.removeChild(t)
    },
    sortList: function (init) {

        myAdmin.request.get(init.index_url, {limit: 300}, function (response) {
            let html = '';
            let result = [];
            let data = response.data;
            for (let i = 0; i < data.length; i++) {
                data[i].pid = data[i].pid ? data[i].pid : 0;
                if (result[data[i].pid] === undefined) {
                    result[data[i].pid] = [];
                }
                result[data[i].pid].push(data[i]);
            }

            if (result[0]) {
                for (let i = 0; i < result[0].length; i++) {
                    let editOp = myAdmin.rolePermission(init.edit_url) ? `<a href="${init.edit_url}?id=${result[0][i]['id']}"><i class="dripicons-document-edit"></i></a>` : '';

                    html += `<div class="categories-group-card"  data-id="${result[0][i]['id']}">
                    <li class="categories-group-list collapsed">
<input class="form-check-input" style="margin-top: 6px" type="checkbox" name="ids[]" value="${result[0][i]['id']}">
<a href="#collapse${result[0][i]['id']}" data-bs-toggle="collapse"
                       aria-expanded="false" aria-controls="collapse${result[0][i]['id']}">
                         ${result[0][i]['name']}
                        ${result[result[0][i]['id']] ? '<i class="mdi mdi-minus float-end accor-plus-icon"></i>' : ''}
                    </a>${editOp}
                     </li>`;

                    if (result[result[0][i]['id']]) {
                        let child = result[result[0][i]['id']];
                        html += `<div id="collapse${result[0][i]['id']}" class="collapse" data-parent="#accordion">
                        <div>
                            <ul class="list-unstyled categories-list mb-0">`;
                        for (let ii = 0; ii < child.length; ii++) {
                            editOp = myAdmin.rolePermission(init.edit_url) ? `<a href="${init.edit_url}?id=${child[ii]['id']}"><i class="dripicons-document-edit"></i></a>` : '';
                            html += `<li style="padding: 5px 30px;" data-id="${child[ii]['id']}"><i class="mdi mdi-circle-medium me-1"></i> <input class="form-check-input" style="margin-top: 10px" type="checkbox" name="ids[]" data-pid="${result[0][i]['id']}" value="${child[ii]['id']}"> ${child[ii]['name']} ${editOp}</li>`;
                        }
                        html += `</ul>
                        </div>
                    </div>`;
                    }

                    html += `</div>`;
                }

                $(init.table_elem ? init.table_elem : '#sortList').html(html);

                $(".categories-list").sortable({
                    update: function (event, ui) {
                        let data = [];
                        $(ui.item).parents(".categories-list").find('li').each(function () {
                            data.push($(this).attr('data-id'));
                        });
                        myAdmin.request.post(init.sort_url, {ids: data}, function () {

                        });
                    }
                });

                $("#sortList").sortable({
                    update: function (event, ui) {
                        let data = [];
                        $(ui.item).parents("#sortList").find('.categories-group-card').each(function () {
                            data.push($(this).attr('data-id'));
                        });
                        myAdmin.request.post(init.sort_url, {ids: data}, function () {

                        });
                    }
                });
            }
        });

        let addOp = myAdmin.rolePermission(init.add_url) ? `<a href="${init.add_url}"
                   class="mx-1 btn btn-primary waves-effect waves-light">添加</a>` : '';

        let deleteOp = myAdmin.rolePermission(init.delete_url) ? `<a href="javascript:" id="deleteToolBar" class="mx-1 btn btn-danger waves-effect waves-light">删除</a>` : '';

        $('.btn-toolbar .button-items').html(`<a href="javascript:" id="checkAll"
                   class="mx-1 btn btn-info waves-effect waves-light" data-checked="0">全选</a>
                ${addOp}${deleteOp}`);

        myAdmin.deleteOperate(init);

        $("#checkAll").click(function () {
            let element = $("[name='ids[]']");
            if ($(this).attr("data-checked") === "0") {
                element.attr("checked", true);
                $(this).attr("data-checked", 1);
            } else {
                element.attr("checked", false);
                $(this).attr("data-checked", 0);
            }
        });

        $('body').on("click", "[name='ids[]']", function () {
            let id = $(this).val();
            let element = $("[data-pid='" + id + "']");
            if ($(this).is(":checked")) {
                element.attr("checked", true);
            } else {
                element.attr("checked", false);
            }
        });
    },
    rolePermission: function (node) {
        return system_admin_role_id === 1 || (admin_role_nodes.indexOf(node) > -1);
    }
};

