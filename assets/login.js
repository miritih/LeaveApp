/**
 * Created by eric on 5/4/15.
 */
$(function(){
    $('#ajax-load').hide();
    $('#heading').show();
 $('#login').on('submit',function(e) {
     $(document).ajaxStart(function () {
            $('#ajax-load').show();
            $('#heading').hide();
          });

            $(document).ajaxStop(function () {
                $('#ajax-load').hide();
                $('#heading').show()
            });

     var username=$('#email').val();
     var password=$('#password').val();
     if(username=='' && password==''){
         $.messager.alert('Error','Fields cannot be empty','error');
     }
     else if(username==''){
         $.messager.alert('Error','Please enter your username','error');
     }
     else if(password==''){
         $.messager.alert('Error','Please enter your password','error');
     }
     else{
         $.post($(this).prop('action'),
             {
                 "_token":$(this).find('input[name=_token]').val(),
                 "username":username,
                 "password":password
             },
             function (data) {
                 if(data.status=='success'){
                 $(location).attr('href','/leave')
                 }
                 else if(data.status=='fail'){
                     $('#ajax-load').hide();
                     $('#heading').show();
                     $.messager.alert('Error!!',data.msg,'error')
                     console.log(data.msg)
                 }
         },'json');
         }
     e.preventDefault();
 })
})