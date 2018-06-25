@extends('admin.master')
@section('content')
<div class="page-container">
	<table class="table table-border table-bordered table-bg mt-20">
		<tbody>
			<tr>
				<th width="30%">服务器计算机名</th>
				<td><span id="lbServerName"><?=$_SERVER['SERVER_SOFTWARE']?></span></td>
			</tr>
			<tr>
				<td>服务器IP地址</td>
				<td><?=GetHostByName($_SERVER['SERVER_NAME'])?></td>
			</tr>
			<tr>
				<td>服务器域名</td>
				<td><?=$_SERVER["HTTP_HOST"]?></td>
			</tr>
			<tr>
				<td>服务器端口 </td>
				<td><?=$_SERVER['SERVER_PORT']?></td>
			</tr>
			<tr>
				<td>服务器版本 </td>
				<td><?=php_uname('s')?></td>
			</tr>
			<tr>
				<td>本文件所在文件夹 </td>
				<td><?=__DIR__?></td>
			</tr>
			<tr>
				<td>服务器操作系统 </td>
				<td><?=php_uname()?></td>
			</tr>
			<tr>
				<td>系统所在文件夹 </td>
				<td><?=$_SERVER['SystemRoot']?></td>
			</tr>
			<tr>
				<td>服务器当前时间 </td>
				<td><?=date('Y-m-d H:i:s',time())?></td>
			</tr>
			<tr>
				<td>当前程序占用内存 </td>
				<td><?=round(memory_get_usage()/1024/1024,2)?>M</td>
			</tr>
			<tr>
				<td>当前SessionID </td>
				<td><?=session('user')?></td>
			</tr>
			<tr>
				<td>当前系统用户名 </td>
				<td><?=Get_Current_User()?></td>
			</tr>
			<tr>
				<td>服务器语言</td>
				<td><?=$_SERVER['HTTP_ACCEPT_LANGUAGE']?></td>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
@endsection