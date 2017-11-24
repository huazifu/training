<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>培训报名系统</title><link href="__PUBLIC__/css/index.css" rel="stylesheet" type="text/css" /><script type="text/javascript" src="__PUBLIC__/js/jquery-3.2.1.min.js" ></script><script type="text/javascript" src="__PUBLIC__/lib/layer/layer.js"></script><script type="text/javascript" src="__PUBLIC__/js/js3.js" ></script><script>
        if('<?php echo ($password_data); ?>'=='123456'){
            alert("您的密码过于简单，请修改密码！");
            window.location="__URL__/editNewPassword";
        }
        if ('<?php echo ($admin); ?>' == '') {
                alert("请完善管理员资料！");
                window.location = "__URL__/administrator";
            }
  </script></head><body id="page"><form action="__URL__/uploadform" method="post" name="myform" onsubmit="return checkaddCourse();"><!--报名表页面--><div style="width:970px; background:#F1F1F1; margin:20px auto; text-align:center;"><fieldset><div style="height:267px;"><table border="1" cellpadding="0" cellspacing="0" align="center" class="tableSign"><tr><td><font color="red">*</font>姓名</td><td style="text-align:left;"><input name="signMan" type="text" style="width:100%;"></td><td><font color="red">*</font>性别</td><td colspan="3"><input type="radio" name="sex" value="男" class='radio' checked><span style='padding-left:5px'>男</span><span style="padding:0 12px 0;"></span><input type="radio" name="sex" value="女" class='radio'><span style='padding-left:5px'>女</span></td></tr><tr><td><font color="red">*</font>民族</td><td style="text-align:left;"><input name="nation" type="text" style="width:100%;"></td><td><font color="red">*</font>政治面貌</td><td style="text-align:left;"><select autocomplete="off" name="politic" style="width:100%;"><option value="" selected>请选择</option><option value="中共党员">中共党员</option><option value="中共预备党员">中共预备党员</option><option value="共青团员">共青团员</option><option value="群众">群众</option><option value="民主党派">民主党派</option><option value="无党派人士">无党派人士</option></select></td></tr><tr><td><font color="red">*</font>部门</td><td colspan="4" style="text-align:left;"><input name="company" type="text" style="width:100%;"></td></tr><tr><td><font color="red">*</font>职务</td><td style="text-align:left;"><input type="text" name="job" style="width:100%;" style="width:100%;"></td><td><font color="red">*</font>职称</td><td colspan="2" style="text-align:left;"><input type="text" name="job_title" style="width:100%;"></td></tr><tr><td><font color="red">*</font>固定电话</td><td style="text-align:left;"><input type="text" name="phone" style="width:100%;"></td><td><font color="red">*</font>手机号码</td><td style="text-align:left;"><input type="text" name="mobile" style="width:100%;"></td></tr><tr><td><font color="red">*</font>培训班</td><td colspan="4" style="text-align:left;"><select id="select" name="course" style="width:100%;" onchange="getCourseMassage()"><option value="" selected>请选择培训班</option><?php if(is_array($course_info)): $i = 0; $__LIST__ = $course_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$co): $mod = ($i % 2 );++$i;?><option value="<?php echo ($co["num"]); ?>"><?php echo ($co["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></td></tr></table></div><h2 style="text-align:left;"><font color="red">注：以上信息均为必填内容，没有则填写无。</font></h2></fieldset><div style="height:10px;"></div><input name="提交" type="submit" class="submit" value="提交" /></div></form><script>
        function getCourseMassage(){
            layer.open({
            type: 1,
            title: '培训班信息',
            area: ['900px', '300px'],
            fixed: false, //不固定
            maxmin: false,
            content: "<table class='tableCourse'><tr><th>培训班名称</th><th>培训起止时间</th><th>培训地点</th><th>报到时间</th><th>报到地点</th><th>报名截止时间</th><th>参训学校</th><th>参训对象及人数</th><th>班主任</th></tr><tbody id='tab'></tbody></table>",
            btn: ['确定'],
            });
            //ajax获取后台信息
            $.ajax({
                type: 'get', 
                url:'__URL__/getCourseMessage',
                contentType:'charset=utf-8',
                data:"courseNum="+$('#select').val(),
                success:function (res){
                    // alert(JSON.stringify(res));
                    var tab=document.getElementById('tab');
                    //创建节点插入节点
                    var tr=document.createElement('tr');
                    tab.appendChild(tr);
                    var td3=document.createElement('td');td3.innerHTML=res.data.name;tr.appendChild(td3);
                    var td4=document.createElement('td');td4.innerHTML=res.data.start+'至'+res.data.end;tr.appendChild(td4);
                    var td5=document.createElement('td');td5.innerHTML=res.data.place;tr.appendChild(td5);
                    var td6=document.createElement('td');td6.innerHTML=res.data.short_checkdate+" "+res.data.short_checktime;tr.appendChild(td6);
                    var td7=document.createElement('td');td7.innerHTML=res.data.checkplace;tr.appendChild(td7);
                    var td8=document.createElement('td');td8.innerHTML=res.data.shortline;tr.appendChild(td8);
                    var td9=document.createElement('td');td9.innerHTML=res.data.school;tr.appendChild(td9);
                    var td10=document.createElement('td');td10.innerHTML=res.data.object;tr.appendChild(td10);
                    var td11=document.createElement('td');td11.innerHTML="<a href='javascript:void(0);' onclick='toTeacherInfo()'>"+res.data.teacname+"</a>";tr.appendChild(td11);
                    var div1=document.createElement('div');
                    div1.innerHTML="<input id='teacerMessage' type='hidden' value='"+res.data.id+"'/>";
                    tab.appendChild(div1);
                }
            })
        }
        function toTeacherInfo(){
            layer.open({
            type: 1,
            title: '班主任信息',
            area: ['450px', '200px'],
            fixed: false, //不固定
            maxmin: false,
            content:"<table class='tableTeac'><tr><th>姓名</th><th>固定电话</th><th>手机号码</th><th>QQ</th><th>电子邮箱</th></tr><tbody id='tabTeac'></tbody></table>"
            });
            $.ajax({
                type: 'get', 
                url:'__URL__/getTeacherInfo',
                contentType:'charset=utf-8',
                data:"id="+$('#teacerMessage').val(),
                success:function (res){
                    // alert(JSON.stringify(res));
                    var tabTeac=document.getElementById('tabTeac');
                    //创建节点插入节点
                    var tr=document.createElement('tr');
                    tabTeac.appendChild(tr);
                    var td0=document.createElement('td');td0.innerHTML=res.data.teacname;tr.appendChild(td0);
                    var td1=document.createElement('td');td1.innerHTML=res.data.teacphone;tr.appendChild(td1);
                    var td2=document.createElement('td');td2.innerHTML=res.data.teacmobile;tr.appendChild(td2);
                    var td3=document.createElement('td');td3.innerHTML=res.data.teacqq;tr.appendChild(td3);
                    var td4=document.createElement('td');td4.innerHTML=res.data.teacmail;tr.appendChild(td4);
                }
            })
        }
    </script></body></html>