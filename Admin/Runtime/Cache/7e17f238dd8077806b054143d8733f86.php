<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>管理页面</title><link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet"><link href="__PUBLIC__/css/page.css" rel="stylesheet" type="text/css" /><link href="__PUBLIC__/css/admin.css" rel="stylesheet" type="text/css" /><script src="__PUBLIC__/js/jquery-3.2.1.min.js"></script><script src="__PUBLIC__/js/bootstrap.min.js"></script><style type="text/css">
        table tr td {
            text-align: center;
            background-color: #0065AF;
            color: #fff;
        }

        table tr.user_info td {
            text-align: center;
            background-color: #fff;
            color: #0065AF;
        }

        table tr.user_info a,
        table tr.user_info a:visited {
            text-decoration: none;
        }

        table tr.user_info a:hover {
            text-decoration: underline;
        }
    </style></head><body id="page" style="position:relative;"><div id="alert" class="alert alert-warning" style="display:none;position:absolute;top:0px;left:0px;width:100%;height:60px;text-align:center;"><a href="#" class="close" data-dismiss="alert"></a><font color="red"><strong>警告！</strong>该操作会清空所有与该用户名称有关的数据且无法恢复，请慎重操作!</font></div><h3>高校信息</h3><table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr><td>序号</td><td>名称</td><td>层次</td><td>类型</td><td>属别</td><td>高水平</td><td>管理员</td><td>密码</td><td>操作</td></tr><?php if(is_array($user_info)): $i = 0; $__LIST__ = $user_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user_info): $mod = ($i % 2 );++$i;?><tr class="user_info"><td><?php echo ($user_info["usernum"]); ?></td><td><?php echo ($user_info["name"]); ?></td><td><?php echo ($user_info["gradation"]); ?></td><td><?php echo ($user_info["type"]); ?></td><td><?php echo ($user_info["attribute"]); ?></td><td><?php echo ($user_info["highlevel"]); ?></td><td><a href="__URL__/administrator/id/<?php echo ($user_info["id"]); ?>" style="text-decoration:underline;color:blue;"><?php echo ($user_info["admin"]); ?></a></td><td><?php echo ($user_info["password"]); ?></td><td><a href="__URL__/editUserInfo/id/<?php echo ($user_info["id"]); ?>">编辑</a>/<a id="<?php echo ($user_info["name"]); ?>" href="__URL__/deleteUserInfo/id/<?php echo ($user_info["id"]); ?>/name/<?php echo ($user_info["name"]); ?>">删除</a></td><script>
                    var del=document.getElementById('<?php echo ($user_info["name"]); ?>');
                    var alert=document.getElementById('alert');
                    del.onmouseover=function(){
                        alert.style.display="block";
                    }
                    del.onmouseout=function(){
                        alert.style.display="none";
                    }
                    del.style.color="red"; 
                </script></tr><?php endforeach; endif; else: echo "" ;endif; ?></table><div class="<?php echo ($pagestyle); ?>"><?php echo ($page); ?></div></br><?php if(($exportUser) > "0"): ?><a href="__URL__/exportUser"><font color="blue">导出表格</font></a><?php else: ?>没有记录<?php endif; ?></body></html>