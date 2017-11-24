<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title></title><link href="__PUBLIC__/css/index.css" rel="stylesheet" type="text/css" /><style type="text/css">
     form#pass input{
          margin:2px;
          padding:2px;
          height:22px;
          width:155px;
          line-height:20px;
          font-size:18px;
     }
     form#pass input#special{
          margin:0px;
          padding:0px;
          height:30px;
          width:80px;
          line-height:30px;
          font-size:18px;
          margin-top:10px;
          margin-left:100px;
     }
</style><script type="text/javascript">
      if('<?php echo ($password_data); ?>'=='123456'){
            alert("您的密码过于简单，请修改密码！");
            window.location="__URL__/editNewPassword";
      }
      if('<?php echo ($admin); ?>'==''){
            alert("请完善管理员资料！");
            return false;
      }
      window.onload=function(){
           document.myform.oldpass.focus();
      }
      function check(){
          if(document.myform.admin.value==""){
             alert('姓名不能为空');
             document.myform.admin.focus();
             return false;
         }
         if(document.myform.department.value==""){
             alert('部门不能为空');
             document.myform.department.focus();
             return false;
         }
         if(document.myform.mobile.value==""){
             alert('手机号码不能为空');
             document.myform.mobile.focus();
             return false;
         }
      }
</script></head><body id="page"><h2>管理员信息</h2><div style="font-size:18px;"><form action="__URL__/editAdmin" method="post" id="pass" name="myform" onsubmit="return check();">
        姓<div style="width:36px;height:30px;display:inline-block;"></div>名：<input type="text" name="admin" value="<?php echo ($data["admin"]); ?>"><br>
        部<div style="width:36px;height:30px;display:inline-block;"></div>门：<input type="text" name="department" value="<?php echo ($data["department"]); ?>"><br>
        手机号码：<div style="height:30px;display:inline-block;"></div><input type="text" name="mobile" value="<?php echo ($data["mobile"]); ?>"><br>
        固定电话：<div style="height:30px;display:inline-block;"></div><input type="text" name="tel" value="<?php echo ($data["tel"]); ?>"><br><input type="submit" name="submit" value="修改" id="special"></form></div></body></html>