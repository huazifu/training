<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>班主任信息</title><link href="__PUBLIC__/css/index.css" rel="stylesheet" type="text/css" /><link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet"><script>
        window.onload=function(){
             var oBtn1=document.getElementById('btn1');
             oBtn1.onclick=function(){
                window.location="__URL__/manageUserInfo";
             }
        }
    </script><style>
        .box{
            width:500px;
            background:#F1F1F1;
            margin:0 auto;
            font-size:14px;
            padding:8px;
        }
        #querybox{
            margin:5px;
        }
        #querybox #btn1{
           float: right;;
        }
        .box .title{
            color:gray;
            font-weight:bold;
            text-align:center;
        }
        .box .innerbox{
            overflow:auto;
            text-align:left;
        }
         .box .innerbox table{
            width: 100%;
         }
         .box .innerbox table tr,td{
            width: 50px;
         }
    </style></head><body id="page"><div class="box"><fieldset id="querybox"><legend class="title">管理员信息</legend><div class="innerbox"><table><tr><td>姓名</td><td style="text-align: left;"><?php echo ($data["admin"]); ?></td><td>部门</td><td style="text-align: left;"><?php echo ($data["department"]); ?></td></tr><tr><td>手机号码</td><td style="text-align: left;"><?php echo ($data["mobile"]); ?></td><td>固定电话</td><td style="text-align: left;"><?php echo ($data["tel"]); ?></td></tr></table></div><input type="button" id="btn1" class="submit" value="返回"/></fieldset></div></body></html>