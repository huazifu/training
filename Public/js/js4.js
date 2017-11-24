        window.onload=function(){
            document.myform.name.focus();
        }
            function checkaddCourse(){
                if(document.myform.name.value==""){
                    alert('请填写姓名');
                    document.myform.name.focus();
                    return false;
                }
                if(document.myform.nation.value==""){
                    alert('请填写民族');
                    document.myform.nation.focus();
                    return false;
                }
                if(document.myform.year.value==""){
                    alert('请选择出生年月日');
                    document.myform.year.focus();
                    return false;
                }
                if(document.myform.politic.value==""){
                    alert('请选择政治面貌');
                    document.myform.politic.focus();
                    return false;
                }
                if(document.myform.edulevel.value==""){
                    alert('请选择文化水平');
                    document.myform.edulevel.focus();
                    return false;
                }
                if(document.myform.company.value==""){
                    alert('请填写部门');
                    document.myform.company.focus();
                    return false;
                }
                if(document.myform.job.value==""){
                    alert('请填写职务，没有请填写无');
                    document.myform.job.focus();
                    return false;
                }
                if(document.myform.jobtitle.value==""){
                    alert('请填写职称，没有请填写无');
                    document.myform.jobtitle.focus();
                    return false;
                }
                if(document.myform.phone.value==""){
                    alert('请填写固定电话，没有请填写无');
                    document.myform.phone.focus();
                    return false;
                }
                if(document.myform.mobile.value==""){
                    alert('请填写手机号码');
                    document.myform.mobile.focus();
                    return false;
                }
                if(document.myform.mail.value==""){
                    alert('请填写邮箱');
                    document.myform.mail.focus();
                    return false;
                }
                if(document.myform.coursename.value==""){
                    alert('请填写课程');
                    return false;
                }
                if(document.myform.category.value==""){
                    alert('请选择课程类别');
                    return false;
                }
                if(document.myform.direction.value==""){
                    alert('请填写课程方向');
                    return false;
                }
                if(document.myform.outline.value==""){
                    alert('请填写提纲');
                    return false;
                }
                if(document.myform.explain.value==""){
                    alert('请填写说明（课程成熟程度及其他事项说明）');
                    return false;
                }
                if(document.myform.resume.value==""){
                    alert('请填写个人简历及主要成绩');
                    return false;
                }
            };