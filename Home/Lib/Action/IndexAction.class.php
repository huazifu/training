<?php
//以下为用户端
class IndexAction extends Action{
    public function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
    }
    public function index(){
    	$url=U("login");
    	header("Location:$url");
    }
    public function login(){    //登录模块
        $m=M('Info');
        $arr=$m->where('id=1')->getField('loginInfo');
    	$this->assign('data',$arr);
        $this->display();
    }
    public function check_login(){  //判断是否登录成功
    	session_start();
		if($_POST['username']=='admin'){
			$user=M('Admin');
    		if(!$data=$user->create()){
    			$this->error("登录失败");
    		}
    		$condition['username']=$data['username'];
    		$us=$user->where($condition)->find();
    		if(!$us){ $this->error("用户名或者密码错误！！");}
    		if($us['password']!=md5($data['password'])){$this->error("用户名或者密码错误！！");}
    		$_SESSION['username']=$data['username'];
    		$this->assign("jumpUrl",'__ROOT__/admin.php');
    		$this->success("登录成功");	
		}else{
    		$user=M('User');
			$condition['name']=$_POST['username'];
        	$url=U("user");
    		$us=$user->where($condition)->find();
    		if(!$us){ $this->error("用户名或者密码错误！！");}
    		if($us['password']==$_POST['password']){
        	    $_SESSION['username']=$_POST['username'];
    		    $this->assign("jumpUrl",$url);
    		    $this->success("登录成功");
        	}else{
        	    $this->error("用户名或者密码错误！！");
        	}
		}
    }
    public function checkUser_logined(){       //检测是否已经登录
    	session_start();
    	$user=M('User');
    	$condition['name']=$_SESSION['username'];
    	$us=$user->where($condition)->find();
        if(!$us){$url=U('login');$this->assign("jumpUrl",$url);$this->error("还没有登录！！");}
    }
    public function admin_exit(){
    	unset($_SESSION['username']);
        $url=U("login");
    	$this->assign("jumpUrl",$url);
    	$this->success("退出成功");
    }
	
    public function user(){        //用户首页
    	$this->checkUser_logined();
    	session_start();
    	$user=M('User');
    	$us=$user->where("name='$_SESSION[username]'")->find();
    	$username=$us['name'];
    	$date=date("Y年m月d日",time());
    	$this->assign('date',$date);
    	$this->assign('username',$username);
    	$this->display();
    }

    public function editUserPassword(){      //修改用户密码
    	$this->checkUser_logined();
		//获取user表查看密码
		$user=M('User');
		$password=$user->where("name='$_SESSION[username]'")->getField("password");
		$this->assign('password_data',$password);
		$admin=$user->where("name='$_SESSION[username]'")->getField("admin");
		$this->assign('admin',$admin);
    	$this->display();
    }

	public function editNewPassword(){		//修改初始密码
		$this->checkUser_logined();
    	$this->display();
	}
	//更改用户密码操作
    public function updateUserPassword(){
    	$this->checkUser_logined();
    	session_start();
    	$user=M("User");
    	$oldpass=$_POST['oldpass'];
    	$condition['password']=$oldpass;
    	if(!$userInfo=$user->where($condition)->select()) $this->error("旧密码错误");
    	$newpass=$_POST['newpass'];
    	$condition['name']=$_SESSION['username'];
    	$data['password']=$newpass;
		$count=$user->where($condition)->save($data);
		if($count>0){
			$this->success("修改成功","sign_up");
		}elseif($count==0){
			$this->error("新旧密码相同！");
		}else{
			$this->error("修改失败");
		}
    }
	//更改新用户密码操作
	public function updateNewPassword(){
    	$this->checkUser_logined();
    	session_start();
    	$user=M("User");
    	$newpass=$_POST['newpass'];
    	$condition['name']=$_SESSION['username'];
    	$data['password']=$newpass;
    	$count=$user->where($condition)->save($data);
		if($count>0){
			$this->success("修改成功","sign_up");
		}elseif($count==0){
			$this->error("新旧密码相同！");
		}else{
			$this->error("修改失败");
		}
    }

	 //get报名表
	public function sign_up(){    
    	$this->checkUser_logined();
		session_start();
		import('ORG.Util.Date');
    	$course = M("Course");
		$date = new DateTime;
		$nowtime = $date->format("Y-m-d");
		$tonow = strtotime($nowtime);
    	$course_info = $course->where("tostart>=$tonow")->select();
		$this->assign("course_info",$course_info);
		//get密码
		$user=M('User');
		$password=$user->where("name='$_SESSION[username]'")->getField("password");
		$this->assign('password_data',$password);
		$admin=$user->where("name='$_SESSION[username]'")->getField("admin");
		$this->assign('admin',$admin);
    	$this->display();
	}

	//异步根据课程获取报名
	public function getCourseMessage(){
		$this->checkUser_logined();
		$m = M("Course");
		$condition['num'] = $_GET['courseNum'];
		$data = $m->where($condition)->find();
    	$this->ajaxReturn($data,"有数据",1);
	}

	//提交报名表
	public function uploadform(){
		$this->checkUser_logined();
		session_start();
		import('ORG.Util.Date');
		$date = new DateTime;
		$nowtime=$date->format("Y-m-d h:m:s");
		$tonow=strtotime($nowtime);
		$s = M('Course');
		$condition1['num'] = $_POST['course'];
		$courseName = $s->where($condition1)->getField('name');
		$todeadline = $s->where($condition1)->getField('todeadline');
		$u =M('User');
		$condition2['name'] = $_SESSION['username'];
		$schoolNum = $u->where($condition2)->getField('usernum');
		if($todeadline>=$tonow){
			// $s->where($condition)->setInc('selectedMan',1);
			//提交报名表
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
			$m->school = $_SESSION['username'];
			$m->course_num = $_POST['course'];
			$m->selectedCourse = $courseName;
			$idNum = $m->add();
			if($idNum>0){
				$this->success('提交成功，请等待管理员审核');
			}else{
				$this->error('提交失败');
			}
		}else{
			$this->error("提交失败，该培训班报名已截止！");
		}
	}
	 
	//班主任信息
	public function getTeacherInfo(){
		$this->checkUser_logined();
		$m = M("Course");
		$condition['id'] = $_GET['id'];
		$data = $m->where($condition)->find();
    	$this->ajaxReturn($data,"班主任信息",1);
	}
	//管理员信息
	public function administrator(){
		$this->checkUser_logined();
		session_start();
		$m = M("User");
		$condition['name'] = $_SESSION['username'];
		$data = $m->where($condition)->find();
		$this->assign("data",$data);
		//获取user表查看密码
		$user=M('User');
		$password=$user->where("name='$_SESSION[username]'")->getField("password");
		$this->assign('password_data',$password);
		$admin=$user->where("name='$_SESSION[username]'")->getField("admin");
		$this->assign('admin',$admin);
		$this->display();
	}
	//修改管理员信息
	public function editAdmin(){
		$this->checkUser_logined();
		session_start();
		$m = M("User");
		$condition['name'] = $_SESSION['username'];
		$data['admin'] = $_POST['admin'];
		$data['department'] = $_POST['department'];
		$data['mobile'] = $_POST['mobile'];
		$data['tel'] = $_POST['tel'];
		$count = $m->where($condition)->save($data);
		if($count>0){
			$this->success('修改成功！');
		}else{
			$this->error('修改失败！');
		}
	}
	//查报名状态
	public function checked(){
		$this->checkUser_logined();
        session_start();
		$m=M('Signed_up');
		$arr=$m->select();
		$a=$m->where("school='$_SESSION[username]'")->select();
		$checked_info=$m->where("user_id='$_SESSION[userid]'")->select();
        for($i=0;$i<count($checked_info);$i++)
             $course_id[$i]=$checked_info[$i]['course_id'];
        $export=0;
        if(count($checked_info)>0) $export=1;
        $this->assign("export",$export);
		$this->assign('data',$a);
		//获取user表查看密码
		$user=M('User');
		$password=$user->where("name='$_SESSION[username]'")->getField("password");
		$this->assign('password_data',$password);
		$admin=$user->where("name='$_SESSION[username]'")->getField("admin");
		$this->assign('admin',$admin);
		$this->display();
	}
	
	//用户获取审核失败原因
	public function failSign_Info(){
		$this->checkUser_logined();
		$m=M('Signed_up');
		$idNum=$_GET['idNum'];
		$data=$m->where("idNum='$idNum'")->find();
		$this->assign('data',$data);
		$this->display();
	}
	//返回重新申请
	public function returnSign(){
		$this->checkUser_logined();
		$m=M('Signed_up');
		$s=M('Course');
		$condition1['idNum'] = $_GET['idNum'];
		$course_num=$m->where($condition1)->getField('course_num');
		$condition2['num'] = $course_num;
		$s->where($condition2)->setDec('selectedMan',1);
		$idNum=$_GET['idNum'];
		$count=$m->delete($idNum);
		if($count>0){
			$this->redirect("sign_up");
		}else{
			$this->error("数据删除失败");
		}
	}
	//用户退选培训
	public function quitCourse(){
		$this->checkUser_logined();
		//对应培训selecteMan加-1
		import('ORG.Util.Date');
		$date = new DateTime;
		$nowtime=$date->format("Y-m-d h:m:s");
		$tonow=strtotime($nowtime);
		$condition1['num'] = $_GET['num'];
		$s=M('Course');
		$todeadline=$s->where($condition1)->getField('todeadline');
		if($todeadline>=$tonow){
			$s->where($condition1)->setDec('selectedMan',1);
			//移除申请
			$m=M('Signed_up');
			$idNum=$_GET['idNum'];
			$count=$m->delete($idNum);
			if($count>0){
				$this->success("退选成功");
			}else{
				$this->error("退选失败");
			}
		}else{
			$this->error("报名已截止，退选失败！");
		}
	}
}
?>