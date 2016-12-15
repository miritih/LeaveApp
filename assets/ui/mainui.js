/**
 * Created by eric on 1/10/16.
 */
$(function(){
    /* app window*/
$('#leave-app').window({
    iconCls:'icon-leave',
    maximized:true,
    fit:true,
    draggable:false,
    collapsible:false,
    maximizable:false,
    minimizable:false,
    closable:false,
    title:'GAR 2 LEAVE APPLICATION APP'
});

    /*projects comboBox*/
    $('#projectCombo').combobox({
        url:'projects',
        method:'get',
        valueField:'project_Name',
        textField:'project_Name',
        panelHeight:'auto'
    });

    /*agent comboBox*/
    $('#agentCombo').combobox({
        url:'agents',
        method:'get',
        valueField:'agent_ID',
        textField:'agent_Name',
        panelHeight:'auto'
    });

 /*calender*/
     now=new Date();
    month = now.getMonth()+1;
    $('#calender').calendar({
        firstDay:1,
        validator: CalValidate 
    });
	
   
  
  /*function to relod Calender*/
	function cal_refresh() {
	$('#calender').calendar({validator:CalValidate});
	setTimeout(cal_refresh, 15000); // schedule next refresh after 15sec
  }
  
    /*display Grid*/
    $('#dataGrid').datagrid({
        title:'Display Grid',
        fit:true,
        rownumbers:true,
        striped:true,
        remoteSort:true,
        toolbar: '#tb',
        singleSelect:true,collapsible:true,
        nowrap:true,
        fitColumns:true,
        url:'leave',
        pageNumber:1,
        pageSize:30,
        method:'get',
        columns:[[
            {field:'leave_ID',title:'id',hidden:true},
            {field:'date',title:'Leave Date',width:100,sortable:true},
            {field:'agent_ID',title:'Agent ID',width:80,align:'left'},
            {field:'agent_Name',title:'Agent Name',width:100,sortable:true},
            {field:'project_Name',title:'Project Name',width:100,sortable:true},
            {field:'created_at',title:'Status',width:50,formatter:actionsFormat,styler:actionStyler}

        ]],
        groupField:'agent_Name',
        view:groupview,
        pagination:true,
        pageSize1:50,
        groupFormatter:function(value, rows){
                   return value + ' { Total: '+ rows.length + ' - Remaining: '+ (21-rows.length) +' }';
        },
        rowStyler: function(index,row){
            var now=new Date();
            var y = now.getFullYear();
            var m = now.getMonth()+1;
            var d = now.getDate();
            var z= y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
            if (row.date <= z){
                return 'background-color:rgba(21, 21, 21, 0.04);color:#000;opacity:0.4;font-weight:bold;';
            }
        },
        onClickRow: function (index,row) {
            var now=new Date();
                       var y = now.getFullYear();
                       var m = now.getMonth()+1;
                       var d = now.getDate();
                       var z= y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
                       if (row.date > z){
                           $('.c3').linkbutton('enable');
                       }

            }
    });
	 cal_refresh();
	  
    function actionsFormat(value,row,index){
        var now=new Date();
        var y = now.getFullYear();
        var m = now.getMonth()+1;
        var d = now.getDate();
        var z= y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        if (row.date <= z){
            return '<span style="color:#000;">Gone</span>';
        } else {
            return '<span style="color:#000;">Not Yet</span>';
        }
    }
    function actionStyler(value,row,index){
           var now=new Date();
           var y = now.getFullYear();
           var m = now.getMonth()+1;
           var d = now.getDate();
           var z= y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
           if (row.date <= z){
               return 'background-color:green;color:#000;opacity:0.9;font-weight:bold;';
           } else {
               return 'background-color:orange;color:#000;opacity:0.9;font-weight:bold;';
           }
       }

    $('#AgentDataGrid').datagrid({
        title:'Registered Agents',
        fit:true,
        rownumbers:true,
        striped:true,
        remoteSort:true,
        singleSelect:true,collapsible:true,
        nowrap:true,
        fitColumns:true,
        url:'agents',
        method:'get',
        columns:[[
            {field:'agent_ID',title:'Agent ID',width:80,align:'left'},
            {field:'agent_Name',title:'Agent Name',width:100,sortable:true},
            {field:'project_Name',title:'Project Name',width:100,sortable:true}
        ]],
        pagination:true,
        pageSize1:20
    });
    /*filter grid*/
    var dg = $('#dataGrid').datagrid({
       				filterBtnIconCls:'icon-filter'
       			});
    dg.datagrid('enableFilter', [{
    				field:'created_at',
    				type:'textbox'
    			}]);
     /*filter grid*/
    var Adg = $('#AgentDataGrid').datagrid({
       				filterBtnIconCls:'icon-filter'
       			});
    Adg.datagrid('enableFilter');
		});
		
/*Functin to validate the calender*/	
