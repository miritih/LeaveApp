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
        validator: function(date){
            var condition
            var g;
               if(month<=3 && month>=1){
                 condition =  date.getMonth()+1<1 || date.getMonth()+1>3;
               }else if(month<=6 && month>=4){
                condition =  date.getMonth()+1<4 || date.getMonth()+1>6;
               }else if(month<=9 && month>=7){
                condition =  date.getMonth()+1<7 || date.getMonth()+1>9;
               }else if(month<=12 && month>=10){
                condition =  date.getMonth()+1<10 || date.getMonth()+1>12;
               }
            //console.log(fullyBooked(date));
            if (date.getDay()== 6||date.getDay()== 0||date.getFullYear()!=now.getFullYear()||date < now || condition||fullyBooked(date)>=1){
                return false;
            } else {
                return true;
            }
        }
    });
    function fullyBooked(date){
       var dat='';
        var yy = date.getFullYear();
                  var mon = date.getMonth()+1;
                  var day = date.getDate();
                  var dateZ= yy+'-'+(mon<10?('0'+mon):mon)+'-'+(day<10?('0'+day):day);
        $.ajax({
                async: false,
                type: "GET",
                url: "date",
                data: {date : dateZ },
                dataType: "json",
                success : function(data) {
                              dat = data;
                          }
              });
        return dat;
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