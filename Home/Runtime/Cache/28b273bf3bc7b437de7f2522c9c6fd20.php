<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="__PUBLIC__/css/index.css" rel="stylesheet" type="text/css" /><style type="text/css">
     form#pass input{
          margin:0px;
          padding:0px;
          height:20px;
          width:120px;
          line-height:20px;
          font-size:12px;
     }
     form#pass input#special{
          margin:0px;
          padding:0px;
          height:20px;
          width:50px;
          line-height:20px;
          font-size:12px;
          margin-top:10px;
          margin-left:100px;
     }
</style><script type="text/javascript">
      window.onload=function(){
           document.myform.newpass.focus();
      }
      function check(){
         if(document.myform.newpass.value==""){
             alert('新密码不能为空');
             document.myform.newpass.focus();
             return false;
         }
         if(document.myform.repeatpass.value==""){
             alert('确认密码不能为空');
             document.myform.repeatpass.focus();
             return false;
         }
         if(document.myform.newpass.value!=document.myform.repeatpass.value){
              alert("确认密码与新密码不一致");
              document.myform.repeatpass.focus();
             return false;
         }
      }
</script></head><body id="page"><h2>修改密码</h2><form action="__URL__/updateNewPassword" method="post" id="pass" name="myform" onsubmit="return check();">
新密码：<div style="width:13px;height:10px;display:inline-block;"></div><input type="password" name="newpass"><br>
确认密码：<input type="password" name="repeatpass"><br><input type="submit" name="submit" value="修改" id="special"></form></body></html>