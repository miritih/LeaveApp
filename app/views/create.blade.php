<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 1/17/16
 * Time: 10:33 PM
 */?>
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
	<script type="text/javascript" src="assets/jquery.min.js"></script>
	<script type="text/javascript" src="assets/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="assets/datagrid-detailview.js"></script>
    <script type="text/javascript" src="assets/datagrid-groupview.js"></script>
    <script type="text/javascript" src="assets/datagrid-filter.js"></script>
    <style type="text/css">

    </style>
</head>
<body>
       {{--layout start--}}
                    <div class="easyui-panel" style="margin-left:30%; margin-top:5%;" data-options="fit:true,border:false">
                        <div class="easyui-panel" title="Register New Agent" style="width:400px;padding:30px 70px 20px 70px">
                            {{Form::open( array('route'=>'agent.create','method'=>'POST','ajax'=>'true','id'=>'ff'))}}
                        		<div style="margin-bottom:10px">
                        			<input class="easyui-textbox" style="width:100%;height:40px;padding:12px" name="agentId" data-options="prompt:'Agent Number',required:true">
                        		</div>
                            <div style="margin-bottom:10px">
                        			<input class="easyui-textbox" style="width:100%;height:40px;padding:12px" name="fullName" data-options="prompt:'Agent Name (in caps)',required:true">
                        		</div>
                            <div style="margin-bottom:20px">
                                <input class="easyui-combobox" id="projectCombo" style="width:100%;height:40px;padding:12px" data-options="prompt:'Project Name',required:true" name="project1"></td>
                        		</div>
                            <div style="margin-bottom:20px">
                        			<input class="easyui-textbox" type="password" name="password" style="width:100%;height:40px;padding:12px" data-options="prompt:'Password',iconCls:'icon-lock',iconWidth:38,required:true">
                        		</div>
                            <div style="margin-bottom:20px">
                        			<input class="easyui-textbox" type="password" name="con_pass" style="width:100%;height:40px;padding:12px" data-options="prompt:' Confirm Password',iconCls:'icon-lock',iconWidth:38,required:true">
                        		</div>
                        		<div>
                        			<a href="#" class="easyui-linkbutton" onclick="submitForm()" data-options="iconCls:'icon-ok'" style="padding:5px 0px;width:100%;">
                        				<span style="font-size:14px;">Save</span>
                        			</a>
                        		</div>
                            {{Form::close()}}
                        	</div>
                    </div>

    <script>
		function submitForm(){
			$('#ff').form('submit',{
                url:'agentSave',
				onSubmit:function(){
                    var isValid= $(this).form('validate');
                    var idformat=/^SSDC-\d*$/;
                    var agentId =$(this).find('input[name="agentId"]').val();
                    var agentName =$(this).find('input[name="fullName"]').val();
                    var pass =$(this).find('input[name="password"]').val();
                    var conpass =$(this).find('input[name="con_pass"]').val();
                    var caps=/^[A-Z\s*]*$/;
                    if(!isValid){
                        $.messager.progress('close');
                        $.messager.alert('Error!', 'fill in the missing fields', 'error');
                        return isValid
                    }
                    else if(!idformat.test(agentId)){
                        $.messager.progress('close');
                        $.messager.alert('Error!', 'Agent ID should follow the format SSDC-000', 'error');
                        return false
                    }
                    else if(!caps.test(agentName)){
                        $.messager.progress('close');
                        $.messager.alert('Error!', 'Name Must be in Caps', 'error');
                        return false
                    }
                    else if(pass!==conpass){
                                    $.messager.progress('close');
                                    $.messager.alert('Error!','Password MisMatch');
                                    return false
                    }

				},
                success:function(data){
                    var f=JSON.parse(data);
                    $.messager.progress('close');
                    if(f.status=='success'){
                        $.messager.progress('close');
                        $.messager.show({
                            title:f.status,
                            msg:f.msg,
                            icon:'info',
                            modal:true,
                            timeout:5000,
                            showType:'fade',
                            style:{
                                right:'',
                                bottom:''
                            }
                        });
                        $(location).attr('href','/leave')
                    }
                    else if(f.status=='Error'){
                        console.log(f.msg)
                        $.messager.alert({
                            title:f.status,
                            msg:f.msg,
                            icon:'error',
                                timeout:5000,
                                showType:'fade'
                            });
                        }
                    }
				});
			}
			function clearForm(){
				$('#ff').form('clear');
			}
		</script>
<script src="assets/ui/mainui.js"></script>
<script src="assets/app.js"></script>
</body>
</html>