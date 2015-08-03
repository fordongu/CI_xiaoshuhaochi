<?php

class User_service extends MY_Service {

    public function __construct() {
        $this->load->helper('cookie');
        $this->load->model('User_model');
         $this->load->helper("cookie");
    }

    public function userLogin($username="", $password="" ,$remember_flag="") {
        
        $user = $this->User_model->findUserByUsername($username);
          
        if ($user && $user->tu_password == md5(md5('xiaoshu'.$password))) {
            
            if ($remember_flag==1) {
                
                $this->input->cookie("remember_flag", $password, time() + 3600 * 24);
         
            }else if ($remember_flag==0) {
                
                setcookie("remember_flag", "", time() - 1);
                
            }
            
            $sql="select * from t_users where tu_mobile=?";
            
            $user=$this->db->query($sql, array($username))->row();
            
            setcookie('user_cookie',serialize($user), time()+3600*24*365,'/',".xiaoshuhaochi.com");
            
            return array("success"=>"yes", "msg"=>"登陆成功");
            
        }else{
            
            return array("success"=>"no", "msg"=>"密码错误");
            
        }
        
    }

    public function getUid() {
       
        $user_cookie = isset($_COOKIE['user_cookie']) ? $_COOKIE['user_cookie'] : '';

        if ($user_cookie) {
            $user_cookie = unserialize($user_cookie);
            return $user_cookie->tu_id;
        } else {

            $temp_user_data = array('tu_user_type' => 1, 'tu_created' => date('Y-m-d H:i:s'), 'tu_nickname' => '游客');
            $result = $this->db->insert('users', $temp_user_data);
            $id = $this->db->insert_id();
            $sql = "select * from t_users where tu_id=?";
            $user = $this->db->query($sql, array($id))->result();
            set_cookie('user_cookie', serialize($user[0]), time() + 3600 * 24);
            return $result;
        }
    }

    /*
     * 
     * 用户注册
     * 
     * $mobile手机号码
     * $password 密码
     * $code 验证码
     * $type reg
     * @return arr
     */

    public function userRister($username="", $password="", $code="", $type="") {
       
        $sql="SELECT * FROM t_users WHERE tu_mobile=? ";
        $check_user=$this->db->query($sql,$username)->row();
      
        
        if (isset($check_user)){
            
            return array("success"=>"no", "msg"=>"该手机号码已经注册过");
            
        }
        
        $check = $this->checkMobileCode($username, $code);
        $md5_password = md5(md5('xiaoshu'.$password));
        
        if ($check["success"]=="no") {
            
            return $check;
            
        }else if ($check["success"]=="yes"&&$type="reg") {
            
           $uid=$this->getUid();
           
           $data=array( 
               
               "tu_mobile"=>$username,
               "tu_password"=>$md5_password,
               "tu_created"=>date("Y-m-d H:i:S")
               
           );
                             
                $reslut = $this->db->update("users", $data, array("tu_id"=>$uid));
          
                $sql="select * from t_users where tu_id=?";
                $user=$this->db->query($sql,array($uid))->row();
                setcookie('user_cookie',serialize($user),time()+3600*24*365,'/');
                //set_cookie('remember_password',$remember_flag,time()+3600*24*365,'/');
                
           
           if ($reslut){
               
               return array("success"=>"yes", "msg"=>"注册成功");
               
           }else{
               
               return array("success"=>"error", "msg"=>"注册失败请联系管理员");
               
           }
            
            
        }
        
    }

    /*
     * 
     * 发送验证码
     * 
     * $mobile手机号码
     * $check  0注册，1找回密码
     * @return arr
     */

    public function dosendSms($mobile = "", $check = "") {

        $user_check = $this->User_model->sendSmsCheck($mobile, $check);
       
        if ($user_check["success"] == "used") {
               return $user_check;
        } else if ($user_check["success"] == "time_limit") {
            return $user_check;
        } else if ($user_check["success"] == "yes") {
            $code = $this->generateCode(6);
            $msg_template = "【小树好吃】您的验证码是：" . $code; //$msg[0]->tc_content; 
            $res = $this->sendSms($mobile, $msg_template);
            if (!$res) {
                $msg = array('success' => 'send_error', 'msg' => '发送失败');
                return $msg;
            } else {
                $code_data = array('tmc_mobile' => $mobile, 'tmc_code' => $code, 'tmc_created' => time());
                $this->db->insert('mobile_codes', $code_data);
                $msg = array('success' => 'send_yes', 'msg' => '发送成功');
                return $msg;
            }
        }
       
    }

