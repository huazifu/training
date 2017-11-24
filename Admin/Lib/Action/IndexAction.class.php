<?php
//以下为后台模块的操作
class IndexAction extends Action{
    public function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
    }
    public function index(){
        $url=U("admin");
    	header("Location:$url");
    }
    public function check_logined(){    //检测是否已经登录，注意跟下面的判断是否登录成功是不同的，这个要调用在各个页面中。
    	session_start();
    	$user=M('Admin');
    	$condition['username']=$_SESSION['username'];
    	$us=$user->where($condition)->find();
        if(!$us){$this->assign("jumpUrl",'__ROOT__/');$this->error("还未登陆");}
    }
    public function exitCourse(){      //退出系统
    	$this->check_logined();
    	unset($_SESSION['username']);
    	$this->assign("jumpUrl",'__ROOT__/course.php');
    	$this->success("退出成功");
    }
    public function exitTraining(){      //退出系统
    	$this->check_logined();
    	unset($_SESSION['username']);
    	$this->assign("jumpUrl",'__ROOT__/');
    	$this->success("退出成功");
    }
    public function admin() {     //后台管理首页
    	$this->check_logined();
    	$date=date("Y年m月d日",time());
    	$this->assign('date',$date);
    	$this->assign('username',$_SESSION['username']);
    	$this->display();

	}

	//管理用户
    public function manageUserInfo(){
		$this->check_logined();
		session_start();
    	$user=M("User");
    	$count=$user->count();
    	$listRows=15;
        import("ORG.Util.Page");
        $p=new Page($count,$listRows);
        $limit_options=$p->firstRow.",".$p->listRows;
    	$user_info=$user->order("usernum")->limit($limit_options)->select();//排序
		$exportUser=0;
        if(count($user_info)>0) $exportUser=1;
        $this->assign("exportUser",$exportUser);
    	$displaypage=0;
    	if(count($user_info)>0) $displaypage=1;  //如果有信息才显示分页。
    	$page=$p->show();
    	$this->assign("displaypage",$displaypage);
    	$this->assign("page",$page);
    	$this->assign("pagestyle","green-black");
    	$this->assign("user_info",$user_info);
    	$this->display();
	}

	//管理课程用户
    public function manageCourseUser(){
		$this->check_logined();
		session_start();
    	$user = M("Course_user");
    	$count = $user->count();
    	$listRows = 15;
        import("ORG.Util.Page");
        $p = new Page($count,$listRows);
        $limit_options = $p->firstRow.",".$p->listRows;
    	$user_info = $user->order("id")->limit($limit_options)->select();//排序
		$exportUser = 0;
        if(count($user_info)>0) $exportUser = 1;
        $this->assign("exportUser",$exportUser);
    	$displaypage = 0;
    	if(count($user_info)>0) $displaypage = 1;  //如果有信息才显示分页。
    	$page = $p->show();
    	$this->assign("displaypage",$displaypage);
    	$this->assign("page",$page);
    	$this->assign("pagestyle","green-black");
    	$this->assign("user_info",$user_info);
    	$this->display();
	}
	
	//班主任信息
	public function teacher(){
		$this->check_logined();
		session_start();
		$m=M('Course');
		$condition['id']=$_GET['id'];
		$data=$m->where($condition)->find();
		$this->assign('data',$data);
		$this->display();
	}
	//管理员信息
	public function administrator(){
		$this->check_logined();
		session_start();
		$m=M('User');
		$condition['id']=$_GET['id'];
		$data=$m->where($condition)->find();
		$this->assign('data',$data);
		$this->display();
	}

	//导出高校信息表
	public function exportUser(){
		$this->check_logined();
    	session_start();
		header("Content-type:application/octet-stream");
    	header("Accept-Ranges:bytes");
    	header("Content-type:application/vnd.ms-excel");
    	header("Content-Disposition:attachment;filename=高校信息表.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		$user=M("User");
    	$user_info=$user->order("usernum")->select();
    	$this->assign("user_info",$user_info);
    	$this->display();
	}
	//导出课程系统用户账号表
	public function exportCourseUser(){
		$this->check_logined();
    	session_start();
		header("Content-type:application/octet-stream");
    	header("Accept-Ranges:bytes");
    	header("Content-type:application/vnd.ms-excel");
    	header("Content-Disposition:attachment;filename=课程系统用户账号表.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		$user=M("Course_user");
    	$user_info=$user->order("userid")->select();
    	$this->assign("user_info",$user_info);
    	$this->display();
	}

	//编辑用户
    public function editUserInfo(){
		$this->check_logined();
		session_start();
        $user=M("User");
        $id=$_GET['id'];
        if(empty($id))   $this->error("参数为空");
        $userInfo=$user->where("id=$id")->find();
        $this->assign("userInfo",$userInfo);
        $this->display();
	}

	//编辑课程用户
    public function editCourseUser(){
		$this->check_logined();
		session_start();
        $user=M("Course_user");
        $id = $_GET['id'];
        if(empty($id))   $this->error("参数为空");
        $userInfo=$user->where("id=$id")->find();
        $this->assign("userInfo",$userInfo);
        $this->display();
	}

	//更新用户
    public function updateUserInfo(){
		$this->check_logined();
		$s = M('Signed_up');
		$condition2['school'] = $_POST['oldName'];
		$arrSchool = $s->where($condition2)->select();
		for($i = 0; $i <= count($arrSchool); $i++){
			$idNum = $arrSchool[$i][idNum];
			$condition3['idNum'] = $idNum;
			$data2['school'] = $_POST['name'];
			$data2['schoolNum'] = $_POST['usernum'];
			$count2 = $s->where($condition3)->save($data2);
		}
				
        $user = M('User');
    	$condition1['id'] = $_POST['id'];
		$data1['usernum'] = $_POST['usernum'];
		$data1['name'] = $_POST['name'];
		$data1['gradation'] = $_POST['gradation'];
		$data1['type'] = $_POST['type'];
		$data1['attribute'] = $_POST['attribute'];
		$data1['highlevel'] = $_POST['highlevel'];
		$data1['password'] = $_POST['password'];
		$data1['admin'] = $_POST['admin'];
		$data1['department'] = $_POST['department'];
		$data1['mobile'] = $_POST['mobile'];
		$data1['tel'] = $_POST['tel'];
    	$count1 = $user->where($condition1)->save($data1);
		if($count1 >= 0){
			$this->success("修改成功","manageUserInfo");
		}else{
			$this->error("修改失败");
		}
	}

	//更新课程用户
    public function updateCourseUser(){
		$this->check_logined();
		$us = M('Course_user');
		$condition['userid'] = $_POST['userid'];
		$userid = $us->where($condition)->getField('userid');
		if(!$userid){$this->error('修改失败！账号不存在！');}
		$data['pass'] = $_POST['pass'];
		$count = $us->where($condition)->save($data);
		if($count >= 0){
			$this->success('重设密码成功！','manageCourseUser');
		}else{
			$this->error('重设密码失败！');
		}
    }

    public function deleteUserInfo(){      //删除用户
    	 $this->check_logined();
		 $school=$_GET['name'];
    	 $id=$_GET['id'];
    	 $condition['id']=$id;
    	 $user=M('User');
    	 if(!$user->where($condition)->limit('1')->delete()){
    	 	$this->error("删除失败");
    	 }
		 //删除用户选课信息
		 $m=M("Signed_up");
		 $s=M('Course');
    	 if($m->where("school='$school'")->select()){
		 	//把该学校的所有选课编号选出来赋给一个数组，遍历数组取出num
			$arr=$m->field('course_num')->where("school='$school'")->select();
			for($i=0;$i<count($arr);$i++){
				$course_num=$arr[$i][course_num];//定义一个变量存储每次循环的值
				$s->where("num=$course_num")->setDec('selectedMan',1);//用数组循环
			}
			$m->where("school='$school'")->delete();
    	 }
    	 $this->success("删除成功");
	}
	//删除课程用户
    public function deleteCourseUser(){
    	$this->check_logined();
		//删除用户相关信息
		$app = M("Apply_course");
		$us = M('Course_user');
		$condition['userid'] = $_GET['userid'];
		if( $app->where($condition)->select() ){
			$app->where($condition)->delete();
		}
		$count = $us->where($condition)->delete();
		if($count > 0){
			$this->success("删除成功");
		}else{
			$this->error('删除失败！');
		}
    }
	//添加用户页面
    public function importUserInfo(){
		$this->check_logined();
		session_start();
    	$this->display();
	}
	//添加课程用户页面
    public function addCourseUser(){
		$this->check_logined();
		session_start();
    	$this->display();
	}
	//添加用户信息
    public function addUserInfo(){
		$this->check_logined();
		session_start();
    	$user = M('User');
    	if(!$user->create()){
    		$this->error("添加失败");
    	}
    	if(!$user->add()){
    		$this->error("添加失败");
    	}
    	$this->success("添加成功");
	}

	//添加课程用户信息
    public function addCourseUserInfo(){ 
		$this->check_logined();
		session_start();
    	$user = M('Course_user');
    	if(!$user->create()){
    		$this->error("添加失败");
    	}
    	if(!$user->add()){
    		$this->error("添加失败");
    	}
    	$this->success("添加成功");
    }

	//修改管理员密码
    public function editPassword(){     
		$this->check_logined();
		session_start();
    	$this->display();
    }

	//更新管理员密码
    public function updatePassword(){   
    	$this->check_logined();
    	$admin=M("Admin");
    	$oldpass=md5($_POST['oldpass']);
    	$condition['password']=$oldpass;
    	if(!$adminInfo=$admin->where($condition)->find()) $this->error("旧密码错误");
    	$newpass=md5($_POST['newpass']);
    	$condition['username']=$_SESSION['username'];
    	$data['password']=$newpass;
    	if(!$admin->where($condition)->save($data)) $this->error("修改失败");
    	$this->success("修改成功");
    }
	//显示修改登录框页面
	public function modifylogin(){
		$this->check_logined();
		$m=M('Info');
		$arr=$m->where('id=1')->getField('loginInfo');
		$this->assign('data',$arr);
		$this->display();
	}
	//修改登录框信息操作
	public function updatelogin(){
		$this->check_logined();
		$m=M('Info');
		$data['id']=1;
		$data['loginInfo']=$_POST['txt'];
		$count=$m->save($data);
		if($count>=0){
			$this->success("数据修改成功","modifylogin");
		}else{
			$this->error("数据修改失败");
		}
	}
	//短信模块
	public function message(){
		$this->check_logined();
		session_start();
		$c = M('Info');
		$arr = $c->where('id=1')->getField('smsContent');
		$this->assign('data',$arr);
		$this->display();
	}
	//模糊查询学员
	public function searchStu(){
		$this->check_logined();
		session_start();
		$condition['checking'] = "已通过";
		$condition['sms'] < 1;
		if($_POST['submit']){
    		switch($_POST['search_type']){
    			case "course_num":$condition['course_num']=array("like","%$_POST[keyword]%");break;
    			case "course_name":$condition['selectedCourse']=array("like","%$_POST[keyword]%");break;
    		}
    	}
		$m = M('Signed_up');
    	$arr1 = $m->order('course_num desc')->where($condition)->select();
		$this->assign('data',$arr1);
		$c = M('Info');
		$arr2 = $c->where('id=1')->getField('smsContent');
		$this->assign('content',$arr2);
		$this->display();
	}
	//发信箱
	public function sendsms(){
		$this->check_logined();
		session_start();
		$condition['checking']="已通过";
		$condition['sms']=1;
		if($_POST['submit']){
    		switch($_POST['search_type']){
    			case "course_num":$condition['course_num']=array("like","%$_POST[keyword]%");break;
    			case "course_name":$condition['selectedCourse']=array("like","%$_POST[keyword]%");break;
    		}
    	}
		$m = M('Signed_up');
    	$arr1 = $m->order('sendtime desc')->where($condition)->select();
		$this->assign('data',$arr1);
		$c = M('Info');
		$arr2 = $c->where('id=1')->getField('smsContent');
		$this->assign('content',$arr2);
		$this->display();
	}

	//从发信箱移除
	public function delsms(){
		$this->check_logined();
		$condition['idNum']=$_GET['idNum'];
		$m=M('Signed_up');
		$data['sms']=2;
		$count=$m->where($condition)->save($data);
		if($count>0){
			$this->success('移除成功！');
		}
	}
	
	//修改短信内容
	public function modifySendContent(){
		$this->check_logined();
		$c = M('Info');
		$data['id'] = 1;
		$data['smsContent'] = $_POST['sendContent'];
		$count = $c->save($data);
		if($count >= 0){
			$this->success("修改成功","message");
		}else{
			$this->error("修改失败");
		}

	}
	 //单发短信
	public function SingleSend(){
		$this->check_logined();
		$num = $_GET['course_num'];
		$m = M('Course');
		$course_data = $m -> where("num=$num") -> find();
		$checkDate = $course_data['short_checkdate'];
		$checkTime = $course_data['short_checktime'];
		$place = $course_data['place'];
		$name = $_GET['name'];
		$course = $_GET['course'];
		$mobile = $_GET['mobile'];
		$host = "http://211.147.239.62:9050/cgi-bin/sendsms?";
		$c = M('Info');
		$tpl_content = $c->where('id=1')->getField('smsContent');
		$replace_content = array($course , $checkDate , $place);
		$replace_tpl = array('#course#' , '#date#' , '#place#');
		for($i = 0; $i < 3; $i++){
			$tpl_content = str_replace($replace_tpl[$i],$replace_content[$i],$tpl_content);
		}
		$content_GBK = iconv( "UTF-8", "GBK", $tpl_content);
    	$querys = "username=jy@bjhg&password=E053OkHU&to=" . $mobile . "&text=" . $content_GBK . "&subid=&msgtype=4";
    	$url = $host . $querys;

    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_HEADER,0);
		$output = curl_exec($curl);
		curl_close($curl);

		if($output == 0){
			$sms = M('Signed_up');
			import('ORG.Util.Date');
			$datetime = date("Y-m-d H:i:s",time());
			$data['sms'] = 1;
			$data['sendtime'] = $datetime;
			$condition['checking'] = "已通过";
			$condition['mobile'] = $mobile;
			$count = $sms -> where($condition) -> save($data);
			if($count >= 0){
				$this -> success($mobile . "发送成功！");
			}
		}else if($output == -99){
			echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>内部处理错误</h3>";
		}else if($output == -6){
			echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>密码错误</h3>";
		}else if($output == -3){
			echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>用户载入延迟</h3>";
		}else if($output == -2){
			echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>发送参数不正确</h3>";
		}else if($output == -7){
			echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>用户不存在</h3>";
		}else if($output == -12){
			echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>余额不足，请<a href='http://211.147.239.62'>充值</a>恢复使用！</h3>";
		}else if($output == "其他"){
			echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>未知错误</h3>";
		}
	} 
	  //多发短信
	public function send(){
		$this->check_logined();
		$checkbox_arr = $_POST['checkbox'];
		foreach ($checkbox_arr as $key => $value){
			$condition['idNum'] = $value;
			$condition['checking'] = "已通过";
			$sign = M('Signed_up');
			$sign_data = $sign -> where($condition) -> find();
			$num = $sign_data['course_num'];
			$name = $sign_data['signMan'];
			$course = $sign_data['selectedCourse'];
			$mobile = $sign_data['mobile'];
			$m = M('Course');
			$course_data = $m -> where("num=$num")->find();
			$checkDate = $course_data['short_checkdate'];
			$checkTime = $course_data['short_checktime'];
			$place = $course_data['place'];
			$host = "http://211.147.239.62:9050/cgi-bin/sendsms?";
			$tpl_content = $_POST['smsContent'];
			$replace_content = array($course , $checkDate , $place);
			$replace_tpl = array('#course#' , '#date#' , '#place#');
			for($i = 0; $i < 3; $i++){
				$tpl_content = str_replace($replace_tpl[$i],$replace_content[$i],$tpl_content);
			}
			$content_GBK = iconv( "UTF-8", "GBK", $tpl_content);
			$querys = "username=jy@bjhg&password=E053OkHU&to=" . $mobile . "&text=" . $content_GBK . "&subid=&msgtype=4";
    		$url = $host . $querys;

    		$curl = curl_init();
    		curl_setopt($curl, CURLOPT_URL, $url);
    		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl,CURLOPT_HEADER,0);
			$output=curl_exec($curl);
			curl_close($curl);
			
			if($output == 0){
				$sms=M('Signed_up');
				import('ORG.Util.Date');
				$datetime = date("Y-m-d H:i:s" , time());
				$data['sms'] = 1;
				$data['sendtime'] = $datetime;
				$condition2['checking'] = "已通过";
				$condition2['idNum'] = $value;
				$condition2['mobile'] = $mobile;
				$count = $sms -> where($condition2) -> save($data);
				if($count >= 0){
					echo "<br><br><h2>" . $mobile . "发送成功！</h2>";
				} 
			}else if($output == -99){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>内部处理错误</h3>";
			}else if($output == -6){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>密码错误</h3>";
			}else if($output == -3){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>用户载入延迟</h3>";
			}else if($output == -2){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>发送参数不正确</h3>";
			}else if($output == -7){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>用户不存在</h3>";
			}else if($output == -11){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>一次最多发送100个号码</h3>";
			}else if($output == -12){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>余额不足，请<a href='http://211.147.239.62'>充值</a>恢复使用！</h3>";
			}else if($output == "其他"){
				echo "<br><br><h2>" . $mobile . "发送失败！</h2><h3>未知错误</h3>";
			}
		}	
	}  
	//查管理培训页面
	public function manageCourse(){
		$this->check_logined();
		session_start();
		if($_POST['submit']){
    		switch($_POST['search_type']){
    			case "course_num":$condition['num']=array("like","%$_POST[keyword]%");break;
    			case "course_name":$condition['name']=array("like","%$_POST[keyword]%");break;
    		}
    	}
		$m = M('Course');
		$count = $m -> count();
    	$listRows = 15;
        import("ORG.Util.Page");
        $p = new Page($count,$listRows);
        $limit_options = $p->firstRow.",".$p->listRows;
    	$arr = $m -> where($condition) -> order("num desc") -> limit($limit_options) -> select();
    	$displaypage = 0;
    	if(count($arr) > 0) $displaypage = 1;
    	$page = $p->show();
    	$this -> assign("displaypage",$displaypage);
    	$this -> assign("page",$page);
    	$this -> assign("pagestyle","green-black");
		$this -> assign('course_info',$arr);
		$this -> display();
	}
	//删除培训操作
	public function delCourse(){
		$this -> check_logined();
		$m = M('Course');
		$id = $_GET['id'];
		$count = $m -> delete($id);
		if($count > 0){
			$this -> success("数据删除成功");
		}else{
			$this -> error("数据删除失败");
		}
	}
	//显示修改培训页面
	public function modifyCourse(){
		$this->check_logined();
		session_start();
		$m=M('Course');
		$condition['id']=$_GET['id'];
		$arr=$m->where($condition)->find();
		$this->assign('data',$arr);
		$this->display();
	}
	//修改培训操作
	public function updateCourse(){
		$this->check_logined();
		$m=M('Course');
		$condition['id']=$_POST['id'];
		$data['num']=$_POST['num'];
		$data['name']=$_POST['name'];
		$data['start']=$_POST['start'];
		$data['year']=substr($_POST['start'],0,4);
		$data['tostart']=strtotime($_POST['start']);
		$data['end']=$_POST['end'];
		$data['long']=((strtotime($_POST['end'])-strtotime($_POST['start']))/86400)+1;
		$data['place']=$_POST['place'];
		$data['checktime']=$_POST['checktime'];
		$data['short_checkdate']=substr($_POST['checktime'],0,10);
		$data['short_checktime']=substr($_POST['checktime'],-8,5);
		$data['checkplace']=$_POST['checkplace'];
		$data['deadline']=$_POST['deadline'];
		$data['todeadline']=strtotime($_POST['deadline']);
		$data['shortline']=substr($_POST['deadline'],0,16);
		$data['director']=$_POST['director'];
		$data['object']=$_POST['object'];
		$data['school']=$_POST['school'];
		$data['teacname']=$_POST['teacname'];
		$data['teacphone']=$_POST['teacphone'];
		$data['teacmobile']=$_POST['teacmobile'];
		$data['teacmail']=$_POST['teacmail'];
		$data['teacqq']=$_POST['teacqq'];
		$data['remarks']=$_POST['remarks'];
		$count=$m->where($condition)->save($data);
		if($count>=0){
			$this->success("数据修改成功","manageCourse");
		}else{
			$this->error("数据修改失败");
		}
	}
	//添加培训操作
	public function createCourse(){
		$this->check_logined();
		$m=M('Course');
		$m->num=$_POST['num'];
		$m->name=$_POST['name'];
		$m->start=$_POST['start'];
		$m->year=substr($_POST['start'],0,4);
		$m->tostart=strtotime($_POST['start']);
		$m->end=$_POST['end'];
		$m->long=((strtotime($_POST['end'])-strtotime($_POST['start']))/86400)+1;
		$m->place=$_POST['place'];
		$m->checktime=$_POST['checktime'];
		$m->short_checkdate=substr($checktime,0,10);
		$m->short_checktime=substr($checktime,-8,5);
		$m->checkplace=$_POST['checkplace'];
		$deadline=$_POST['deadline'];
		$m->deadline=$deadline;
		$m->shortline=substr($deadline,0,16);
		$m->todeadline=strtotime($_POST['deadline']);
		$m->director=$_POST['director'];
		$m->object=$_POST['object'];
		$m->school=$_POST['school'];
		$m->remarks=$_POST['remarks'];
		$m->teacname=$_POST['teacname'];
		$m->teacphone=$_POST['teacphone'];
		$m->teacmobile=$_POST['teacmobile'];
		$m->teacmail=$_POST['teacmail'];
		$m->teacqq=$_POST['teacqq'];
		$idNum=$m->add();
		if($idNum>0){
			$this->success("数据添加成功");
		}else{
			$this->error("数据添加失败！该培训编号已存在，请输入新的培训编号");
		}
	}
	//显示审核报名页面
	public function checkSignInfo(){
		$this->check_logined();
		session_start();
		import('ORG.Util.Date');
		$date = new DateTime;
		$nowtime=$date->format("Y-m-d h:m:s");
		$tonow=strtotime($nowtime);
		$s=M('Course');
		$course=$s->where("tostart>=$tonow")->select();
		$this->assign('course',$course);
		$this->display();
	}
	//异步根据课程获取报名
	public function getCheckSign(){
		$this->check_logined();
		$courseNum=$_GET['num'];
		$m=M("Signed_up");
		$condition['checking'] = "待审核";
		$condition['course_num']=$courseNum;
		$data=$m->where($condition)->select();
    	$this->ajaxReturn($data,"有数据",1);
	}

	//显示审核报名表页面
	public function checkUserSign(){
		$this->check_logined();
		$m=M('Signed_up');
		$idNum=$_GET['idNum'];
		$arr=$m->find($idNum);
		$this->assign('data',$arr);
		$this->display();
	}

	//修改审核报名表
	public function modifyCheckUser(){
		$this->check_logined();
		$m = M('Signed_up');
		import('ORG.Util.Date');
		$date = new DateTime;
		$nowtime = $date->format("Y-m-d h:m:s");
		$tonow = strtotime($nowtime);
		$s = M('Course');
		$course = $s->where("tostart>=$tonow")->select();
		$idNum = $_GET['idNum'];
		$arr = $m->find($idNum);
		$this->assign('data',$arr);
		$this->assign('course_info',$course);
		$s = M("User");
		$userData = $s->select();
		$this->assign("userData",$userData);		
		$this->display();
	}
	//提交修改
	public function saveCheckUser(){
		$this->check_logined();
		import('ORG.Util.Date');
		$date = new DateTime;
		$nowtime = $date->format("Y-m-d h:m:s");
		$tonow = strtotime($nowtime);
		$s = M('Course');
		$condition1['num'] = $_POST['courseNum'];
		$condition3['num'] = $_POST['course_num'];
		$courseName = $s->where($condition1)->getField('name');
		$todeadline = $s->where($condition1)->getField('todeadline');
		$u =M('User');
		$condition2['name'] = $_POST['school'];
		$schoolNum = $u->where($condition2)->getField('usernum');
		// if($todeadline>=$tonow){
			$s->where($condition3)->setDec('selectedMan',1);
			$s->where($condition1)->setInc('selectedMan',1);
			$m=M('Signed_up');
			$condition2['idNum'] = $_POST['idNum'];
			$data['signMan'] = $_POST['signMan'];
			$data['sex'] = $_POST['sex'];
			$data['nation'] = $_POST['nation'];
			$data['politic'] = $_POST['politic'];
			$data['company'] = $_POST['company'];
			$data['job'] = $_POST['job'];
			$data['job_title'] = $_POST['job_title'];
			$data['phone'] = $_POST['phone'];
			$data['mobile'] = $_POST['mobile'];
			$data['schoolNum'] = $schoolNum;
			$data['school'] = $_POST['school'];
			$data['course_num'] = $_POST['courseNum'];
			$data['selectedCourse'] = $courseName;
			$count = $m->where($condition2)->save($data);
			if($count >= 0){
				$this->success("修改成功");
			}else{
				$this->error("修改失败，未知错误");
			}
		// }else{
		// 	$this->error("修改失败，该培训班报名已截止！");
		// }		
	}
	//审核通过
	public function passSign(){
		$this->check_logined();
		$s = M('Course');
		$condition['num'] = $_GET['num'];
		$s->where($condition)->setInc('selectedMan',1);
		$m=M('Signed_up');
		$data['idNum']=$_GET['idNum'];
		$data['checking']='已通过';
		$count=$m->save($data);
		if($count>0){
			$this->redirect("checkSignInfo");
		}else{
			$this->error('操作失败');
		}	
	}
	//全部审核通过
	public function allPassSign(){
		$this->check_logined();
		$m=M('Signed_up');
		$condition2['course_num']=$_GET['num'];
		$data['checking']='已通过';
		$count=$m->where($condition2)->save($data);
		$s = M('Course');
		$condition1['num'] = $_GET['num'];
		$s->where($condition1)->setInc('selectedMan',$count);
		if($count>0){
			$this->redirect("checkSignInfo");
		}else{
			$this->error("操作失败，没有待审核报名！");
		}
	}
	//审核不通过
	public function failSign(){
		$this->check_logined();
		session_start();
		$m=M('Signed_up');
		$data['idNum']=$_GET['idNum'];
		$this->assign('data',$data['idNum']);
		$this->display();
	}
	//审核不过原因操作
	public function failSignInfo(){
		$this->check_logined();
		$m=M('Signed_up');
		$data['idNum']=$_POST['idNum'];
		$data['failInfo']=$_POST['txt'];
		$data['checking']='未通过';
		$count=$m->save($data);
		if($count>0){
			$this->redirect("checkSignInfo");
		}else{
			$this->error("数据提交失败");
		}
	}
	//管理员移除未通过的申请
	public function delfailSign(){
		$this->check_logined();
		//对应培训selecteMan加-1
		$s=M('Course');
		$num=$_GET['num'];
		$s->where("num='$num'")->setDec('selectedMan',1);
		$m=M('Signed_up');
		$idNum=$_GET['idNum'];
		$count=$m->delete($idNum);
		if($count>0){
			$this->success("数据删除成功");
		}else{
			$this->error("数据删除失败");
		}
	}
	
	//学员分组
	public function stuGroup(){
		$this->check_logined();
		session_start();
		if($_POST['submit']){
    		switch($_POST['search_type']){
    			case "course_num":$condition['num']=array("like","%$_POST[keyword]%");break;
    			case "course_name":$condition['name']=array("like","%$_POST[keyword]%");break;
    		}
    	}
		$m=M('Course');
    	$arr=$m->order("num desc")->where($condition)->select();
		$this->assign('data',$arr);
		$this->display();
	}
	//设置分组
	public function setGroup(){
		$this->check_logined();
		$m=M('Signed_up');
		$condition['checking']="已通过";
		$condition['course_num']=$_GET['num'];
		$arr=$m->order("schoolNum")->where($condition)->select();
		$this->assign('data',$arr);
		$this->display();
	}
	
	//导出学员表_顺序排列
	public function exportgroup1(){
		$this->check_logined();
		$txt=$_GET['txt'];
		$this->assign('txt',$txt);
		$m=M('Signed_up');
		$condition['checking']="已通过";
		$condition['course_num']=$_GET['num'];
		$arr=$m->where($condition)->select();
		$this->assign('data',$arr);
		header("Content-type:application/octet-stream");
    	header("Accept-Ranges:bytes");
    	header("Content-type:application/vnd.ms-excel");
    	header("Content-Disposition:attachment;filename=学员表.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		$this->display();
	}
	//导出学员表_S型排列
	public function exportgroup2(){
		$this->check_logined();
		$txt=$_GET['txt'];
		header("Content-type:application/octet-stream");
    	header("Accept-Ranges:bytes");
    	header("Content-type:application/vnd.ms-excel");
    	header("Content-Disposition:attachment;filename=学员表.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		$this->assign('txt',$txt);
		$this->display();
	}
	//添加学员
	public function addStu(){
		$this->check_logined();
		session_start();
		if($_POST['submit']){
    		switch($_POST['search_type']){
    			case "course_num":$condition['num']=array("like","%$_POST[keyword]%");break;
    			case "course_name":$condition['name']=array("like","%$_POST[keyword]%");break;
    		}
    	}
		$m=M('Course');
    	$arr=$m->order("num desc")->where($condition)->select();
		$this->assign('data',$arr);
		$this->display();
	}
	//管理学员
	public function manageStu(){
		$this->check_logined();
		session_start();
		$m=M('Signed_up');
		$condition['checking']="已通过";
		$condition['course_num']=$_GET['num'];
		$arr=$m->order("schoolNum")->where($condition)->select();
		$this->assign('data',$arr);
		$this->display();
	}
	//get报名表
	public function createStu(){
		$this->check_logined();
		session_start();
		import('ORG.Util.Date');
    	$course = M("Course");
		$date = new DateTime;
		$nowtime = $date->format("Y-m-d");
		$tonow = strtotime($nowtime);
    	$course_info = $course->where("tostart>=$tonow")->select();
		$this->assign("course_info",$course_info);
		$s = M("User");
		$userData = $s->select();
		$this->assign("userData",$userData);		
    	$this->display();
	}
	//提交学员表
	public function addStuInfo(){
		$this->check_logined();
		import('ORG.Util.Date');
		$date = new DateTime;
		$nowtime=$date->format("Y-m-d h:m:s");
		$tonow=strtotime($nowtime);
		$s = M('Course');
		$condition['num'] = $_POST['course'];
		$courseName = $s->where($condition)->getField('name');
		$todeadline = $s->where($condition)->getField('todeadline');
		$u =M('User');
		$condition2['name'] = $_POST['school'];
		$schoolNum = $u->where($condition2)->getField('usernum');
		if($todeadline>=$tonow){
			$s->where($condition)->setInc('selectedMan',1);
			$m = M('Signed_up');
			$m->signMan = $_POST['signMan'];
			$m->sex = $_POST['sex'];
			$m->nation = $_POST['nation'];
			$m->politic = $_POST['politic'];
			$m->company = $_POST['company'];
			$m->job = $_POST['job'];
			$m->job_title = $_POST['job_title'];
			$m->phone = $_POST['phone'];
			$m->mobile = $_POST['mobile'];
			$m->schoolNum = $schoolNum;
			$m->school = $_POST['school'];
			$m->course_num = $_POST['course'];
			$m->selectedCourse = $courseName;
			$m->checking = "已通过";
			$idNum = $m->add();
			if($idNum>0){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->error("添加失败，该培训班报名已截止！");
		}
	}
	//删除学员
	public function delStuInfo(){
		$this->check_logined();
		//已选课程减1
		$s=M('Course');
		$condition1['num'] = $_GET['num'];
		$s->where($condition1)->setDec('selectedMan',1);
		//删除学员
		$m = M('Signed_up');
		$condition2['idNum'] = $_GET['idNum'];
		$count=$m->where($condition2)->delete();
		if($count>0){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}
	//导出审核汇总表
	public function exportCheckSign(){
		$this->check_logined();
		$s = M('Course');
		$condition1['num'] = $_GET['num'];
		$course = $s->where($condition1)->getField('name');
		header("Content-type:application/octet-stream");
    	header("Accept-Ranges:bytes");
    	header("Content-type:application/vnd.ms-excel");
    	header("Content-Disposition:attachment;filename=" . $course . "报名审核表.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		$m = M('Signed_up');
		$condition2['checking'] = "待审核";
		$condition2['selectedCourse'] = $course;
    	$arr = $m->where($condition2)->select();
		$this->assign('data',$arr);
		$this->display();
	}
	
	//获取年度信息统计
	public function getYearAjax(){
		$this->check_logined();
		$condition['year']=$_GET['year'];
		$m=M("Course");
		$data=$m->where($condition)->select();
    	$this->ajaxReturn($data,"有数据",1);
	}
	//按数据库年份下拉列表
	public function countCourse(){
		$this->check_logined();
		$year = M('Course');
		$arr = $year->order('year desc')->select();
		$data = array();
		for($i = 0; $i < count($arr); $i++){
			if($arr[$i]['year'] != $arr[$i+1]['year']){
				array_push ( $data , $arr[$i]['year']);
			}			   
		}
		// print_r($data);
		$str=json_encode($data);
		$this->assign('str',$str);
		$this->display();
	}
	//导出培训统计表
	public function exportCourse(){
		$this->check_logined();
    	$condition['year']=$_GET['year'];
		header("Content-type:application/octet-stream");
    	header("Accept-Ranges:bytes");
    	header("Content-type:application/vnd.ms-excel");
    	header("Content-Disposition:attachment;filename=".$_GET['year']."年信息统计表.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		$m=M('Course');
    	$arr=$m->where($condition)->select();
		$this->assign('data',$arr);
		$this->display();
	}
	//显示未审核申报表
	public function checkApplyCourse(){
		$this->check_logined();
		session_start();
		$m = M('Apply_course');
		$data = $m->where("status != '已通过'")->select();
		$this->assign('data',$data);
		$this->display();
	}
	//显示已审核申报表
	public function checkedApply(){
		$this->check_logined();
		session_start();
		$m = M('Apply_course');
		$condition['status'] = '已通过';
		$data = $m->where($condition)->select();
		$this->assign('data',$data);
		$this->display();
	}
	//通过审核
	public function checkApply(){
		$this->check_logined();
		session_start();
		$m = M('Apply_course');
		$data['status'] = '已通过';
		$condition['id'] = $_GET['id'];
		$count = $m -> where($condition) -> save($data);
		if($count >= 0){
			$this->success('审核通过','__URL__/checkApplyCourse');
			// $this->redirect("checkApplyCourse");
		}else{
			$this->error("审核失败");
		}
	}
	//查看申报表
	public function ApplyCourseMore(){
		$this->check_logined();
		session_start();
		$condition['id'] = $_GET['id'];
		$m = M('Apply_course');
		$data = $m->where($condition)->find();
		$this->assign('data',$data);
		$this->display();
	}
	//审核失败
	public function failApply(){
		$this->check_logined();
		session_start();
		$m = M('Apply_course');
		$data['status'] = '未通过';
		$data['fail'] = $_POST['fail'];
		$condition['id'] = $_POST['id'];
		$count = $m -> where($condition) -> save($data);
		if($count > 0){
			$this->success("操作成功","__URL__/checkApplyCourse");
		}else{
			$this->error("操作失败");
		}
	}
	//显示课程审核不过通知
	public function failApplyCourse(){
		$this->check_logined();
		session_start();
		$condition['id'] = $_GET['id'];
		$m = M('Apply_course');
		$data = $m->where($condition)->find();
		$this->assign('data',$data);
		$this->display();
	}
	//导出课程审核
	public function exportApply(){
		$this->check_logined();
		header("Content-type:application/octet-stream");
    	header("Accept-Ranges:bytes");
    	header("Content-type:application/vnd.ms-excel");
    	header("Content-Disposition:attachment;filename=课程申报表.xls");
		header("Pragma:no-cache");
		header("Expires:0");
		$m = M('Apply_course');
		$condition['status'] = "已通过";
    	$arr = $m->where($condition)->select();
		$this->assign('data',$arr);
		$this->display();
	}
}
?>