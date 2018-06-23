@extends('master')
@section('title','分类')
@section('icon')
<link rel="icon" href="/images/reg.ico">
@endsection
@section('content')
<div id="total">
    <div class="weui-cells__title">语言分类</div>
    <div class="weui-cells">

        <a class="weui-cell weui-cell_access" onclick="getclass()">

            <div class="weui-cell__bd">
                <p id="celltitle">PHP</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>

<div class="weui-cells__title" id="cellsss"></div>
<div class="weui-cells" id="celll">

</div>
<script>
    let sss='';
    let sys=window.localStorage;
    {{--页面加载完毕读取服务器的一级商品分类列表--}}

window.onload=(to(1));
let backinfo;
function getclass(){
    if (sss!=''){
        document.getElementById('celll').innerHTML=sss;
        sss='';
        return;
    }
    $.ajax({
        url:'/goods/class',
        type:'GET',
        success:function(data){
            document.title='分类';
            document.getElementById('celll').innerHTML='';
            document.getElementById('cellsss').innerHTML='语言分类';
            document.getElementById('celltitle').innerHTML='PHP';
            data.forEach(function(e){
                document.getElementById('celll').innerHTML+='<div class="weui-cell" onclick="to('+e.class_id+')"><div class="weui-cell__bd"><p>'+e.pro_name+'</p></div><div class="weui-cell__ft">'+e.preview+'</div> </div>';
            });
            backinfo='back';
        },
        error:function(data,status,tet){
            console.log(data);
        }
    })
}
//  获取二级分类列表
function backs() {
    if (sss!=''){
        console.log('使用缓存');
        document.getElementById('celll').innerHTML=sss;
        sss='';
    }else{
        if (backinfo=='back'){
            // sys.setItem('os','');
            window.history.go(-1);
            console.log('全局返回');
            return;
        }
        console.log('重新请求');
        getclass();
    }
}
function to(id) {
    if (sys){
        let olds=sys.getItem('os');
        if (olds!=null&&olds!=''){
            console.log('使用本地缓存');
            document.getElementById('total').innerHTML=olds;
            document.getElementById('back-global').innerHTML="<img class=\"bk_bar\" src=\"/images/back.png\" onclick=\"backs()\">\n" +
                "    <p class=\"titles\">分类</p>\n" +
                "\n" +
                "    <img class=\"bk_menu\" src=\"/images/Viewlist.png\" onclick=\"shownav()\">";
            sss=sys.getItem('oldcelll');
            sys.setItem('os','');
            return;
        }
    }
    document.getElementById('back-global').innerHTML="<img class=\"bk_bar\" src=\"/images/back.png\" onclick=\"backs()\">\n" +
        "    <p class=\"titles\">分类</p>\n" +
        "\n" +
        "    <img class=\"bk_menu\" src=\"/images/Viewlist.png\" onclick=\"shownav()\">";
    $.ajax({
        url:'/goods/clas',
        type:"GET",
        data:{id:id},
        success:function (data) {
            document.title=data[0][0].main_class;
            document.getElementById('celll').innerHTML='';
            document.getElementById('cellsss').innerHTML=data[0][0].main_class+'分类';
            document.getElementById('celltitle').innerHTML=data[0][0].main_class;
            data.forEach(function(e){
                document.getElementById('celll').innerHTML+='<div class="weui-cell" onclick="pro('+e[0].class_id+')"><div class="weui-cell__bd"><p>'+e[0].class_name+'</p></div><div class="weui-cell__ft">'+e[0].preview+'</div> </div>';
            });
            backinfo='';
            console.log(data);
        },
        error:function (data,status,tet) {
           console.log(data);
        }
    })
}
//  读取二级分类列表下的商品列表
function pro(id) {
    sss=document.getElementById('celll').innerHTML;
    if (sys){
        sys.setItem('oldcelll',sss);
    }
    $.ajax({
        url:'/goods/product/'+id,
        type:"GET",
        data:{id:id},
        success:function (data) {
            document.title=data[0].info;
            document.getElementById('celll').innerHTML='';
            // document.getElementById('cellsss').innerHTML=data[0].info+'分类';
            // document.getElementById('celltitle').innerHTML=data[0].info;
            data.forEach(function(e){
                console.log(data);
                document.getElementById('celll').innerHTML+='<div class="weui-cells">\n' +
                    '\n' +
                    '        <a class="weui-cell weui-cell_access" onclick="go('+e.id+')">\n' +
                    '            <div class="weui-cell__hd"><img src="'+e.prview_img+'" alt="" style="width:60px;margin-right:5px;display:block"></div>\n' +
                    '            <div class="weui-cell__bd">\n' +
                    '                <p id="celltitle">'+e.info+'</p>\n' +
                    '                <span style="color: red;font-size: 12px">￥'+e.price+'</span>\n' +
                    '            </div>\n' +
                    '            <div class="weui-cell__ft"></div>\n' +
                    '        </a>\n' +
                    '    </div>';
            });

        },
        error:function (data,status,tet) {
            console.log(data);
        }
    })
}
function go(id) {
    sss=document.getElementById('total').innerHTML;
    if (sys){
        sys.setItem('os',sss);
    }
    window.location.href='/product/'+id;
}
</script>
@endsection