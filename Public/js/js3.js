        window.onload=function(){
            document.myform.signMan.focus();
        }
            function checkaddCourse(){
                if(document.myform.signMan.value==""){
                    alert('请填写姓名');
                    document.myform.signMan.focus();
                    return false;
                }
                if(document.myform.nation.value==""){
                    alert('请填写民族');
                    document.myform.nation.focus();
                    return false;
                }
                if(document.myform.politic.value==""){
                    alert('请选择政治面貌');
                    document.myform.politic.focus();
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
                if(document.myform.job_title.value==""){
                    alert('请填写职称，没有请填写无');
                    document.myform.job_title.focus();
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
                if(document.myform.course.value==""){
                    alert('请选择培训班');
                    return false;
                }
                if(document.myform.school.value==""){
                    alert('请选择学校');
                    return false;
                }
            };