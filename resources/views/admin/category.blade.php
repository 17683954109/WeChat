@extends('admin.master')
@section('content')
    <div class="form form-horizontal" id="form-article-add">
        <div class="row cl" style="display: none" id="minclas">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>请选择主分类：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="mian" class="select" id="mains"  onchange="getmains()">
                    @foreach($main as $k=>$v)
                        <option value="{{$v->class_id}}">{{$v->pro_name}}</option>
                    @endforeach
				</select>
				</span> </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="proname" class="input-text" id="proname">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>备注：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="proname" class="input-text" id="bzss">
            </div>
        </div>

        <div class="row cl">
            <div class="col-3 col-offset-2">
                <input class="btn btn-primary radius" value="&nbsp;&nbsp;添加子分类&nbsp;&nbsp;" onclick="showmins()" id="resss"><br/><br/>
                <input class="btn btn-primary radius" value="&nbsp;&nbsp;确认添加&nbsp;&nbsp;" onclick="cateadd()" id="ress">
            </div>
        </div>

        <script>
            let mainss=false;
            function showmins() {
                let status=document.getElementById('minclas').style.display;
                mainss=!mainss;
                if (status=='block'){
                    document.getElementById('minclas').style.display='none';
                    document.getElementById('resss').value='添加子分类';
                }else{
                    document.getElementById('minclas').style.display='block';
                    document.getElementById('resss').value='添加主分类';
                }
            }
            function cateadd() {
                let mainid=document.getElementById('mains').value;
                if (mainss==false){
                    mainid='e';
                }
                let catename=document.getElementById('proname').value;
                let bzss=document.getElementById('bzss').value;
                if (catename==''||catename==null){
                    layer.msg('请认真填写!',{icon:2,time:2000});
                    return;
                }
                if (bzss==''||bzss==null){
                    layer.msg('请认真填写!',{icon:2,time:2000});
                    return;
                }
                $.ajax({
                    url:'/admin/cateadd',
                    type:'POST',
                    data:{
                        main:mainid,
                        name:catename,
                        bz:bzss,
                        _token:"{{csrf_token()}}"
                    },
                    success:function (data) {
                        if (data=='ok'){
                            document.getElementById('ress').value='添加成功!';
                            setTimeout(function () {
                                document.getElementById('ress').value='提交';
                            },1500);
                        }
                    },
                    error:function (data,status,sts) {
                        document.getElementById('ress').value='添加失败!';
                        setTimeout(function () {
                            document.getElementById('ress').value='重试';
                        },1500);
                    }
                })
            }
        </script>


    </div>
@endsection