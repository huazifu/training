<?php
//以下为用户端
class IndexAction extends Action{
    public function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
    }
    public function index(){
    	$url = U("courseLogin");
    	header("Location:$url");
	}
	//登录模块
    public function courseLogin(){
        $this->display();
	}
	//显示注册模块
	public function register(){
		$this->display();
	}
	//验证码
	public function getCode(){
		$mobile = $_GET['userid'];
		$host = "http://211.147.239.62:9050/cgi-bin/sendsms?";
		$code = rand(100000,999999);
		$content = '您的验证码是：' . $code;
		$content_GBK = iconv( "UTF-8", "GBK", $content);
    	$querys = "username=jy@bjhg&password=E053OkHU&to=" . $mobile . "&text=" . $content_GBK . "&subid=&msgtype=4";
    	$url = $host . $querys;

    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_HEADER,0);
		$output = curl_exec($curl);
		curl_close($curl);
		if($output == 0){
			$us = M('Course_user');
			$condition['userid'] = $mobile;
			$userid = $us->where($condition)->getField('userid');
			if(!$userid){
				$us->userid = $mobile;
				$us->add();
				$data['code'] = $code;
				$us -> where($condition) -> save($data);
			}else{
				$data['code'] = $code;
				$us -> where($condition) -> save($data);
			}
		}
		$this->ajaxReturn($output,"已发送",1);
	}
	//注册操作
	public function sign_up(){
		$us = M('Course_user');
		$condition['userid'] = $_POST['userid'];
		$userid = $us->where($condition)->getField('userid');
		$pass = $us->where($condition)->getField('pass');
		$code = $us->where($condition)->getField('code');
		if(!$userid){$this->error('注册失败！请重新获取验证码！');}
		if(!$code){$this->error('注册失败！请重新获取验证码！');}
		if( $userid && $pass && $code != 0){
			$this->error('该号码已经被注册！');
		}else{
			if($code == $_POST['code']){
				$data['pass'] = $_POST['pass'];
				$count = $us->where($condition)->save($data);
				if($count>0){
					$url = U("courseLogin");
					$this->success('注册成功',$url);
				}else{
					$this->error('注册失败');
				}
			}
		}
	}
	//找回密码模块
    public function returnPassword(){
        $this->display();
	}
	//密码重设
	public function replayPassword(){
		$us = M('Course_user');
		$condition['userid'] = $_POST['userid'];
		$userid = $us->where($condition)->getField('userid');
		if(!$userid){$this->error('注册失败！请重新获取验证码！');}
		$code = $us->where($condition)->getField('code');
		if($code == $_POST['code']){
			$data['pass'] = $_POST['pass'];
			$count = $us->where($condition)->save($data);
			if($count>0){
				$url = U("courseLogin");
				$this->success('重设密码成功！',$url);
			}else{
				$this->error('重设密码失败！');
			}
		}

	}
	//判断是否登录成功
    public function check_login(){
    	session_start();
		if( $_POST['userid'] == 'admin' ){
			$user = M('Admin');
    		$condition['username'] = $_POST['userid'];
    		$us = $user->where($condition)->find();
    		if( !$us ){ $this->error( "用户名或者密码错误！！" ); }
    		if( $us['password'] != md5($_POST['pass']) ){ $this->error("用户名或者密码错误！！"); }
    		$_SESSION['username'] = $_POST['userid'];
    		$this->assign( "jumpUrl" , '__ROOT__/admin.php' );
    		$this->success( "登录成功" );	
		}else{
    		$user = M('Course_user');
			$condition['userid'] = $_POST['userid'];
        	$url = U("courseUser");
    		$us = $user->where($condition)->find();
    		if( !$us ){ $this->error( "用户名或者密码错误！！" ); }
    		if( $us['pass'] == $_POST['pass'] ){
        	    $_SESSION['userid'] = $_POST['userid'];
    		    $this->assign( "jumpUrl",$url );
    		    $this->success( "登录成功" );
        	}else{
        	    $this->error( "用户名或者密码错误！！" );
        	}
		}
	}
	//检测是否已经登录
    public function checkUser_logined(){
    	session_start();
    	$user = M('Course_user');
    	$condition['userid'] = $_SESSION['userid'];
    	$us = $user->where($condition)->find();
        if(!$us){$url=U('courseLogin');$this->assign("jumpUrl",$url);$this->error("还没有登录！！");}
    }
    //退出
    public function admin_exit(){
    	unset($_SESSION['userid']);
        $url = U("courseLogin");
    	$this->assign( "jumpUrl" , $url);
    	$this->success("退出成功");
    }
	//征集系统用户首页
    public function courseUser(){
    	$this->checkUser_logined();
    	session_start();
		$user = M('Course_user');
		$condition['userid'] = $_SESSION['userid'];
    	$us = $user->where($condition)->find();
    	$userid = $us['userid'];
    	$date = date("Y年m月d日",time());
    	$this->assign('date',$date);
    	$this->assign('userid',$userid);
    	$this->display();
    }

	//更改用户密码操作
    public function updateUserPassword(){
    	$this->checkUser_logined();
    	session_start();
    	$user = M("Course_user");
    	$oldpass = $_POST['oldpass'];
    	$condition['pass'] = $oldpass;
    	if(!$userInfo = $user->where($condition)->select()) $this->error("旧密码错误");
    	$newpass = $_POST['newpass'];
    	$condition['userid'] = $_SESSION['userid'];
    	$data['pass'] = $newpass;
		$count = $user->where($condition)->save($data);
		if($count > 0){
			$this->success("修改成功","courseUser");
		}elseif($count == 0){
			$this->error("新旧密码相同！");
		}else{
			$this->error("修改失败");
		}
    }

	 //get申报表
	 public function applyCourse(){    
    	$this->checkUser_logined();
		session_start();
		$userid = $_GET['userid'];
		$this->assign('userid',$userid);
    	$this->display();
	}
	//提交课程申报表
	public function uploadApplyCourse(){
		$this->checkUser_logined();
		session_start();
		$app = M('Apply_course');
		// $m->userid = $_SESSION['userid'];
		$app->userid = $_POST['userid'];
		$app->name = $_POST['name'];
		$app->sex = $_POST['sex'];
		$app->year = $_POST['year'];
		$app->nation = $_POST['nation'];
		$app->politic = $_POST['politic'];
		$app->edulevel = $_POST['edulevel'];
		$app->company = $_POST['company'];
		$app->job = $_POST['job'];
		$app->jobtitle = $_POST['jobtitle'];
		$app->phone = $_POST['phone'];
		$app->mobile = $_POST['mobile'];
		$app->mail = $_POST['mail'];
		$app->coursename = $_POST['coursename'];
		$app->category = $_POST['category'];
		$app->direction = $_POST['direction'];
		$app->outline = $_POST['outline'];
		$app->explain = $_POST['explain'];
		$app->resume = $_POST['resume'];
		import('ORG.Util.Date');
		// $uptime = date("Y-m-d H:i:s",time());
		$app->uptime = date("Y-m-d H:i:s",time());
		$count = $app->add();
		if($count){
    		$this->success("提交成功");
    	}else{
			$this->error("提交失败");
		}
	}

	//申报课程审核状态
	public function applyStatus(){
		$this->checkUser_logined();
		session_start();
		$m = M('Apply_course');
		// $count = $m -> count();
    	// $listRows = 15;
        // import("ORG.Util.Page");
        // $p = new Page($count,$listRows);
        // $limit_options = $p->firstRow.",".$p->listRows;
		$condition['userid'] = $_SESSION['userid'];
		$arr = $m->where($condition)->select();
        // $displaypage = 0;
    	// if(count($arr) > 0) $displaypage = 1;
    	// $page = $p->show();
    	// $this -> assign("displaypage",$displaypage);
    	// $this -> assign("page",$page);
    	// $this -> assign("pagestyle","green-black");
		$this->assign('data',$arr);
		$this->display();
	}
	//修改审核课程页面
	public function modifyApply(){
		$this->checkUser_logined();
		session_start();
		$condition['id'] = $_GET['id'];
		$m = M('Apply_course');
		$data = $m->where($condition)->find();
		$this->assign('data',$data);
		$this->display();
	}
	//提交修改
	public function uploadApplyModify(){
		$this->checkUser_logined();
		session_start();
		$m = M('Apply_course');
		$data['name'] = $_POST['name'];
		$data['sex'] = $_POST['sex'];
		$data['year'] = $_POST['year'];
		$data['nation'] = $_POST['nation'];
		$data['politic'] = $_POST['politic'];
		$data['edulevel'] = $_POST['edulevel'];
		$data['company'] = $_POST['company'];
		$data['job'] = $_POST['job'];
		$data['jobtitle'] = $_POST['jobtitle'];
		$data['phone'] = $_POST['phone'];
		$data['mobile'] = $_POST['mobile'];
		$data['mail'] = $_POST['mail'];
		$data['coursename'] = $_POST['coursename'];
		$data['category'] = $_POST['category'];
		$data['direction'] = $_POST['direction'];
		$data['outline'] = $_POST['outline'];
		$data['explain'] = $_POST['explain'];
		$data['resume'] = $_POST['resume'];
		$data['status'] = "待审核";
		import('ORG.Util.Date');
		$uptime = date("Y-m-d H:i:s",time());
		$data['uptime'] = $uptime;
		$condition['id'] = $_POST['id'];
		$count = $m->where($condition)->save($data);
		if($count >= 0){
			$this->success('修改成功','__URL__/applyStatus');
		}else{
			$this->error('修改失败');
		}

	}
	//课程审核失败通知
	public function failApply(){
		$this->checkUser_logined();
		session_start();
		$condition['id'] = $_GET['id'];
		$m = M('Apply_course');
		$data = $m->where($condition)->find();
		$this->assign('data',$data);
		$this->display();
	}
	
}