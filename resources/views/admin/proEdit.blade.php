@extends('admin.master')
@section('content')
    <div class="page-container">
        <div class="form form-horizontal" id="form-user-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    产品名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{$res->info}}" placeholder="" id="proname"
                           name="product-category-name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文字说明：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea id="content" style="height: 300px" cols="" rows="" class="textarea"
                              placeholder="">{{$content->content}}</textarea>
                    <p class="textarea-numberbar" style="color: #999999">商品介绍内容</p>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    商品价格：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{$res->price}}" placeholder="" id="price"
                           name="product-category-name">
                </div>
            </div>


            <div class="page-container" style="margin-left: 15%">
                <div class="cl pd-5 bg-1 bk-gray mt-20">
                    <span class="l"><a onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a></span>
                    <span class="l"><a onclick="totop({{$res->id}})" class="btn btn-primary radius"
                                       style="margin-left: 15px"><i class="Hui-iconfont">&#xe646;</i> 设为封面</a></span>
                    <span style="color: red;display: none" id="toasts"></span>
                </div>
                <div class="portfolio-content">
                    <ul class="cl portfolio-area">
                        @foreach($img as $k=>$v)
                            <li class="item" id="{{$v->id}}" style="display: block">
                                <div class="portfoliobox">
                                    <input class="checkbox" name="imgid" type="checkbox" onclick="add({{$v->id}})">
                                    <div class="picbox"><a data-lightbox="gallery"><img src="{{$v->address}}"></a></div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <div class="row cl">
                <div class="col-9 col-offset-2">
                    <input class="btn btn-primary radius" value="&nbsp;&nbsp;提交&nbsp;&nbsp;"
                           onclick="sendChange({{$res->id}})" id="res">
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        function totop(idsss) {
            if (ids.length > 1) {
                document.getElementById('toasts').innerHTML = '暂时只支持一张图片设为封面!';
                document.getElementById('toasts').style.display = 'block';
                // alert('添加成功!');
                setTimeout(function () {
                    document.getElementById('toasts').style.display = 'none';
                    document.getElementById('toasts').innerHTML = '';
                }, 1000);
                return;
            }
            let img = ids[0];
            $.ajax({
                url: '/admin/imgtotop/' + img + '/' + idsss,
                type: 'GET',
                success: function (data) {
                    if (data == 'ok') {
                        document.getElementById('toasts').innerHTML = '设置成功!';
                        document.getElementById('toasts').style.display = 'block';
                        // alert('添加成功!');
                        setTimeout(function () {
                            document.getElementById('toasts').style.display = 'none';
                            document.getElementById('toasts').innerHTML = '';
                        }, 1000);
                    }
                },
                error: function (data, status, sts) {
                }

            })
        }

        function sendChange(id) {
            let title = document.getElementById('proname').value;
            let content = document.getElementById('content').value;
            let prc = document.getElementById('price').value;
            $.ajax({
                url: '/admin/prochange',
                type: 'POST',
                data: {
                    title: title,
                    content: content,
                    id: id,
                    price: prc,
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    if (data == 'ok') {
                        document.getElementById('res').value = '修改成功!';
                    }
                    setTimeout(function () {
                        document.getElementById('res').value = '提交';
                    }, 2000)
                },
                error: function (data, status, txt) {
                }
            })
        }

        let oldid = [];
        let ids = [];

        function add(id) {
            for (let i = 0; i < ids.length; i++) {
                if (ids[i] == id) {
                    return;
                }
            }
            ids.push(id);
        }

        function datadel() {

            if (ids.length == 0) {
                alert('请选择删除项!');
                return;
            }
            if (oldid.length > 0) {
                for (let i = 0; i < ids.length; i++) {
                    for (let s = 0; s < oldid.length; s++) {
                        if (ids[i] == oldid[s]) {
                            ids.splice(i, 1);
                        }
                    }
                }
            }
            $.ajax({
                type: 'GET',
                url: '/admin/imgdel',
                datatype: 'json',
                data: {products: ids + ''},
                success: function (data) {
                    document.getElementById('toasts').innerHTML = '删除成功!';
                    document.getElementById('toasts').style.display = 'block';
                    // alert('添加成功!');
                    setTimeout(function () {
                        document.getElementById('toasts').style.display = 'none';
                        document.getElementById('toasts').innerHTML = '';
                    }, 1000);
                    ids.forEach(function (e) {
                        $('#' + e).remove();
                        oldid.push(e);
                    })
                },
                error: function (data, status, txt) {
                    document.getElementById('toasts').innerHTML = '删除失败!';
                    document.getElementById('toasts').style.display = 'block';
                    // alert('添加成功!');
                    setTimeout(function () {
                        document.getElementById('toasts').style.display = 'none';
                        document.getElementById('toasts').innerHTML = '';
                    }, 1000)

                }
            })
        }
    </script>
@endsection