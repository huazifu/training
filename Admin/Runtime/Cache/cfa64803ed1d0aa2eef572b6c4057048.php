<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>管理页面</title><link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet"><link href="__PUBLIC__/css/admin.css" rel="stylesheet" type="text/css" /><style type="text/css">
    table{
         width:700px;
         margin:0px;
         padding:0px;
    }
    table tr td{
       text-align:center;
       background-color:#0065AF;
       color:#fff;
       height:30px;
       line-height:30px;
       padding:0px;
       margin:0px;
       width:100px;
    }
    table tr.user_info td{
       text-align:center;
       background-color:#fff;
       color:#0065AF;
       height:30px;
       line-height:30px;
       padding:0px;
       margin:0px;
       width:100px;

    }
    table tr.user_info a,table tr.user_info a:visited{
       text-decoration:none;
    }
    table tr.user_info a:hover{
       text-decoration:underline;
    }
    table tr.user_info input{
        width:100px;
        font-size:14px;
        height:30px;
        line-height:30px;
        text-align:center;
    }
    table tr.user_info input.sex{
        width:18px;
        font-size:14px;
        height:30px;
        line-height:30px;
        border:0px;
        text-align:center

    }
    #userSqlForm input{
       height:20px;
       line-height:20px;
       font-size:14px;
    }
</style><script type="text/javascript">
     window.onload=function(){
         document.myform.id.focus();
     }
     function checkUserInfo(){
          if(isNaN(document.myform.usernum.value)){
             alert('序号必须为数字');
             document.myform.usernum.focus();
             return false;
         }
         if(document.myform.usernum.value==""){
             alert('序号不能为空');
             document.myform.usernum.focus();
             return false;
         }
         if(document.myform.name.value==""){
             alert('名称不能为空');
             document.myform.name.focus();
             return false;
         }
         if(document.myform.gradation.value==""){
             alert('请选择层次');
             document.myform.gradation.focus();
             return false;
         }
         if(document.myform.type.value==""){
             alert('请选择类型');
             document.myform.type.focus();
             return false;
         }
         if(document.myform.attribute.value==""){
             alert('请选择属别');
             document.myform.attribute.focus();
             return false;
         }
         if(document.myform.highlevel.value==""){
             alert('请选择高水平');
             document.myform.highlevel.focus();
             return false;
         }
     };
</script></head><body id="page"><h3>修改用户</h3><form action="__URL__/updateUserInfo" method="post" name="myform" onsubmit="return checkUserInfo();"><input type="hidden" name="id" value="<?php echo ($userInfo["id"]); ?>"><table><tr><td>序号</td><td>名称</td><td>层次</td><td>类型</td><td>属别</td><td>高水平</td><td>管理员姓名</td><td>所属部门</td><td>手机号码</td><td>固定电话</td><td>密码</td><td>操作</td></tr><tr class="user_info"><td><input type="text" name="usernum" value="<?php echo ($userInfo["usernum"]); ?>"></td><td><input type="text" name="name" value="<?php echo ($userInfo["name"]); ?>"></td><td><select autocomplete="off" name="gradation" ><option value="<?php echo ($userInfo["gradation"]); ?>" selected><?php echo ($userInfo["gradation"]); ?></option><option value="本科">本科</option><option value="高职">高职</option><option value="独立学院">独立学院</option></select></td><td><select autocomplete="off" name="type"><option value="<?php echo ($userInfo["type"]); ?>" selected><?php echo ($userInfo["type"]); ?></option><option value="公办">公办</option><option value="民办">民办</option></select></td><td><select autocomplete="off" name="attribute" ><option value="<?php echo ($userInfo["attribute"]); ?>" selected><?php echo ($userInfo["attribute"]); ?></option><option value="部属">部属</option><option value="省属">省属</option><option value="市属">市属</option></select></td><td><select autocomplete="off" name="highlevel" ><option value="<?php echo ($userInfo["highlevel"]); ?>" selected><?php echo ($userInfo["highlevel"]); ?></option><option value="是">是</option><option value="否">否</option></select></td><td><input type="text" name="admin" value="<?php echo ($userInfo["admin"]); ?>"/></td><td><input type="text" name="department" value="<?php echo ($userInfo["department"]); ?>"/></td><td><input type="text" name="mobile" value="<?php echo ($userInfo["mobile"]); ?>"/></td><td><input type="text" name="tel" value="<?php echo ($userInfo["tel"]); ?>"/></td><td><input type="text" name="password" value="<?php echo ($userInfo["password"]); ?>"></td><td><input type="submit" name="submit" value="修改"></td></tr></table><input type="hidden" name="oldName" value="<?php echo ($userInfo["name"]); ?>"></form></html>