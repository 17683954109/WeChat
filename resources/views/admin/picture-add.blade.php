@extends('admin.master')
@section('content')
        <form action="" method="post" class="form form-horizontal" id="form-article-add">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>一级分类：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="mians" class="select" id="mains"  onchange="getmains()">
                    @foreach($main as $k=>$v)
					<option value="{{$v->pro_name}}">{{$v->pro_name}}</option>
                    @endforeach
				</select>
				</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>二级分类：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="" class="select" id="classss" onchange="getpro()">
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
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>二级分类：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="" class="select" id="classs">
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
        getpro();
    }
    function getpro() {
        console.log('ok');
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
                <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <div class="uploader-thum-container">
                        <div id="fileList" class="uploader-list"></div>
                        <div id="filePicker">选择图片</div>
                        <button id="btn-star" class="btn btn-default btn-uploadstar radius ml-10">开始上传</button>
                    </div>
                </div>
            </div>

                </form>
@endsection