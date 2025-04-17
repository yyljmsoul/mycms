var goods = {
    specs: [],
    create: function () {

        this.spec();
        this.config();
        this.mobile();
        this.albums();

        myAdmin.listen();
    },
    edit: function () {

        this.spec();
        this.config();
        this.mobile();
        this.albums();
        this.specAction();

        myAdmin.listen();
    },
    config: function () {
        $('#add-diy-button').click(
            function () {
                let html = $('#diy-tpl').html();
                $('#diy-button').before(html);
            }
        );
    },
    albums: function () {

        $('.delete-item').unbind("click").click(function () {
            $(this).parents(".layui-card").remove();
        });

        $('#add-albums-button').click(
            function () {

                let html = $('#albums-tpl').html();

                let len = $('#goods-albums').find('input[cms-upload]').length;
                html = html.replaceAll("{num}", len);

                $('#albums-button').before(html);

                $('.delete-item').unbind("click").click(function () {
                    $(this).parents(".layui-card").remove();
                });

                myAdmin.upload();
            }
        );
    },
    mobile: function () {

        $('.delete-item').unbind("click").click(function () {
            $(this).parents(".layui-card").remove();
        });

        $('#add-mobile-button').click(
            function () {

                let html = $('#mobile-tpl').html();

                let len = $('#mobile-images').find('input[cms-upload]').length;
                html = html.replaceAll("{num}", len);

                $('#mobile-button').before(html);

                $('.delete-item').unbind("click").click(function () {
                    $(this).parents(".layui-card").remove();
                });

                myAdmin.upload();
            }
        );
    },
    spec: function () {

        let that = this;

        $('#add-spec-button').click(
            function () {

                let num = 0;

                if ($('.spec-item').length > 0) {
                    let itemNums = [];
                    $('.spec-item').each(function (index, item) {
                        let tmp = parseInt($(item).attr('data-num'));
                        itemNums.push(!isNaN(tmp) ? tmp : 0);
                    });
                    num = Math.max.apply(null, itemNums) + 1;
                }

                let html = $('#spec-tpl').html();
                html = html.replaceAll("{num}", num);

                $('#spec-button').before(html);

                that.specJs();
            }
        );

        this.specJs();

    },
    specJs: function () {

        let that = this;

        $('#make-spec-button').unbind("click").click(function () {
            that.specAction();
        });

        $('.delete-spec-item').unbind("click").click(function () {
            $(this).parents(".layui-card").remove();
        });

        $('.add-spec-val-btn').unbind("click").click(function () {

            let html = $(this).parents(".layui-card").find('.specVal').find('.col-sm-3').eq(0).html();
            let tmpEle = $('<div class="col-sm-3">' + html + '</div>');
            let itemId = $(this).parents(".layui-card").find('.spec-item').attr('data-num');
            tmpEle.find('input').attr('value', '');
            tmpEle.find('input').attr('name', 'specVal[' + itemId + '][]');
            html = tmpEle.html();
            $(this).parents(".layui-card").find('.specVal').find('.row').append('<div class="col-sm-3 mb-1">' + html + '</div>');
        });
    },
    specAction: function () {

        this.specs = [];
        let items = [];
        let values = [];

        let tableEle = $('#spec-table');

        $('.spec-item').each(function (index, item) {

            let val = [];

            $('.specVal').eq(index).find('input').each(function (index, item) {
                if ($(item).val()) {
                    val.push($(item).val());
                }
            });

            if ($(item).val() && val.length > 0) {
                items.push($(item).val());
                values.push(val);
            }

        });

        let html = '';
        let thead = ['商品规格', '图片', '库存', '销售价', '市场价'];

        if (items.length > 0) {

            html += '<thead><tr>';
            for (let i in thead) {
                console.info(i)
                html += i == 0 ? '<th colspan="' + items.length + '">' + thead[i] + '</th>' : '<th rowspan="2">' + thead[i] + '</th>';
            }
            html += '</tr>';

            html += '<tr>';
            for (let i in items) {
                html += '<th>' + items[i] + '</th>'
            }
            html += '</tr></thead>';


            html += this.specTableHtml(values);


            tableEle.html(html);
            tableEle.show();

            myAdmin.upload();
        }
    },
    specArray: function (index, subContext, values) {

        let stringList = values[index];

        for (let i in stringList) {

            let e = stringList[i];

            if (index !== 0) {
                e = subContext + ";" + e;
            }

            if (values.length === 1) {
                this.specs.push(e);
            } else {
                if (index === (values.length - 1) && index !== 0) {
                    this.specs.push(e);
                } else {
                    this.specArray(index + 1, e, values);
                }
            }

        }
    },
    specTableHtml: function (values) {

        let html = '';

        this.specArray(0, '', values);

        if (this.specs.length > 0) {

            for (let ii in this.specs) {

                let item = Object.assign({
                    id: '',
                    img: '',
                    stock: '',
                    shop_price: '',
                    market_price: ''
                }, specArray[this.specs[ii]] ? specArray[this.specs[ii]] : {});

                let array = this.specs[ii].split(";");

                html += '<tr>';

                for (let iii in array) {

                    html += '<td>' + array[iii] + '</td>';
                }

                html += '<td><div class="cms-upload"><input name="spec_ids[' + ii + ']" type="hidden" value="' + item['id'] + '">\n' +
                    '<input name="spec_img[' + ii + ']" type="hidden"  value="' + item['img'] + '">'+
                    '                        <input type="file" class="form-control" data-name="spec_img[' + ii + ']" cms-upload data-max-size="2" data-upload-exts=".ico,.png,.jpg,.jpeg">\n' +
                    '                        <div class="my-1 upload-thumb">\n' +
                    '                        </div></div></td>';

                html += '<td><input class="form-control" placeholder="库存" name="spec_stock[' + ii + ']" value="' + item['stock'] + '"></td>';

                html += '<td><input class="form-control" placeholder="销售价" name="spec_shop_price[' + ii + ']" value="' + item['shop_price'] + '"></td>';

                html += '<td><input class="form-control" placeholder="市场价" name="spec_market_price[' + ii + ']" value="' + item['market_price'] + '"></td>';

                html += '</tr>';
            }
        }

        return html;
    },
    langCreate: function () {

        this.mobile();
        this.albums();
        this.config();

        myAdmin.listen();
    },
    langEdit: function () {

        this.mobile();
        this.albums();
        this.config();

        myAdmin.listen();
    }
};

