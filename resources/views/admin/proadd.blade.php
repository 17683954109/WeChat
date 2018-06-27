@extends('admin.master')
@section('content')
    <div class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>主分类：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="mian" class="select" id="mains"  onchange="getmains()">
                    @foreach($main as $k=>$v)
                        <option value="{{$v->class_id}}">{{$v->pro_name}}</option>
                    @endforeach
				</select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>子分类：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="clas" class="select" id="classss">
                    <script>
                        let idss=[];
                        let nn=[];
                        let nana=[];
                        @foreach($class as $ke=>$va)
                        idss.push({{$va->class_id}});
                        nn.push('{{$va->main_class}}');
                        nana.push('{{$va->class_name}}');
                        @endforeach
                    </script>
                    <option value="0" class="" style="display: block">请选择二级分类</option>
            </select>
				</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="proname" class="input-text" id="proname">
				 </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="price" class="input-text" id="price">
            </div>
        </div>

                <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">文字说明：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <textarea id="content" style="height: 300px" cols="" rows="" class="textarea"  placeholder="请对商品作简要说明......"></textarea>
                <p class="textarea-numberbar" style="color: #999999">商品介绍内容</p>
            </div>
        </div>

        <script>
            window.onload=(getmains());
            function getmains() {
                document.getElementById('classss').innerHTML='';
                let mainsv=document.getElementById('mains').value;
                for (var i=0;i<idss.length;i++){
                    if (idss[i]&&nn[i]){
                        if (mainsv==nn[i]){
                            document.getElementById('classss').innerHTML+="<option value="+idss[i]+" style='display: block'>"+nana[i]+"</option>";
                        }
                    }
                }
            }

          </script>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">商品图片：</label>

            <div class="formControls col-xs-8 col-sm-9">
                <div class="uploader-thum-container" id="imgup">
                    <img src="" id="mImg" width="100"/>
                    <div id="fileList" class="uploader-list"></div>
                    <input type="file" name="jg" id="mFile" multiple="multiple">
                    <script>
                        //文件上传
                        let id;
                        function ajaxFileUpload() {

                            var formData = new FormData();
                            formData.append("jg", $("#mFile")[0].files[0]);
                            formData.append("_token",'{{csrf_token()}}');
                            $.ajax({
                                url: '/admin/imgadd',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (msg) {
                                    console.log(msg);
                                    id=msg;
                                    getimgs(msg);
                                },
                                error:function (data,status,sts) {
                                    console.log(data);
                                }
                            });
                        }
                        let nums=0;
                        let id_arr=[];
                        function getimgs(id) {
                            $.ajax({
                                url:'/admin/tmpimg/'+id,
                                type:'GET',
                                success:function (data) {
                                    nums++;
                                    let preimg=document.getElementById('imgshow');
                                    id_arr.push(id);
                                    preimg.innerHTML+="<li class=\"item\" id=\"\">\n" +
                                        "                        <div class=\"portfoliobox\">\n" +
                                        "                            \n" +
                                        "                            <div class=\"picbox\"><a data-lightbox=\"gallery\" id=\"imgshow\"><img src='"+data+"' id='"+nums+"'/></a></div>\n" +
                                        "                        </div>\n" +
                                        "                    </li>";
                                },
                                error:function (data,status,sts) {
                                    console.log(data);
                                }
                            })
                        }
                    </script>
                    <div id="filePicker"></div>
                    <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10" style="margin-left: 0;margin-top: 15px"onclick="ajaxFileUpload()">开始上传</button>
                </div>
            </div>
        </div>


        <div class="page-container">
            <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-left: 15%">
                {{--<span class="l"><a onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a></span>--}}
                <span style="color: red;display: none" id="toasts"></span>
            </div>
            <div class="portfolio-content">
                <ul class="cl portfolio-area" id="imgshow">

                </ul>
            </div>
        </div>

        <div class="row cl">
            <div class="col-9 col-offset-2">
                <input class="btn btn-primary radius" value="&nbsp;&nbsp;提交&nbsp;&nbsp;" onclick="sendform()" id="resss">
            </div>
        </div>

    </div>
    <script>
        let fills;
        document.getElementById('mFile').onchange = function (ev) {
            //判断 FileReader 是否被浏览器所支持
            if (!window.FileReader) return;

            console.log(ev);

            var file = ev.target.files[0];
            fills=file;

            if(!file.type.match('image/*')){
                alert('上传的图片必修是png,gif,jpg格式的！');
                ev.target.value = ""; //显示文件的值赋值为空
                return;
            }

            var reader = new FileReader();  // 创建FileReader对象

            reader.readAsDataURL(file); // 读取file对象，读取完毕后会返回result 图片base64格式的结果

            reader.onload = function(e){
                document.getElementById('mImg').src = e.target.result;
            }

        }
        function sendform() {
            if (id_arr.length==0){
                document.getElementById('resss').value='请上传一张图片';
                setTimeout(function () {
                    document.getElementById('resss').value='提交';
                },1500);
                return;
            }
            let clas=document.getElementById('classss').value;
            let content=document.getElementById('content').value;
            let proname=document.getElementById('proname').value;
            let price=document.getElementById('price').value;
            if (price==''||content==''||proname==''){
                document.getElementById('resss').value='请认真填写';
                setTimeout(function () {
                    document.getElementById('resss').value='提交';
                },1500);
                return;
            }
            document.getElementById('resss').value='正在添加...';
            $.ajax({
                url:'/admin/proreg',
                type:'POST',
                data:{
                    clas:clas,
                    ids:id_arr,
                    price:price,
                    content:content,
                    proname:proname,
                    _token:"{{csrf_token()}}"
                },
                success:function (data) {
                    console.log(data);
                    if (data=='ok'){
                        document.getElementById('resss').value='添加成功!';
                        setTimeout(function () {
                            document.getElementById('resss').value='提交';
                        },1500);
                    }

                },
                error:function (data,status,tst) {
                    console.log(data);
                    document.getElementById('resss').value='添加失败!';
                    setTimeout(function () {
                        document.getElementById('resss').value='重试';
                    },1500);
                }
            })
        }
    </script>
@endsection