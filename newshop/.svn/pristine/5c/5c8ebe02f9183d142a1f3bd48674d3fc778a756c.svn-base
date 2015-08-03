<?php

class User_model extends CI_Model {

    public function findUserByUsername($username) {
        $sql = 'SELECT * FROM t_users WHERE tu_mobile = ? LIMIT 1';
        $query = $this->db->query($sql, array($username));
        $user = $query->first_row();
        return $user;
    }

    /*
     * 
     * 用户注册
     * 
     * 
     *
     * @return arr 
     */

    public function userRister() {


        $user_data = array(
            'tu_password' => md5(md5('xiaoshu' . $password)),
            'tu_created' => date("Y-m-d H:i:s")
        );
        if (!$reg_type) {
            $captcha = trim($this->input->post('captcha'));
            $verify_result = $this->check_mobile_code($mobile_email, $captcha);
            if ($verify_result) {
                $user_data['tu_mobile'] = $mobile_email;
            }

            $user_check = $this->tickets->select('users', array('tu_mobile' => $mobile_email));
            if ($user_check) {
                echo json_encode(array('success' => 'no', 'msg' => '此手机已经注册过'));
                exit;
            }
        } else {
            $user_data['tu_email'] = $mobile_email;
            $user_check = $this->tickets->select('users', array('tu_email' => $mobile_email));
            if ($user_check) {
                echo json_encode(array('success' => 'no', 'msg' => '此电子邮件已经注册过'));
                exit;
            }
        }

        $result = $this->tickets->insert('users', $user_data);
        if ($result) {
            $temp_user = $this->tickets->select('users', array('tu_id' => $result));
            setcookie('user_cookie', serialize($temp_user[0]), time() + 3600 * 24, '/');
            echo json_encode(array('success' => 'yes', 'msg' => '注册成功'));
            exit;
        } else {
            echo json_encode(array('success' => 'no', 'msg' => '注册失败'));
            exit;
        }
    }

    /*
     * 
     * 验证码检查
     * 
     * $mobile=手机号码
     * $code=验证码
     * @return obj 
     */

    public function checkMobileCode($mobile="") {
        
       $sql="select * from t_mobile_codes where tmc_mobile=? order by tmc_created desc limit 1";             
       $check=$this->db->query($sql, array($mobile))->row();
       return $check;
       
    }

    /*
     * 
     * 发送验证码
     * 
     * $mobile=手机号码
     * $code=验证码
     * @return arr 
     */

     public function sendSmsCheck($mobile="",$check="") {
         if(empty($mobile)){
             return array("success" => "error", "msg" => "error");
         }
        $sql = "select tu_mobile from t_users where tu_mobile=?";
        $user_check = $this->db->query($sql, array($mobile))->row();
        if (isset($user_check)&&$check==0) {
            return array("success" => "used", "msg" => $user_check);
        }else{
           $check_time=strtotime("-1 min");
           $sql="select * from t_mobile_codes where tmc_mobile=? and tmc_created>= ?";
           $result = $this->db->query($sql,array($mobile,$check_time))->row();
           if(isset($result)){
             return array("success" => "time_limit", "msg" => "请一分钟后再试");
           }else{
               
           return array("success" => "yes");
        }
           
        }
    }
    public function findOrder($uid="") {
        
        $sql="SELECT to_id FROM t_orders WHERE 1=1 AND to_uid=? limit 1;";
        $order =  $this->db->query($sql, array($uid))->row();
        return $order;
    }
}
