/**
 * Created by eric on 1/16/16.
 */
 $(window).load(function() {
	$(".loader").fadeOut("slow");
	setTimeout(function(){
   CalValidate();
 },5000);
})
$(function () {
    /*hide calender first*/
    $('#agentCombo').combobox({disabled:true});

    /*enable agent select on project select*/
    $('#projectCombo').combobox({
        onSelect: function () {
            $('#agentCombo').combobox({disabled:false});
        }
    });
    /*listen to date select events*/
        $('#calender').calendar({
            onSelect: function (date) {
                $('#leaveFrm').form('submit',{
                    url:'save',
                    onSubmit:function(param){
                        var y = date.getFullYear();
                        var m = date.getMonth()+1;
                        var d = date.getDate();
                        var mm =y+'-'+(m<10?('0'+m):m);
                        var z= y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
                        var isValid= $(this).form('validate');
                        var project =$(this).find('input[name="project"]').val();
                        var agent =$(this).find('input[name="agent"]').val();
                        param.date=z;
                        param.project=project;
                        param.agent=agent;
                        param.month=mm;
                        param.qter=m;
                        /*progress */
                        $.messager.progress({
                            title:'Please wait',
                            msg:'Sending Request....'
                        });
                        if(!isValid){
                            $.messager.progress('close');
                            $.messager.alert('Error!', 'Please select your name and Project first!!', 'error');
                            return isValid
                        }else{
                            $.messager.confirm('Confirm Details','Leave Date: <b>'+z+'</b><br>'+'Agent ID: <b>'+agent+'</b><br>'+'Project: <b>'+project+'</b>', function(r){
                                if (r){
                                    $.post('save',param, function (d) {
                                        $.messager.progress('close');
                                        console.log(d.status)
                                        if(d.status=='success'){
                                            $.messager.progress('close');
                                            $.messager.show({
                                                title:d.status,
                                                msg:d.msg,
                                                icon:'info',
                                                modal:true,
                                                timeout:500,
                                                showType:'fade',
                                                style:{
                                                    right:'',
                                                    top:document.body.scrollTop+document.documentElement.scrollTop,
                                                    bottom:''
                                                }
                                            });
											
                                           $('#calender').calendar({validator:CalValidate});
										   $('#dataGrid').datagrid('reload');
                                        }
                                        else if(d.status=='Error'){
                                            $.messager.progress('close');
											console.log(d);
                                            $.messager.alert({
                                                title:d.status,
                                                msg:d.msg,
                                                icon:'error',
                                                timeout:500,
                                                showType:'fade'
                                            });
                                        }
                                    })
                                }
								else{ $.messager.progress('close');}
                            });
                            return false;
                        }

                    }
                })

            }
        });
/*cancel leave*/
});
function CancelLeave() {
       form = '#U-delete';
       var row = $('#dataGrid').datagrid('getSelected');
       var now=new Date();
       var y = now.getFullYear();
       var m = now.getMonth()+1;
       var d = now.getDate();
	   var user_id=$('#leaveFrm').find('input[name="agent"]').val();
	 
       var z= y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
       if (row.date <= z){
           $('.c3').linkbutton('disable');
           $.messager.alert('Error!!', 'Cannot cancel this day! Leave day already passed');
           return false;
       }
	    else if (row.agent_ID!=user_id){
           $('.c3').linkbutton('disable');
           $.messager.alert('Error!!', 'Not your leave day!, You cannot cancel.');
           return false;

       }
       else if (row == null) {
           $.messager.alert('Error!!', 'select record first');
           return false;
       }
       url = 'leave/delete';
       $('.c3').linkbutton('disable');
       $.messager.confirm('Confirm', 'Are you sure you want to Cancel This leave day??', function (r) {
           if (r) {
               $.messager.progress({
                   title: 'please wait',
                   msg: 'Deleting......'
               });
               $(form).form('submit', {
                   url: url,
                   onSubmit: function (param) {
                       param.id=row.leave_ID;
                       var isValid = $(this).form('validate');
                       if (!isValid) {
                           $.messager.progress('close');
                           return isValid
                       }
                   },
                   success: function (data) {
                       var f = JSON.parse(data);
                       $.messager.progress('close');
                       if (f.status == 'success') {
                      	$('#calender').calendar({validator:CalValidate});	
						$('#dataGrid').datagrid('reload');													
                           $.messager.show({
                               title: f.status,
                               msg: f.msg,
                               modal:true,
                               timeout: 500,
                               showType: 'slide',
                               style:{
                                   right:'',
                                   top:document.body.scrollTop+document.documentElement.scrollTop,
                                   bottom:''
                               }
                           });
                       }
                       else if (f.status == 'Error') {
                           $.messager.alert({
                               title: f.status,
                               msg: f.msg,
                               timeout: 500,
                               showType: 'fade'
                           });
                       }
                   }
               });
           }
   })
   };/*end function*/