    /*
     * 
     * 验证码检测
     * 
     * $mobile手机号码
     * $code验证码
     * @return json
     */

    public function checkMobileCode($mobile="", $code="") {
        
        $chek_time=strtotime("- 10min");
        $check = $this->User_model->checkMobileCode($mobile);
        
        if (!$check) {
            
            $res = array('success' => 'no', 'msg' => '无效的验证码');
            return $res;
            
        }else if ($check->tmc_created<$chek_time){
            
            $res= array('success' => 'no', 'msg' => '验证码超时');
            return $res;
            
        }else if($check->tmc_created>$chek_time){          
            
            if (trim($code)==trim($check->tmc_code)){
               
                $res= array('success' => 'yes', 'msg' => '验证成功');
                return $res;  
                
            }else{
                
                $res= array('success' => 'no', 'msg' => '验证码错误');
                return $res;  
                           
            }
            
        }
        
    }

    public function generateCode($len = 20) {
        if ($len == 12) {
            $chars = '0123456789';
        } else {
            $chars = '0123456789';
        }
        for ($i = 0, $count = strlen($chars); $i < $count; $i++) {
            $arr[$i] = $chars[$i];
        }

        mt_srand((double) microtime() * 1000000);
        shuffle($arr);
        $code = substr(implode('', $arr), 0, $len);
        return $code;
    }

    private function sendSms($mobile, $content) {
        require_once APPPATH . 'libraries/sms/Client.php';
        //$sms_config = $this->tickets->select('configs',array('tc_type'=>'sms_config'));
        $sql = "select * from t_configs where 1=1 and tc_type='sms_config'";
        $sms_config = $this->db->query($sql)->row();

        if (!$sms_config) {
            return false;
        } else {
            $config = $sms_config;
        }
        /**
         * 网关地址
         */
        $gwUrl = 'http://sdk4report.eucp.b2m.cn:8080/sdk/SDKService';

        /**
         * 序列号,请通过亿美销售人员获取
         */
        $serialNumber = $config->tc_title; //'6SDK-EMY-6688-KGZSP';

        /**
         * 密码,请通过亿美销售人员获取
         */
        $password = $config->tc_content; //'845379';

        /**
         * 登录后所持有的SESSION KEY，即可通过login方法时创建
         */
        $sessionKey = '123456';

        /**
         * 连接超时时间，单位为秒
         */
        $connectTimeOut = 2;

        /**
         * 远程信息读取超时时间，单位为秒
         */
        $readTimeOut = 10;

        $proxyhost = false;
        $proxyport = false;
        $proxyusername = false;
        $proxypassword = false;

        $client = new Client($gwUrl, $serialNumber, $password, $sessionKey, $proxyhost, $proxyport, $proxyusername, $proxypassword, $connectTimeOut, $readTimeOut);
        /**
         * 发送向服务端的编码，如果本页面的编码为GBK，请使用GBK
         */
        $client->setOutgoingEncoding("utf8");
        $statusCode = $client->login();
     
        $statusCode = $client->sendSMS(array($mobile), $content);
        if ($statusCode == 0) {
            return true;
        } else {
            return false;
        }
    }
    public function loginOut(){
       
        $res = setcookie('user_cookie','',time()-1,'/', ".xiaoshuhaochi.com");

   
        if ($res) {
            return array("success"=>"yes", "msg"=>"退出成功");
        }else {
            return array("success"=>"no", "msg"=>"删除错误");
        }
    }
    public function changPassword($username="", $password="") {
       
        if (!(empty($username))&&!(empty($password))) {
           
            $md5_password =  md5(md5('xiaoshu'.$password));
         
            $sql="UPDATE t_users SET tu_password = ? WHERE tu_mobile = ? LIMIT 1";
          //  $res =  $this->db->query($sql, array($md5_password, $username));
            $res =  $this->db->query($sql, array($md5_password, $username));
            
            if($res) {
                $r = array("success"=>"yes", "msg"=>"修改成功");
                return $r;
                
            }else{
                $r = array("success"=>"no", "msg"=>"修改失败");
                return $r;
            }
          
        }
        
    }
      /*
     * 
     * 订单查找
     * 
     * 通过UID查找订单
     * 
     * @return arr
     */
    public function findOrder ($uid="") {
        
        $order=$this->User_model->findOrder($uid);
        if ($order) {
            
            return array("success"=>"yes", "msg"=>$order->to_id);
        }else {
            
            return array("success"=>"no", "msg"=>"no");
        }
    }
}
