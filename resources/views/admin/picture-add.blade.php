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
				<select name="clas" class="select" id="classss" onchange="getpro()">
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
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="pro" class="select" id="classs">
                    <script>
                        let idsss=[];
                        let nns=[];
                        let nanas=[];
                        @foreach($all as $key=>$val)
                        idsss.push({{$val->id}});
                        nns.push({{$val->class_id}});
                        nanas.push('{{$val->info}}');
                        @endforeach
                    </script>
                    <option value="0" class="" style="display: block">请选择二级分类</option>
            </select>
				</span> </div>
            </div>

<script>
    let addinfo='s';
    window.onload=(getmains());
    function getmains() {
        if (addinfo=='y'){
            document.getElementById('imgshow').innerHTML='';
        }
        document.getElementById('classss').innerHTML='';
        let mainsv=document.getElementById('mains').value;
        for (var i=0;i<idss.length;i++){
            if (idss[i]&&nn[i]){
                if (mainsv==nn[i]){
                    document.getElementById('classss').innerHTML+="<option value="+idss[i]+" style='display: block'>"+nana[i]+"</option>";
                }
            }
        }
        getpro();
    }
    function getpro() {
        document.getElementById('classs').innerHTML='';
        let mainss=document.getElementById('classss').value;
        for (var i=0;i<idsss.length;i++){
            if (idsss[i]&&nns[i]){
                if (mainss==nns[i]){
                    document.getElementById('classs').innerHTML+="<option value="+idsss[i]+" style='display: block'>"+nanas[i]+"</option>";
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
                                    addinfo='y';
                                let imgid=document.getElementById('classs').value;
                                    var formData = new FormData();
                                    formData.append("jg", $("#mFile")[0].files[0]);
                                    formData.append("_token",'{{csrf_token()}}');
                                    formData.append('pro',imgid);
                                    $.ajax({
                                        url: '/admin/imgadd',
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function (msg) {
                                            id=msg;
                                            getimgs(msg);
                                        },
                                        error:function (data,status,sts) {
                                        }
                                    });
                                }
                                let nums=0;
                                let id_arr=[];
                                function getimgs(id) {
                                            let preimg=document.getElementById('imgshow');
                                            preimg.innerHTML+="<li class=\"item\" id=\"\">\n" +
                                                "                        <div class=\"portfoliobox\">\n" +
                                                "                            \n" +
                                                "                            <div class=\"picbox\"><a data-lightbox=\"gallery\" id=\"imgshow\"><img src='"+id+"' id='"+nums+"'/></a></div>\n" +
                                                "                        </div>\n" +
                                                "                    </li>";

                                }
                            </script>
                            <div id="filePicker"></div>
                            <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10" style="margin-left: 0;margin-top: 15px"onclick="ajaxFileUpload()">开始上传</button>
                        </div>
                    </div>
                </div>


                <div class="row cl" style="margin-left: 15%">
                    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-left: 15%">
                        <span style="color: red;display: none" id="toasts"></span>
                    </div>
                    <div class="portfolio-content">
                        <ul class="cl portfolio-area" id="imgshow">

                        </ul>
                    </div>
                </div>

                </div>
    <script>
        let fills;
        document.getElementById('mFile').onchange = function (ev) {
            //判断 FileReader 是否被浏览器所支持
            if (!window.FileReader) return;

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
    </script>
@endsection