<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>登陆页面</title><link href="__PUBLIC__/css/login.css" rel="stylesheet" type="text/css" /></style><script type="text/javascript">
    window.onload=function(){
          document.myForm.username.focus();
    }
    function checkForm(){
          if(document.myForm.username.value==""){
               alert('用户名不能为空！！');
               document.myForm.username.focus();
               return false;
          }
          if(document.myForm.password.value==""){
               alert('密码不能为空！！');
               document.myForm.password.focus();
               return false;
          }
    }
</script></head><body id="login"><form action="__URL__/check_login" target='_self' id="loginForm" method="post" name="myForm" onSubmit="return checkForm();"><div class="top"><h3>培训报名系统</h3></div><label for="username"><span>用户名：</span><input id="username" name="username" type="text" /></label><label for="password"><span style="margin-left:1px;">密<div style="width:12px;height:10px;display:inline-block;"></div>码：</span><input id="password" name="password" type="password" /></label><div id="submit"><input name="submit" type="submit" class="bt" value="登&nbsp;&nbsp;录" /></div><div class="cl h12"></div><div name="提示框" id="tishi" class="tishi"><p style="padding: 10px;"><?php echo ($data); ?></p></div><div class="cl h12"></div></form></body></html>