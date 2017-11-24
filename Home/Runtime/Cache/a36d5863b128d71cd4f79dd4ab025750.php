<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>审核状态</title><link href="__PUBLIC__/css/page.css" rel="stylesheet" type="text/css" /><link href="__PUBLIC__/css/index.css" rel="stylesheet" type="text/css" /><!--<script src="__PUBLIC__/js/jquery-3.2.1.min.js"></script>--><style type="text/css">
    table {
      margin: 0px;
      padding: 0px;
      width: 100%;
    }
    td {
      width: 150px;
      padding: 0px;
      margin: 0px;
      height: 20px;
      line-height: 20px;
      text-align: center;
    }
    td.edit {
      width: 102px;
    }
    a,a:visited {
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    .green-black {
      padding-left: 350px;
      text-align: left;
    }
  </style><script>
        if('<?php echo ($password_data); ?>'=='123456'){
            alert("您的密码过于简单，请修改密码！");
            window.location="__URL__/editNewPassword";
        }
        if ('<?php echo ($admin); ?>' == '') {
            alert("请完善管理员资料！");
            window.location = "__URL__/administrator";
          }
  </script></head><body id="page"><h2>报名状态</h2><div style="clear:both;height:2px;"></div><table class="tableCheck"><tr><th>培训班</th><th>姓名</th><th>性别</th><th>职务</th><th>职称</th><th>手机</th><th>审核状态</th><th>操作</th></tr><?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr><td><?php echo ($vo["selectedCourse"]); ?></td><td><?php echo ($vo["signMan"]); ?></td><td><?php echo ($vo["sex"]); ?></td><td><?php echo ($vo["job"]); ?></td><td><?php echo ($vo["job_title"]); ?></td><td><?php echo ($vo["mobile"]); ?></td><td><a id="<?php echo ($vo["idNum"]); ?>" href="javascript:return false" style="cursor: default;text-decoration:none;"><?php echo ($vo["checking"]); ?></a></td><td><a id="<?php echo ($vo["idNum"]); ?>2" href="__URL__/quitCourse/idNum/<?php echo ($vo["idNum"]); ?>/num/<?php echo ($vo["course_num"]); ?>"/><i>退选</i></a></td><script type="text/javascript">
          var esc=document.getElementById('<?php echo ($vo["idNum"]); ?>2');
          var chec=document.getElementById('<?php echo ($vo["idNum"]); ?>');
          if('<?php echo ($vo["checking"]); ?>'=='已通过'){
              esc.href="javascript:return false";
              esc.style.cursor="default";
              esc.style.opacity="0.5";
              esc.style.display="none";
              chec.style.textDecoration="none";
          }
           if('<?php echo ($vo["checking"]); ?>'=='未通过'){
              esc.innerHTML="<a href='__URL__/failSign_Info/idNum/<?php echo ($vo["idNum"]); ?>'><font style='color:red;'>查看原因</font></a>";
           }
        </script></tr><?php endforeach; endif; else: echo "" ;endif; ?></table></body></html>