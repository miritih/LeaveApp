<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 1/10/16
 * Time: 8:20 AM
 */?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>leave</title>
	<link rel="stylesheet" type="text/css" href="assets/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="assets/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="assets/themes/color.css">
    <style type="text/css">
	.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('assets/images/gears.svg') 50% 50% no-repeat rgb(249,249,249);
}
    </style>
	<script type="text/javascript" src="assets/jquery.min.js"></script>
<script type="text/javascript" src="assets/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="assets/datagrid-detailview.min.js"></script>
  <script type="text/javascript" src="assets/datagrid-groupview.min.js"></script>
   <script type="text/javascript" src="assets/datagrid-filter.min.js"></script>
</head>
<body id="bdy">
<div class="loader">Loading......</div>
	<div style="margin:20px 0;"></div>
	<div id="leave-app">
        {{--layout start--}}
        <div class="easyui-layout" style="width:100%;height:100%;">
        		<div data-options="region:'west',split:false,title:'REQUESTS',collapsible:false" style="width:300px;">
                    <div class="easyui-panel" data-options="fit:true">
                        {{Form::open( array('route'=>'leave.create','method'=>'POST','ajax'=>'true','id'=>'leaveFrm'))}}
                                                {{--combo box--}}
                                                <br>
                                                <table>
                                                <tr><td>
                                                <label for="agentCombo">Project Name</label></td><td>
                                                <input class="easyui-textbox" value="{{$project}}" disabled required name="project"></td>
                                                <input type="hidden" value="{{$max_agents}}" id="max_agents"></td>
                                                </tr>
                                                    <tr><td><br><br></td></tr>
                                                <tr><td>
                                                <label for="agentCombo">Agent ID</label></td><td>
                                                <input class="easyui-textbox"  placeholder="{{$name}}" value="{{$user}}" disabled required name="agent"></td>
                                                </tr>
                                                    <tr><td><br><br></td></tr>
                                                    </table>
                                                {{--EOF--}}
                                                <div id="sel">
                                               <div id="calender" class="easyui-calendar" data-options="title:'.'" style="width:100%;height:320px;"></div>
                                                </div>
                                                <div class="easyui-panel" style="width:100%;height:130px;">
                        						<br><br>
                        						<a href="logout" style="padding: 5px;" class="easyui-linkbutton c2" data-options="iconCls:'icon-remove'">logout</a>
                        						</div>
                                               {{--EOF calender--}}
                                                {{Form::close()}} 
                    </div>
                    {{--EOF panel--}}
        		</div>
        		<div data-options="region:'center'" style="padding:1px">
                    <div id="dataGrid"></div>
                    <div id="tb" style="height:auto; background:#f5f5f5;">
                        <a href="excel" style="padding: 5px; float: right;" class="easyui-linkbutton c4">Download Excel</a>
                        <a href="javascript:void(0)" style="padding: 5px;" class="easyui-linkbutton c3" data-options="iconCls:'icon-remove',disabled:true" onclick="CancelLeave()">Cancel Leave</a>
                        {{Form::open( array('method'=>'POST','id'=>'U-delete','ajax'=>'true','class'=>"easyui-form"))}}
                        <input id="del-leave" name="id" type="hidden">
                        {{Form::close()}}
                    </div>
        		</div>
        	</div>
        {{--EOF layout--}}
	</div>
<script src="assets/ui/functions.min.js"></script>
<script src="assets/ui/mainui.min.js"></script>
<script src="assets/app.min.js"></script>
</body>
</html>