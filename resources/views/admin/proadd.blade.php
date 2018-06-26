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
				<input type="text" name="proname" class="input-text">
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
                        function ajaxFileUpload() {

                            //图片格式验证
                            var x = document.getElementById("mFile");
                            if (!x || !x.value){return;}
                            var patn = /\.jpg$|\.jpeg$|\.png$|\.gif$/i;
                            if (!patn.test(x.value)) {
                                alert("您选择的似乎不是图像文件。");
                                x.value = "";
                                return;
                            }
                            var elementIds = ["mFile"]; //flag为id、name属性名
                            $.ajaxFileUpload({
                                url: '/admin/imgadd',//上传的url，根据自己设置
                                type: 'post',
                                secureuri: false, //一般设置为false
                                fileElementId: 'jg', // 上传文件的id、name属性名
                                dataType: 'json', //返回值类型，一般设置为json、application/json
                                elementIds: elementIds, //传递参数到服务器
                                success: function (data, status) {
                                    //alert(data);
                                    if (data == "Error1") {
                                        alert("文件太大，请上传不大于5M的文件！");
                                        return;
                                    } else if (data == "Error2") {
                                        alert("上传失败，请重试！");
                                        return;
                                    } else {
                                        //这里为上传并做一下请求显示处理，返回的data是对应上传的文件名
                                        $("#imgup").append("<img width='300' height='300' src='"+ data+"'/>");

                                    }
                                },
                                error: function (data, status, e) {
                                    alert(e);
                                }
                            });
                            //return false;
                        }

                    </script>
                    <div id="filePicker"></div>
                    <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10" style="margin-left: 0;margin-top: 15px"onclick="ajaxFileUpload()">开始上传</button>
                </div>
            </div>
        </div>

    </div>
    <script>
        // let fills;
        // document.getElementById('mFile').onchange = function (ev) {
        //     //判断 FileReader 是否被浏览器所支持
        //     if (!window.FileReader) return;
        //
        //     console.log(ev);
        //
        //     var file = ev.target.files[0];
        //     fills=file;
        //
        //     if(!file.type.match('image/*')){
        //         alert('上传的图片必修是png,gif,jpg格式的！');
        //         ev.target.value = ""; //显示文件的值赋值为空
        //         return;
        //     }
        //
        //     var reader = new FileReader();  // 创建FileReader对象
        //
        //     reader.readAsDataURL(file); // 读取file对象，读取完毕后会返回result 图片base64格式的结果
        //
        //     reader.onload = function(e){
        //         document.getElementById('mImg').src = e.target.result;
        //     }
        //
        // }
    </script>
@endsection